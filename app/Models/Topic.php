<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
    ];
    //
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
