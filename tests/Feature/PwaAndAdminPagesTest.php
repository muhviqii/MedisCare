<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PwaAndAdminPagesTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsRole(string $roleSlug): User
    {
        $role = Role::factory()->create(['slug' => $roleSlug]);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        return $user;
    }

    public function test_pwa_shell_files_exist_in_public_directory(): void
    {
        // File statis (manifest.json, sw.js, offline.html) disajikan langsung oleh web
        // server (bukan lewat routing Laravel), jadi diverifikasi keberadaannya di disk.
        $this->assertFileExists(public_path('manifest.json'));
        $this->assertFileExists(public_path('sw.js'));
        $this->assertFileExists(public_path('offline.html'));

        $manifest = json_decode(file_get_contents(public_path('manifest.json')), true);
        $this->assertEquals('MedisCare', $manifest['short_name']);
    }

    public function test_splash_screen_redirects_guest_to_login(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(route('login'));
    }

    public function test_only_users_manage_permission_can_access_user_management(): void
    {
        $this->actingAsRole('dokter');
        $response = $this->get('/users');
        $response->assertForbidden();

        $this->actingAsRole('super_admin');
        $response = $this->get('/users');
        $response->assertOk();
    }

    public function test_admin_can_create_new_polyclinic(): void
    {
        $this->actingAsRole('admin_rs');

        $response = $this->post('/polyclinics', [
            'name' => 'Poli Jiwa',
            'code' => 'POLI-JIW',
        ]);

        $response->assertRedirect(route('polyclinics.index'));
        $this->assertDatabaseHas('polyclinics', ['code' => 'POLI-JIW']);
    }
}
