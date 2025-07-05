<?php

namespace App\Console\Commands;

use App\Models\RgpTransaction;
use App\Models\User;
use App\Models\UserPlan;
use App\Services\RgpTransactionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RecalculateRgpPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rgp:recalculate 
                            {--debug : Show detailed debug information} 
                            {--check-only : Only check for existing transactions without recalculating}
                            {--preserve : Preserve existing transactions while recalculating}
                            {--reset-date= : Date from which to consider points were reset (format: Y-m-d)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate RGP points for all users and create appropriate transaction records';

    /**
     * @var RgpTransactionService
     */
    protected $rgpTransactionService;

    /**
     * Create a new command instance.
     *
     * @param RgpTransactionService $rgpTransactionService
     */
    public function __construct(RgpTransactionService $rgpTransactionService)
    {
        parent::__construct();
        $this->rgpTransactionService = $rgpTransactionService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $debug = $this->option('debug');
        $checkOnly = $this->option('check-only');
        $preserve = $this->option('preserve');
        $resetDate = $this->option('reset-date');
        
        $this->info('Starting RGP points recalculation...');

        if ($debug) {
            $this->info('Debug mode enabled - showing detailed information');
        }

        if ($resetDate) {
            $this->info("Reset date specified: {$resetDate}");
            try {
                $resetDateTime = new \DateTime($resetDate);
                $this->info("Will consider points were reset after: " . $resetDateTime->format('Y-m-d H:i:s'));
            } catch (\Exception $e) {
                $this->error("Invalid reset date format. Please use Y-m-d format.");
                return 1;
            }
        }

        if ($checkOnly) {
            return $this->checkExistingTransactions();
        }
        
        // Check if manage_plans table has the eligible_for_rgp column
        if (!Schema::hasColumn('manage_plans', 'eligible_for_rgp')) {
            $this->error("The manage_plans table is missing the 'eligible_for_rgp' column.");
            if (!$this->confirm('Do you want to continue anyway? (This may result in incorrect RGP calculations)', false)) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }
        
        // Check if there are any active eligible plans
        $this->info('Checking for active eligible plans...');
        $activePlanCount = UserPlan::where('is_active', true)
            ->whereHas('plan', function($query) {
                $query->where('eligible_for_rgp', 1);
            })
            ->count();
            
        if ($activePlanCount == 0) {
            $this->error('No active eligible plans found. Cannot calculate RGP points.');
            if (!$this->confirm('Do you want to continue anyway?', false)) {
                $this->info('Operation cancelled.');
                return 0;
            }
        } else {
            $this->info("Found {$activePlanCount} active eligible plans.");
        }

        // Confirm before proceeding
        $confirmMessage = "This will recalculate RGP points for all users and create appropriate transaction records. Are you sure?";
            
        if (!$this->confirm($confirmMessage, true)) {
            $this->info('Operation cancelled.');
            return 0;
        }

        // Check if required tables exist
        if (!Schema::hasTable('rgp_transactions')) {
            $this->error('The rgp_transactions table does not exist. Please run migrations first.');
            return 1;
        }

        // Check if user table has required columns
        if (!Schema::hasColumn('users', 'rgp_l') || !Schema::hasColumn('users', 'rgp_r')) {
            $this->error('The users table is missing required RGP columns. Please check your database schema.');
            return 1;
        }

        try {
            // Get a backup of current RGP values for all users if needed for recovery
            if ($preserve) {
                $this->info('Backing up current RGP values...');
                $userRgpBackup = User::select('id', 'username', 'rgp_l', 'rgp_r', 'rgp_pair_matching')->get()
                    ->keyBy('id')
                    ->map(function($user) {
                        return [
                            'username' => $user->username,
                            'rgp_l' => floatval($user->rgp_l ?? 0),
                            'rgp_r' => floatval($user->rgp_r ?? 0),
                            'rgp_pair_matching' => floatval($user->rgp_pair_matching ?? 0)
                        ];
                    });
            } else {
                $userRgpBackup = collect();
            }

            // Step 1: Reset all users' RGP points to zero
            $this->info('Resetting all users\' RGP points to zero...');
            User::query()->update([
                'rgp_l' => 0.00,
                'rgp_r' => 0.00,
                'rgp_pair_matching' => 0.00
            ]);

            // Step 2: Delete all existing RGP transactions if not preserving
            if (!$preserve) {
                $this->info('Deleting all existing RGP transactions...');
                RgpTransaction::truncate();
            } else {
                $this->info('Preserving existing RGP transactions as requested...');
            }

            // Step 3: Fetch all users
            $users = User::all();
            $totalUsers = $users->count();
            $this->info("Processing {$totalUsers} users...");

            $progressBar = $this->output->createProgressBar($totalUsers);
            $progressBar->start();

            $errorCount = 0;
            $transactionCount = 0;
            $usersWithPlans = 0;
            
            // Process each user
            foreach ($users as $user) {
                try {
                    // Step 4: Calculate RGP points from eligible plans
                    $userTransactions = $this->calculateRgpPointsFromPlans($user);
                    $transactionCount += $userTransactions;
                    
                    if ($userTransactions > 0) {
                        $usersWithPlans++;
                    }
                    
                    // Step 5: Deduct RGP points from matched profits
                    $transactionCount += $this->deductMatchedRgpPoints($user);
                    
                    // Step 6: Create a "reset recovery" transaction if points were significantly different
                    // Only do this if the --preserve flag is set
                    if ($preserve) {
                        $transactionCount += $this->createResetRecoveryTransactionIfNeeded($user, $userRgpBackup[$user->id] ?? null);
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error("Error processing user {$user->id}: " . $e->getMessage());
                    // Continue with next user
                }
                
                $progressBar->advance();
            }

            $progressBar->finish();
            $this->newLine();

            if ($errorCount > 0) {
                $this->warn("{$errorCount} users had errors during processing. Check the logs for details.");
            }

            // Step 7: Update RGP pair matching values for all users
            $this->info('Updating RGP pair matching values...');
            foreach ($users as $user) {
                try {
                    $user->updateRgpPairMatching()->save();
                } catch (\Exception $e) {
                    Log::error("Error updating RGP pair matching for user {$user->id}: " . $e->getMessage());
                }
            }

            $this->info("RGP points recalculation completed successfully!");
            $this->info("Created {$transactionCount} transactions for {$usersWithPlans} users with eligible plans.");
            return 0;
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            Log::error('RGP recalculation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Check for existing RGP transactions
     *
     * @return int
     */
    protected function checkExistingTransactions()
    {
        $this->info('Checking for existing RGP transactions...');
        
        $count = RgpTransaction::count();
        
        if ($count > 0) {
            $this->warn("Found {$count} existing RGP transactions.");
            
            // Get some sample transactions
            $sampleTransactions = RgpTransaction::with('user')
                ->latest()
                ->take(5)
                ->get();
                
            $this->info('Sample of recent transactions:');
            $headers = ['ID', 'User', 'Type', 'Side', 'Amount', 'Remarks', 'Date'];
            $rows = [];
            
            foreach ($sampleTransactions as $transaction) {
                $rows[] = [
                    $transaction->id,
                    $transaction->user ? $transaction->user->username : 'Unknown',
                    $transaction->transaction_type,
                    $transaction->side,
                    $transaction->amount,
                    $transaction->remarks,
                    $transaction->created_at->format('Y-m-d H:i:s')
                ];
            }
            
            $this->table($headers, $rows);
            
            if ($this->confirm('Do you want to proceed with recalculation?', false)) {
                return $this->handle();
            }
            
            $this->info('Operation cancelled.');
            return 0;
        } else {
            $this->info('No existing RGP transactions found.');
            
            if ($this->confirm('Do you want to proceed with recalculation?', true)) {
                return $this->handle();
            }
            
            $this->info('Operation cancelled.');
            return 0;
        }
    }

    /**
     * Calculate RGP points from eligible plans for a user
     *
     * @param User $user
     * @return int Number of transactions created
     */
    protected function calculateRgpPointsFromPlans(User $user)
    {
        try {
            $debug = $this->option('debug');
            
            // Get all plans purchased by the user that are active AND eligible for RGP
            $userPlans = UserPlan::where('user_id', $user->id)
                ->where('is_active', true)
                ->whereHas('plan', function($query) {
                    $query->where('eligible_for_rgp', 1);
                })
                ->with(['plan', 'user'])
                ->get();
            
            if ($debug) {
                $this->line("User ID: {$user->id}, Found " . count($userPlans) . " active eligible plans");
            }
            
            $transactionCount = 0;
            
            // Note: We don't need to reset points here as they're already reset in the handle method
            // We'll just start from the current values (which should be 0)
            $currentRgpL = floatval($user->rgp_l ?? 0);
            $currentRgpR = floatval($user->rgp_r ?? 0);

            foreach ($userPlans as $userPlan) {
                $plan = $userPlan->plan;
                
                if (!$plan) {
                    continue; // Skip if plan doesn't exist
                }
                
                // Calculate RGP points based on plan amount
                // For all plans, use 1% of plan amount
                $planAmount = floatval($plan->fixed_amount ?? 0);
                $rgpPoints = $planAmount * 0.01; // 1% of plan amount
                
                if ($debug) {
                    $this->line("  Plan ID: {$plan->id}, Price: {$planAmount}, RGP Points: {$rgpPoints}, Eligible: Yes");
                }
                
                if ($rgpPoints > 0) {
                    // Skip adding points directly to the purchasing user
                    // Only propagate up the RGP parent hierarchy
                    $transactionCount += $this->propagateRgpPointsToParents($user, $rgpPoints, $plan->id, $userPlan->created_at);
                }
            }
            
            return $transactionCount;
        } catch (\Exception $e) {
            $this->error('Error calculating RGP points from plans: ' . $e->getMessage());
            Log::error('RGP calculation error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return 0;
        }
    }
    
    /**
     * Propagate RGP points up the parent hierarchy
     *
     * @param User $user
     * @param float $points
     * @param int $planId
     * @param \DateTime|null $transactionDate
     * @return int Number of transactions created
     */
    protected function propagateRgpPointsToParents(User $user, float $points, int $planId, $transactionDate = null)
    {
        $debug = $this->option('debug');
        $transactionCount = 0;
        $currentUser = $user;
        
        // Use provided transaction date or current date
        $transactionDate = $transactionDate ?? now();
        
        if ($debug) {
            $this->line("  Propagating {$points} points up from user {$user->id}");
        }
        
        // Start with the user's RGP parent
        while ($currentUser->rgp_parent_id) {
            $parent = User::find($currentUser->rgp_parent_id);
            
            if (!$parent) {
                if ($debug) {
                    $this->line("  Parent not found for user {$currentUser->id}, stopping propagation");
                }
                break;
            }
            
            // Determine which side to add points to based on the referral_node
            $side = $currentUser->referral_node ?? 'left';
            
            // Use the points passed to the method
            $pointsToAdd = $points;
            
            if ($debug) {
                $this->line("  Adding {$pointsToAdd} points to parent {$parent->id} on {$side} side");
            }
            
            // Create transaction for the parent
            $transaction = $this->rgpTransactionService->createTransaction(
                $parent,
                'credit',
                $side,
                $pointsToAdd,
                "RGP points of {$pointsToAdd} credited to {$side} side from downline {$user->username}",
                'system',
                $user->id,
                $planId
            );
            
            // Set the created_at date to the transaction date
            if ($transaction) {
                $transaction->created_at = $transactionDate;
                $transaction->save();
                $transactionCount++;
            }
            
            // Get current point values
            $parentRgpL = floatval($parent->rgp_l ?? 0);
            $parentRgpR = floatval($parent->rgp_r ?? 0);
            
            // Update parent's RGP points based on which side the user is on
            if ($side === 'left') {
                $parent->rgp_l = $parentRgpL + $pointsToAdd;
            } else if ($side === 'right') {
                $parent->rgp_r = $parentRgpR + $pointsToAdd;
            }
            
            // Make sure to save the parent's updated RGP points
            $parent->save();
            
            // Move up to the next parent
            $currentUser = $parent;
        }
        
        return $transactionCount;
    }

    /**
     * Deduct RGP points from matched profits
     *
     * @param User $user
     * @return int Number of transactions created
     */
    protected function deductMatchedRgpPoints(User $user)
    {
        try {
            // Check if transactions table exists
            if (!Schema::hasTable('transactions')) {
                $this->warn("Transactions table does not exist, skipping matched profit deduction for user {$user->id}");
                return 0;
            }
            
            // Find transactions with "RGP matched profit" in the remarks
            // Each 10 Rs in amount field equals 1 RGP point to be deducted
            $matchedProfitTransactions = DB::table('transactions')
                ->where('user_id', $user->id)
                ->where('remarks', 'like', '%RGP matched profit%')
                ->get();

            $transactionCount = 0;
            
            foreach ($matchedProfitTransactions as $profitTx) {
                // Calculate RGP points to deduct (1 point = 10 Rs)
                $amountInRs = floatval($profitTx->amount ?? 0);
                $pointsToDeduct = $amountInRs / 10;
                
                // Ensure pointsToDeduct is a valid float
                $pointsToDeduct = floatval($pointsToDeduct);
                
                if ($pointsToDeduct > 0) {
                    // Get the original transaction date
                    $txDate = $profitTx->created_at ? new \DateTime($profitTx->created_at) : now();
                    
                    // Create a debit transaction
                    $transaction = $this->rgpTransactionService->createTransaction(
                        $user,
                        'match',
                        'both',
                        $pointsToDeduct,
                        "RGP points of {$pointsToDeduct} matched from both sides for profit withdrawal of {$amountInRs} Rs",
                        'system',
                        null,
                        null
                    );
                    
                    // Set the created_at date to the original transaction date
                    if ($transaction) {
                        $transaction->created_at = $txDate;
                        $transaction->save();
                        $transactionCount++;
                    }

                    // Update user's RGP points
                    $user->rgp_l = floatval($user->rgp_l) - $pointsToDeduct;
                    $user->rgp_r = floatval($user->rgp_r) - $pointsToDeduct;
                    
                    // Ensure values don't go below zero
                    $user->rgp_l = max(0, floatval($user->rgp_l));
                    $user->rgp_r = max(0, floatval($user->rgp_r));
                    $user->save();
                }
            }
            
            return $transactionCount;
        } catch (\Exception $e) {
            $this->error('Error deducting matched RGP points: ' . $e->getMessage());
            Log::error('RGP matched profit deduction error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            return 0;
        }
    }
    
    /**
     * Create a reset recovery transaction if needed
     *
     * @param User $user
     * @param array|null $backupValues
     * @return int Number of transactions created
     */
    protected function createResetRecoveryTransactionIfNeeded(User $user, ?array $backupValues)
    {
        if (!$backupValues) {
            return 0;
        }
        
        $debug = $this->option('debug');
        $currentRgpL = floatval($user->rgp_l);
        $currentRgpR = floatval($user->rgp_r);
        $backupRgpL = floatval($backupValues['rgp_l']);
        $backupRgpR = floatval($backupValues['rgp_r']);
        $username = $backupValues['username'] ?? $user->username ?? 'Unknown';
        
        // Check if backup values were significantly higher (indicating a reset occurred)
        $leftDiff = $backupRgpL - $currentRgpL;
        $rightDiff = $backupRgpR - $currentRgpR;
        
        if ($debug) {
            $this->line("User {$user->id}: Current L/R: {$currentRgpL}/{$currentRgpR}, Backup L/R: {$backupRgpL}/{$backupRgpR}");
            $this->line("Difference L/R: {$leftDiff}/{$rightDiff}");
        }
        
        $transactionCount = 0;
        $recoveryDate = now();
        
        // If backup values were significantly higher, create recovery transactions
        if ($leftDiff > 0) {
            if ($debug) {
                $this->line("Creating left recovery transaction for {$leftDiff} points");
            }
            
            // Create transaction for left side recovery
            $transaction = $this->rgpTransactionService->createTransaction(
                $user,
                'credit',
                'left',
                $leftDiff,
                "RGP points of {$leftDiff} recovered to left side for {$username} after reset",
                'system',
                null,
                null
            );
            
            if ($transaction) {
                $transaction->created_at = $recoveryDate;
                $transaction->save();
                $transactionCount++;
            }
            
            // Update user's left RGP points
            $user->rgp_l = $backupRgpL;
            $user->save();
        }
        
        if ($rightDiff > 0) {
            if ($debug) {
                $this->line("Creating right recovery transaction for {$rightDiff} points");
            }
            
            // Create transaction for right side recovery
            $transaction = $this->rgpTransactionService->createTransaction(
                $user,
                'credit',
                'right',
                $rightDiff,
                "RGP points of {$rightDiff} recovered to right side for {$username} after reset",
                'system',
                null,
                null
            );
            
            if ($transaction) {
                $transaction->created_at = $recoveryDate;
                $transaction->save();
                $transactionCount++;
            }
            
            // Update user's right RGP points
            $user->rgp_r = $backupRgpR;
            $user->save();
        }
        
        return $transactionCount;
    }

    /**
     * Add RGP points to a user and propagate up the RGP parent hierarchy
     *
     * @param User $user
     * @param float $points
     * @param int $planId
     * @param \DateTime|null $transactionDate
     * @return int Number of transactions created
     */
    protected function addRgpPointsToUser(User $user, float $points, int $planId, $transactionDate = null)
    {
        // This method is now replaced by direct calls in calculateRgpPointsFromPlans
        // Keeping it for backward compatibility
        $transactionCount = 0;
        
        // Skip adding points directly to the purchasing user
        // Only propagate points up the parent hierarchy
        $transactionCount += $this->propagateRgpPointsToParents($user, $points, $planId, $transactionDate);
        
        return $transactionCount;
    }
} 