<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Topic;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriberTest extends TestCase
{

    use RefreshDatabase;
    /** Test */
    public function test_create_subscriber_return_false_for_non_existing_topic()
    {
        //make request to non existing topic 
        $response = $this->postJson('/api/subscribe/1', ['url' => 'http://127.0.0.1:9000/api/test1']);

        //check if response status is false and status code is 422
        $response->assertStatus(422)->assertJson([
            'status' => false,
        ]);
    }

    /** Test */
    public function test_create_subscriber_successful()
    {
        //create topic
        $topic = Topic::create([
            'title' => 'Test Title'
        ]);

        //subscribe to created topic
        $response = $this->postJson('/api/subscribe/' . $topic->id, ['url' => 'http://127.0.0.1:9000/api/test1']);


        //assert that the creation was successful and respinse contains topic title
        $response->assertStatus(201)->assertJson([
            'topic' => $topic->title,
        ]);
    }
}
