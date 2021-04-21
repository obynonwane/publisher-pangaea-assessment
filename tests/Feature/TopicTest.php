<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;

class TopicTest extends TestCase
{

    use RefreshDatabase;


    /** Test */
    public function test_create_topic_return_success()
    {
        $response = $this->postJson('/api/topic/create', ['title' => 'Sally']);

        $response
            ->assertStatus(201)
            ->assertJson([
                'status' => true,
            ]);
    }
}
