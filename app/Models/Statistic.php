<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\Question;
use App\Models\RegisteredContest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'registered_contest_id',
        'chose_answer_id',
        'question_id',
        'is_correct',
    ];

    public function registeredContest()
    {
        return $this->belongsTo(RegisteredContest::class, 'registered_contest_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'chose_answer_id', 'id');
    }
}
