<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Subscriber;
use Tests\TestCase;
use App\Models\Topic;
use GuzzleHttp\Client;


use App\Services\Publisher;
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


    /** Test */
    public function test_publish_to_subscriber_works()
    {
        //create topic
        $topic = Topic::create(['title' => 'Test Title']);

        //create subscriber
        Subscriber::create(['url' => 'http://127.0.0.1:9000/api/test1', 'topic_id' => $topic->id,]);

        //create message
        $message = Message::create(['body' => 'Test Title', 'topic_id' => $topic->id,]);

        //form data to be sent to subscribers
        $data = [
            "topic" => $topic->title,
            "data" => ["message" => $message->body, "published_date" => $message->created_at]
        ];

        //get topic subscriber
        $subscribers = $topic->subscribers;

        //guzzle client
        $client = new Client();

        if ($subscribers) {
            //loop and forward message to subscribers urls
            foreach ($subscribers as $subscriber) {

                //Http post request to subscribers url
                $response = $client->post($subscriber->url, [
                    'form_params' => $data,
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]);

                //response from subscribers
                $response = json_decode($response->getBody()->getContents(), TRUE);


                //assert that the response contains true
                $this->assertContains(true, $response);
            }
        }
    }
}
