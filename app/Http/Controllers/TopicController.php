<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Topic;
use App\Exceptions\CreateTopicException;
use App\Exceptions\DeleteTopicException;
use App\Exceptions\UpdateTopicException;
use App\Http\Requests\CreateTopicRequest;
use App\Http\Resources\TopicResource;


class TopicController extends Controller
{
    //@desc     Create Topic
    //@route    POST api/topic/create
    //@access   Public
    public function create(CreateTopicRequest $request)
    {
        try {
            //create user
            $topic =  Topic::create(['title' => $request->title]);

            //return success response upon create
            return response()->json(["status" => true, "message" => "Topic created succesffully", "data" => new TopicResource($topic)], 201);
        } catch (Exception $e) {

            //throws an exception in case of error while creating
            throw new CreateTopicException();
        }
    }


    //@desc     get all topics
    //@route    GET api/topic/all
    //@access   Public
    public function all()
    {
        //get all topics
        $topics = Topic::all();

        if ($topics) {
            //return success response if topic exist in DB
            return response()->json(["status" => true, "message" => "topics retrieved", "data" => TopicResource::collection($topics)], 200);
        }

        //return incase no topics in database
        return response()->json(["status" => true, "message" => "No Topics at the moment", "data" => []], 200);
    }

    //@desc     Update Topic
    //@route    UPDATE api/topic/update/{topic}
    //@access   Public
    public function update(CreateTopicRequest $request, $topic)
    {
        try {

            $topic = Topic::find($topic);
            //update Topic
            if ($topic) {

                $topic->title  = $request->title;
                $topic->save();
                //return success message upon update 
                return response()->json(["status" => true, "message" => "Topic updated succesfully", "data" => new TopicResource($topic)], 200);
            }

            return response()->json(["true" => true, "message" => "Topic could not be found", "data" => []], 200);
        } catch (Exception $e) {

            //Throw Exception incase of error while updating
            throw new UpdateTopicException();
        }
    }

    //@desc     Delete Topic
    //@route    DELETE api/topic/delete/{topic}
    //@access   Public
    public function delete($topic)
    {
        try {

            $topic = Topic::find($topic);
            //delete Topic
            if ($topic) {
                $topic->delete();
                //return success message upon deletion 
                return response()->json(["status" => true, "message" => "Topic deleted", "data" => []], 200);
            }

            return response()->json(["true" => true, "message" => "Topic could not be found", "data" => []], 200);
        } catch (Exception $e) {

            //Throw Exception incase of error while deleting
            throw new DeleteTopicException();
        }
    }
}
