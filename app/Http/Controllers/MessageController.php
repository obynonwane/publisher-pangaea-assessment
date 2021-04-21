<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Topic;
use App\Models\Message;
use App\Services\Publisher;
use App\Http\Resources\PublisherResource;
use App\Exceptions\CreatePublisherException;
use App\Http\Requests\CreatePublisherRequest;

class MessageController extends Controller
{
    public $publisher;

    public function __construct()
    {
        //Instantiate publisher service class
        $this->publisher = new Publisher();
    }

    public function create(CreatePublisherRequest $request, $topic)
    {
        try {
            //Check for topic 
            $topic = Topic::find($topic);

            //Check if Topic exist
            if ($topic) {

                //create message
                $message =  Message::create(['topic_id' => $topic->id, 'body' => $request->body]);


                return $this->publisher->publish($topic, $message);

                //return success message creation 
                return response()->json(new PublisherResource($message), 200);
            }

            return response()->json(["status" => false, "message" => "Topic could not be found, error while publishing message", "data" => []], 422);
        } catch (Exception $e) {
            //Throw Exception incase of error while updating
            throw new CreatePublisherException();
        }
    }
}
