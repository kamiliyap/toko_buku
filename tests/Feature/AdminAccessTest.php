<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $user = $this->makeUser([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_logged_out_admin_cannot_access_admin_dashboard_anymore(): void
    {
        $admin = $this->makeUser([
            'is_admin' => true,
        ]);

        $this->actingAs($admin)->post(route('logout'))->assertRedirect(route('login'));

        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    private function makeUser(array $attributes = []): User
    {
        $user = new User(array_merge([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ], $attributes));

        $user->id = $attributes['id'] ?? 1;

        return $user;
    }
}
