<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
    }

    public function test_login_fail_with_wrong_credentials(): void
    {
        $this->postJson('/api/login', [
            'email'     => 'wrong@wrong.wrong',
            'password'  => 'wrong'])
        ->assertStatus(422);
    }

    public function test_login_fail_with_no_credentials(): void
    {
        $this->postJson('/api/login')->assertStatus(422);
    }

    public function test_logout(): void {

        $token = User::factory()
            ->create()
            ->createToken('access_token')
            ->plainTextToken;

        $this->postJson('/api/logout', headers: [
            'Authorization' => "Bearer $token"
        ])
        ->assertJson(['message' => 'user signed out successfully!']);
    }
}
