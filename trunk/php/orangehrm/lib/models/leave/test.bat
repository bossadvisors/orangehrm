@ echo off

echo Testing Leave Class...
call phpunit LeaveTest
echo Testing LeaveQuota Class...
call phpunit LeaveQuotaTest
echo Testing LeaveSummary Class...
call phpunit LeaveSummaryTest
