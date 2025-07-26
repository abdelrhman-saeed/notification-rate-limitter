<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_notification_sent_successfully(): void
    {
        $sender     = User::factory()->create();
        $reciever   = User::factory()->create();

        $senderAccessToken = $sender
            ->createTOken('access_token')
            ->plainTextToken;

        $requestData = [
            'user_id' => $reciever->id,
            'message' => 'your account has been updated!'
        ];

        $this->withToken($senderAccessToken)
                ->postJson('/api/notifications', $requestData)
                ->assertStatus(200)
                ->assertJson([
                    'id'        => $reciever->id,
                    'message'   => 'Notification sent'
                ]);

        $this->assertDatabaseCount('notifications', 1);
    }

    public function test_notification_rate_limit_exceeded(): void {

        $sender     = User::factory()->create();
        $reciever   = User::factory()->create();

        $senderAccessToken = $sender
            ->createTOken('access_token')
            ->plainTextToken;

        $requestData = [
            'user_id' => $reciever->id,
            'message' => 'your account has been updated!'
        ];

        for($i = 0; $i < 5; $i++)
        {
            $this->withToken($senderAccessToken)
                    ->postJson('/api/notifications', $requestData)
                    ->assertStatus(200)
                    ->assertJson([
                        'id'        => $reciever->id,
                        'message'   => 'Notification sent'
                    ]);
        }

        $this->assertDatabaseCount('notifications', 5);

        $this->withToken($senderAccessToken)
                ->postJson('/api/notifications', $requestData)
                ->assertStatus(429);
    }

    public function test_invalid_notification_input(): void {

        $token = User::factory()
            ->create()
            ->createToken('access_token')
            ->plainTextToken;

        $this->withToken($token)
                ->postJson('/api/notifications')
                ->assertStatus(422);
    }

    public function test_unauthorized(): void {

        $this->postJson('/api/notifications')->assertStatus(401);
    }
}
