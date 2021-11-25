<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantsOf extends Model
{
    const CREATED_AT = 'registered_at';
    const UPDATED_AT = 'date_of_last_bid';
    protected $table = 'participants_of';
    protected $fillable = ['participant', 'auction', 'registered_at', 'is_approved', 'last_bid', 'date_of_last_bid'];

    public function user() {
        return $this->belongsTo(User::class, 'participant', 'id');
    }
}
