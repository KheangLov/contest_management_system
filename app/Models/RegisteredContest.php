<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Score;
use App\Models\Contest;
use App\Models\Statistic;
use App\Traits\ScopesTrait;
use App\Traits\AccessorsTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class RegisteredContest extends Model
{
    use CrudTrait;
    use SoftDeletes;
    use ActionMadeByTrait;
    use ForceDeleteTrait;
    use AccessorsTrait;
    use ScopesTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $entityName = 'registered_contest';
    protected $table = 'registered_contests';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id', 'id');
    }

    public function statistic()
    {
        return $this->hasOne(Statistic::class, 'registered_contest_id', 'id');
    }

    public function score()
    {
        return $this->hasOne(Score::class, 'registered_contest_id', 'id');
    }

    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'registered_contest_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'user_registered_contests', 'registered_contest_id', 'user_id');
    // }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getContestTitleAttribute()
    {
        return optional($this->contest)->TitleLang;
    }

    public function getStartDateTimeAttribute()
    {
        return Carbon::parse($this->start_date);
    }

    public function getEndDateTimeAttribute()
    {
        return Carbon::parse($this->end_date);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
