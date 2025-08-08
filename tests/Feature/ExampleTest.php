<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Livewire\Auth\ValidateEmployee;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/personnel/validate');

        $response->assertStatus(200);
    }
    public function it_redirects_to_employee_profile_page_if_employee_exists()
    {

        // When we visit the validate employee page and submit the form with employee_id
        Livewire::test(ValidateEmployee::class)
            ->set('user_no', '123456')
            ->call('validateUser')
            ->assertRedirect(route('auth.employee.profile', ['id_number' => '123456789']));
    }

    /** @test */
    public function it_flashes_no_record_session_if_employee_does_not_exist()
    {


        // When we visit the validate employee page and submit the form with non-existent employee_id
        // Livewire::test(ValidateEmployee::class)
        //     ->set('user_no', '123456')
        //     ->call('validateUser')
        //     ->assertSessionHas('no_record','dsada dsa dad');
    }
}
