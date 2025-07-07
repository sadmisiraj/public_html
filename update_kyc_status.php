<?php

/**
 * Script to update status to 2 (rejected) in user_kycs table
 * 
 * This script can be run directly from the command line:
 * php update_kyc_status.php
 * 
 * Or you can include it in your project and call the function
 */

// Bootstrap the Laravel application
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

/**
 * Update KYC status to rejected (2)
 * 
 * @param int|array $userIds Optional user IDs to target specific users
 * @param string $reason Optional rejection reason
 * @return array Result statistics
 */
function updateKycStatusToRejected($userIds = null, $reason = 'KYC information incomplete or invalid')
{
    // Start query builder
    $query = \App\Models\UserKyc::query();
    
    // Filter by specific user IDs if provided
    if ($userIds !== null) {
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }
        $query->whereIn('user_id', $userIds);
    }
    
    // Get count before update for statistics
    $totalRecords = $query->count();
    
    // Perform the update - set status to 2 (rejected)
    $updatedCount = $query->update([
        'status' => 2,
        'reason' => $reason
    ]);
    
    // Return statistics
    return [
        'total_records' => $totalRecords,
        'updated_records' => $updatedCount,
        'status' => 'completed'
    ];
}

// Check if script is being run directly
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    // Parse command line arguments
    $userIds = null;
    $reason = 'KYC information incomplete or invalid';
    
    // Simple command line argument parsing
    foreach ($argv as $arg) {
        if (strpos($arg, '--users=') === 0) {
            $userIdsStr = substr($arg, 8);
            $userIds = array_map('intval', explode(',', $userIdsStr));
        } elseif (strpos($arg, '--reason=') === 0) {
            $reason = substr($arg, 9);
        }
    }
    
    // Execute the update
    $result = updateKycStatusToRejected($userIds, $reason);
    
    // Output results
    echo "KYC Status Update Results:\n";
    echo "------------------------\n";
    echo "Total records processed: {$result['total_records']}\n";
    echo "Records updated to rejected status: {$result['updated_records']}\n";
    echo "Status: {$result['status']}\n";
}

// Return the function so it can be used when included
return 'updateKycStatusToRejected'; 