<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registrations extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Events::class);
    }

    public function ticket()
    {
        return $this->hasOne(Tickets::class, 'registration_id');
    }
}
