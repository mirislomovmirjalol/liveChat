<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversations_message extends Model
{
    use HasFactory;

    const TYPE_IN = 0;
    const TYPE_OUT = 1;

    public function conversation()
    {
        return $this->belongsTo('App\Models\Conversation', 'conversations_id');
    }
}
