<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{   
    use SoftDeletes;

    protected $fillable = [
        'event_date', 'title'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
