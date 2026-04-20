<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminStaffTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_staff_page(): void
    {
        $super = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($super)->get(route('admin.staff.index'));

        $response->assertOk();
        $response->assertSee('Admin staff');
    }

    public function test_regular_admin_cannot_view_staff_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.staff.index'));

        $response->assertForbidden();
    }

    public function test_super_admin_can_create_admin_user(): void
    {
        $super = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($super)->post(route('admin.staff.store'), [
            'name' => 'New Admin',
            'email' => 'new-admin@example.com',
            'mobile_no' => '+44 7700 900200',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'new-admin@example.com',
            'role' => 'admin',
        ]);
    }

    public function test_super_admin_cannot_delete_own_account_via_staff_page(): void
    {
        $onlySuper = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($onlySuper)->delete(route('admin.staff.destroy', $onlySuper));

        $response->assertRedirect(route('admin.staff.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $onlySuper->id]);
    }

    public function test_super_admin_can_delete_another_super_admin_when_more_than_one(): void
    {
        $a = User::factory()->create(['role' => 'super_admin', 'email' => 'super-a@example.com']);
        $b = User::factory()->create(['role' => 'super_admin', 'email' => 'super-b@example.com']);

        $response = $this->actingAs($a)->delete(route('admin.staff.destroy', $b));

        $response->assertRedirect(route('admin.staff.index'));
        $this->assertDatabaseMissing('users', ['id' => $b->id]);
        $this->assertDatabaseHas('users', ['id' => $a->id]);
    }

    public function test_regular_admin_cannot_create_staff(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'name' => 'X',
            'email' => 'x@example.com',
            'mobile_no' => '+44 7700 900201',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'admin',
        ]);

        $response->assertForbidden();
    }
}
