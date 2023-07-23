<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskCreation()
    {
        $data = [
            'title' => 'Sample Task',
            'description' => 'This is a sample task',
            'due_date' => '2023-08-15',
            'status' => 'in-progress',
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Sample Task',
                'description' => 'This is a sample task',
                'due_date' => '2023-08-15',
                'status' => 'in-progress',
            ]);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testTaskUpdate()
    {
        $task = Task::factory()->create([
            'title' => 'Task to be Updated',
            'description' => 'This task needs to be updated',
            'due_date' => '2023-09-01',
            'status' => 'pending',
        ]);

        $data = [
            'title' => 'Updated Task Title',
            'description' => 'This task has been updated',
            'due_date' => '2023-09-15',
            'status' => 'in-progress',
        ];

        $response = $this->putJson('/api/tasks/' . $task->id, $data);

        $response->assertStatus(200)
        ->assertJson([
            'message' => 'Task has been updated successfully.',
        ]);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testTaskDeletion()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Task has been deleted successfully.',
            ]);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

}
