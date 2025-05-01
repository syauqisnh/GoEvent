<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tickets extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'registration_id',
        'ticket_code',
        'issued_at',
    ];

    public function registration()
    {
        return $this->belongsTo(Registrations::class);
    }
}

