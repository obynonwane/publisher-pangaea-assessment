<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublisherTest extends TestCase
{
    use RefreshDatabase;
    /** Test */
    public function test_create_message_return_false_for_non_existing_topic()
    {
        //make request to non existing topic 
        $response = $this->postJson('/api/publish/2', ['body' => 'message body']);

        //check if response status is false and status code is 422
        $response->assertStatus(422)->assertJson([
            'status' => false,
        ]);
    }


    /** Test */
    public function test_create_message_successful()
    {
        //create topic
        $topic = Topic::create([
            'title' => 'Test Title'
        ]);

        //add message to created topic
        $response = $this->postJson('/api/publish/' . $topic->id, ['body' => 'message body']);

        //assert that the creation was successful and response contains topic title
        $response->assertStatus(200)->assertJson([
            'status' => true,
        ]);
    }
}
