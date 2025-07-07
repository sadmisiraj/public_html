-- SQL script to update status to 2 (rejected) in user_kycs table
-- This script can be run directly in your database management tool or via command line

-- Update all KYC records to rejected status
-- WARNING: This will update ALL records. Add a WHERE clause to target specific records.
UPDATE user_kycs
SET status = 2, 
    reason = 'KYC information incomplete or invalid',
    updated_at = NOW()
-- WHERE user_id = 123; -- Uncomment and modify to target specific users

-- Example to update specific users
-- UPDATE user_kycs
-- SET status = 2, 
--     reason = 'KYC information incomplete or invalid',
--     updated_at = NOW()
-- WHERE user_id IN (123, 456, 789);

-- Example to update only pending KYCs
-- UPDATE user_kycs
-- SET status = 2, 
--     reason = 'KYC information incomplete or invalid',
--     updated_at = NOW()
-- WHERE status = 0;

-- Verify the changes
-- SELECT id, user_id, status, reason, updated_at FROM user_kycs WHERE status = 2; 