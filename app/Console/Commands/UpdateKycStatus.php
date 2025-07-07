<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserKyc;

class UpdateKycStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kyc:update-status 
                            {--status=2 : Status to set (0=pending, 1=approved, 2=rejected)}
                            {--user=* : Specific user IDs to update}
                            {--reason=* : Rejection reason (required when status is 2)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update KYC verification status for users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $status = (int) $this->option('status');
        $userIds = $this->option('user');
        $reason = $this->option('reason') ? implode(' ', $this->option('reason')) : null;
        
        // Validate status
        if (!in_array($status, [0, 1, 2])) {
            $this->error('Invalid status. Must be 0 (pending), 1 (approved), or 2 (rejected).');
            return 1;
        }
        
        // Require reason for rejection
        if ($status === 2 && empty($reason)) {
            $reason = $this->ask('Please provide a rejection reason');
            if (empty($reason)) {
                $this->error('A rejection reason is required when setting status to rejected.');
                return 1;
            }
        }
        
        // Start query builder
        $query = UserKyc::query();
        
        // Filter by specific user IDs if provided
        if (!empty($userIds)) {
            $query->whereIn('user_id', $userIds);
        }
        
        // Get count before update for statistics
        $totalRecords = $query->count();
        
        if ($totalRecords === 0) {
            $this->warn('No matching KYC records found.');
            return 0;
        }
        
        // Confirm update
        if (!$this->confirm("Are you sure you want to update {$totalRecords} KYC record(s) to status {$status}?")) {
            $this->info('Operation cancelled.');
            return 0;
        }
        
        // Prepare update data
        $updateData = ['status' => $status];
        if ($status === 2 && !empty($reason)) {
            $updateData['reason'] = $reason;
        }
        
        // Perform the update
        $updatedCount = $query->update($updateData);
        
        // Output results
        $this->info("KYC Status Update Results:");
        $this->line("------------------------");
        $this->line("Total records processed: {$totalRecords}");
        $this->line("Records updated: {$updatedCount}");
        $this->info("Status: completed");
        
        return 0;
    }
} 