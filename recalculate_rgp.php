<?php

/**
 * Script to recalculate RGP points for all users
 * 
 * This script will:
 * 1. Delete all existing RGP transactions
 * 2. Reset all users' RGP points to zero
 * 3. Recalculate RGP points based on eligible plans
 * 4. Deduct points for matched profits
 * 5. Update RGP pair matching values
 * 
 * Usage: php recalculate_rgp.php
 */

// Bootstrap Laravel
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run the command
$status = $kernel->call('rgp:recalculate');

// Output the result
if ($status === 0) {
    echo "RGP points recalculation completed successfully!\n";
} else {
    echo "RGP points recalculation failed. Check the logs for more information.\n";
}

$kernel->terminate(null, $status);
exit($status); 