<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'url',
        'topic_id',
    ];
    //
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
