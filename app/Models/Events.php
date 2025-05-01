<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Events extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'event_name',
        'event_desc',
        'event_date',
        'location',
        'user_id',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registrations::class, 'event_id');
    }
}
