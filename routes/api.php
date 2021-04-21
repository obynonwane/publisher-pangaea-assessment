<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//create topic
Route::post("topic/create", "TopicController@create");
Route::get("topic/all", "TopicController@all");
Route::put("topic/update/{topic}", "TopicController@update");
Route::delete("topic/delete/{topic}", "TopicController@delete");

//Subscribe route
Route::post("subscribe/{topic}", "SubscriberController@create");

//publish message
Route::post("publish/{topic}", "MessageController@create");
