<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteOperator extends Model
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function website()
    {
        return $this->belongsTo('App\Models\UserWebsite', 'website_id');
    }
}
