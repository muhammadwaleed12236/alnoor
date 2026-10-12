<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\ClinicDatabaseSeeder;

class ClinicPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ClinicDatabaseSeeder::class);
    }

    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Al-Noor Clinic');
        $response->assertSee('Lady Doctor & Gynae OPD');
    }

    public function test_public_report_search_returns_valid_data(): void
    {
        $response = $this->get('/search-report?report_id=REP-101');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'report' => [
                'report_id' => 'REP-101',
                'patient_name' => 'Fatima Zahra',
            ]
        ]);
    }

    public function test_online_appointment_booking(): void
    {
        $response = $this->postJson('/book-appointment', [
            'patient_name' => 'Test Patient',
            'service_name' => 'Lady Doctor & Gynae OPD',
            'appointment_date' => now()->toDateString(),
            'slot' => 'Morning (10:00 AM - 01:00 PM)',
            'patient_phone' => '0300-1112233',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertDatabaseHas('appointments', [
            'patient_name' => 'Test Patient',
        ]);
    }

    public function test_admin_login_and_dashboard_access(): void
    {
        $user = User::firstWhere('email', 'admin@alnoorclinic.com');

        $loginResponse = $this->post('/admin/login', [
            'email' => 'admin@alnoorclinic.com',
            'password' => 'admin123',
        ]);

        $loginResponse->assertRedirect('/admin/dashboard');

        $dashboardResponse = $this->actingAs($user)->get('/admin/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Clinic Dashboard Overview');
    }

    public function test_unauthenticated_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');
    }
}
