<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Topic;
use App\Models\Subscriber;
use App\Http\Resources\SubscriberResource;
use App\Http\Requests\CreateSubscriberRequest;
use App\Exceptions\CreateSubscriptionException;

class SubscriberController extends Controller
{
    public function create(CreateSubscriberRequest $request, $topic)
    {

        try {

            //Check for topic 
            $topic = Topic::find($topic);

            //Check if Topic exist
            if ($topic) {

                //create subscriber
                $subscriber =  Subscriber::create(['topic_id' => $topic->id, 'url' => $request->url]);

                //return success message upon subscribing 
                return response()->json(new SubscriberResource($subscriber), 201);
            }

            return response()->json(["status" => false, "message" => "Topic could not be found, error while subscribing", "data" => []], 422);
        } catch (Exception $e) {
            //Throw Exception incase of error while updating
            throw new CreateSubscriptionException();
        }
    }
}
