<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Department;


class DepartmentTest extends TestCase
{
    use RefreshDatabase; // Reset database after each test

    /** @test */
    public function it_can_create_a_department()
    {
        $data = [
            'name' => 'IT Department',
        ];

        $response = $this->postJson('/api/departments', $data);

        $response->assertStatus(201); // Check if created
        $this->assertDatabaseHas('departments', $data); // Check if data exists in database
    }

    /** @test */
    public function it_can_update_a_department()
    {
        $department = DepartmentFactory::factory()->create();

        $updateData = [
            'name' => 'New IT Department Name',
        ];

        $response = $this->putJson('/api/departments/' . $department->id, $updateData);

        $response->assertStatus(200); // Check if updated successfully
        $this->assertDatabaseHas('departments', $updateData); // Check if updated data exists in database
    }

    /** @test */
    public function it_can_delete_a_department()
    {
        $department = DepartmentFactory::factory()->create();

        $response = $this->deleteJson('/api/departments/' . $department->id);

        $response->assertStatus(204); // Check if deleted successfully
        $this->assertDatabaseMissing('departments', ['id' => $department->id]); // Check if data is deleted from database
    }

    /** @test */
    public function it_can_list_all_departments()
    {
        DepartmentFactory::factory()->count(5)->create();

        $response = $this->getJson('/api/departments');

        $response->assertStatus(200); // Check if request is successful
        $response->assertJsonCount(5); // Assuming there are 5 departments
    }
}