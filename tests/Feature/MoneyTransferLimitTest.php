<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BasicControl;
use App\Models\MoneyTransfer;
use App\Helpers\MoneyTransferLimitHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MoneyTransferLimitTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $receiver;
    protected $basicControl;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->user = User::factory()->create([
            'balance' => 1000,
            'status' => 1
        ]);
        
        $this->receiver = User::factory()->create([
            'balance' => 0,
            'status' => 1
        ]);

        // Create basic control settings
        $this->basicControl = BasicControl::create([
            'money_transfer_limit_enabled' => true,
            'money_transfer_limit_type' => 'daily',
            'money_transfer_limit_count' => 3,
            'money_transfer_limit_days' => 1,
            'min_transfer' => 10,
            'max_transfer' => 500,
            'transfer_charge' => 2
        ]);
    }

    /** @test */
    public function it_allows_transfers_when_limits_are_disabled()
    {
        $this->basicControl->update(['money_transfer_limit_enabled' => false]);
        
        $limitCheck = MoneyTransferLimitHelper::checkTransferLimit($this->user->id);
        
        $this->assertTrue($limitCheck['allowed']);
        $this->assertNull($limitCheck['message']);
    }

    /** @test */
    public function it_allows_transfers_within_daily_limit()
    {
        $this->basicControl->update([
            'money_transfer_limit_type' => 'daily',
            'money_transfer_limit_count' => 3
        ]);

        // Create 2 transfers today (should allow 1 more)
        MoneyTransfer::factory()->count(2)->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->receiver->id,
            'created_at' => Carbon::today()
        ]);

        $limitCheck = MoneyTransferLimitHelper::checkTransferLimit($this->user->id);
        
        $this->assertTrue($limitCheck['allowed']);
        $this->assertEquals(1, $limitCheck['remaining_transfers']);
    }

    /** @test */
    public function it_blocks_transfers_when_daily_limit_exceeded()
    {
        $this->basicControl->update([
            'money_transfer_limit_type' => 'daily',
            'money_transfer_limit_count' => 3
        ]);

        // Create 3 transfers today (should block further transfers)
        MoneyTransfer::factory()->count(3)->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->receiver->id,
            'created_at' => Carbon::today()
        ]);

        $limitCheck = MoneyTransferLimitHelper::checkTransferLimit($this->user->id);
        
        $this->assertFalse($limitCheck['allowed']);
        $this->assertEquals(0, $limitCheck['remaining_transfers']);
        $this->assertStringContains('exhausted your daily transfer limit', $limitCheck['message']);
    }

    /** @test */
    public function it_resets_daily_limits_correctly()
    {
        $this->basicControl->update([
            'money_transfer_limit_type' => 'daily',
            'money_transfer_limit_count' => 2
        ]);

        // Create 2 transfers yesterday (should not affect today's limit)
        MoneyTransfer::factory()->count(2)->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->receiver->id,
            'created_at' => Carbon::yesterday()
        ]);

        $limitCheck = MoneyTransferLimitHelper::checkTransferLimit($this->user->id);
        
        $this->assertTrue($limitCheck['allowed']);
        $this->assertEquals(2, $limitCheck['remaining_transfers']);
    }

    /** @test */
    public function it_handles_weekly_limits_correctly()
    {
        $this->basicControl->update([
            'money_transfer_limit_type' => 'weekly',
            'money_transfer_limit_count' => 5
        ]);

        // Create 4 transfers this week
        MoneyTransfer::factory()->count(4)->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->receiver->id,
            'created_at' => Carbon::now()->startOfWeek()->addDays(1)
        ]);

        $limitCheck = MoneyTransferLimitHelper::checkTransferLimit($this->user->id);
        
        $this->assertTrue($limitCheck['allowed']);
        $this->assertEquals(1, $limitCheck['remaining_transfers']);
    }

    /** @test */
    public function it_handles_custom_days_limits_correctly()
    {
        $this->basicControl->update([
            'money_transfer_limit_type' => 'custom_days',
            'money_transfer_limit_count' => 2,
            'money_transfer_limit_days' => 7
        ]);

        // Create 1 transfer within the current 7-day cycle
        MoneyTransfer::factory()->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->receiver->id,
            'created_at' => Carbon::now()->subDays(3)
        ]);

        $limitCheck = MoneyTransferLimitHelper::checkTransferLimit($this->user->id);
        
        $this->assertTrue($limitCheck['allowed']);
        $this->assertEquals(1, $limitCheck['remaining_transfers']);
    }

    /** @test */
    public function limit_info_provides_correct_information()
    {
        $this->basicControl->update([
            'money_transfer_limit_type' => 'daily',
            'money_transfer_limit_count' => 5
        ]);

        // Create 2 transfers today
        MoneyTransfer::factory()->count(2)->create([
            'sender_id' => $this->user->id,
            'receiver_id' => $this->receiver->id,
            'created_at' => Carbon::today()
        ]);

        $limitInfo = MoneyTransferLimitHelper::getLimitInfo($this->user->id);
        
        $this->assertTrue($limitInfo['enabled']);
        $this->assertEquals(5, $limitInfo['limit_count']);
        $this->assertEquals('per day', $limitInfo['period_description']);
        $this->assertEquals(3, $limitInfo['remaining_transfers']);
        $this->assertStringContains('You can make 5 transfer(s) per day', $limitInfo['message']);
    }
} 