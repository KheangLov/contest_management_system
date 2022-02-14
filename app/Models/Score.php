<?php

namespace App\Models;

use App\Models\User;
use App\Models\RegisteredContest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'score',
        'registered_contest_id',
        'user_id',
    ];

    public function registeredContest()
    {
        return $this->belongsTo(RegisteredContest::class, 'registered_contest_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
