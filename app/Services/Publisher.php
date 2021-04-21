<?php

namespace App\Services;

use App\Exceptions\PublishingToSubscriberException;
use Exception;
use App\Models\Topic;
use GuzzleHttp\Client;
use App\Models\Message;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Publisher
{

    public $client;
    public $httpClient;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function publish(Topic $topic, Message $message)
    {

        //form data to be sent to subscribers
        $data = [
            "topic" => $topic->title,
            "data" => ["message" => $message->body, "published_date" => $message->created_at]
        ];

        //get topic subscriber
        $subscribers = $topic->subscribers;


        //Loop through the subscribers if they exist
        if ($subscribers) {

            try {

                //loop and forward message to subscribers urls
                foreach ($subscribers as $subscriber) {

                    //Http post request to subscribers url
                    $response = $this->client->post($subscriber->url, [
                        'form_params' => $data,
                        'headers' => [
                            'Accept' => 'application/json'
                        ]
                    ]);

                    //response from subscribers
                    $resp = json_decode($response->getBody()->getContents(), TRUE);

                    //Log response from subscribers
                    Log::info($resp);
                }

                return response()->json(["status" => true, "message" => "published successfully"], 200);
            } catch (Exception $e) {
                Log::error($e);

                //Throw exception if error occurs
                throw new PublishingToSubscriberException();
            }
        }
    }
}
