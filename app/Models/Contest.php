<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Level;
use App\Models\Question;
use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use App\Traits\AccessorsTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Contest extends Model
{
    use CrudTrait;
    use SoftDeletes;
    use ActionMadeByTrait;
    use UploadTrait;
    use ForceDeleteTrait;
    use AccessorsTrait;
    use ScopesTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $entityName = 'contest';
    protected $table = 'contests';
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
    protected static function imageField()
    {
        return 'image';
    }

    public function matchQuestion()
    {
        return '<a
            class="btn btn-sm btn-link text-info"
            href="' . backpack_url("/contest/$this->id/edit?match_question=true") . '"
            data-toggle="tooltip"
            data-placement="bottom"
            title="' . trans('custom.match_questions') . '">
                <i class="las la-exchange-alt"></i>
            </a>';
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function registeredContest()
    {
        return $this->hasOne(RegisteredContest::class);
    }

    public function registeredContests()
    {
        return $this->hasMany(RegisteredContest::class);
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeAjaxSelect2Single($query, $value)
    {
        if ($value) {
            $value = strtolower($value);
            $query->orWhere(DB::raw('LOWER(title)'), 'LIKE', "%$value%")
                ->orWhere(DB::raw('LOWER(title_kh)'), 'LIKE', "%$value%");
        }
        return $query->StatusApproved();
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getStartAtDateAttribute()
    {
        return Carbon::parse($this->start_at)->toDateString();
    }

    public function getEndAtDateAttribute()
    {
        return Carbon::parse($this->end_at)->toDateString();
    }

    public function getImageOrDefaultAttribute()
    {
        return $this->image ? $this->image : 'assets/default.png';
    }

    public function getDescriptionStripeStringAttribute()
    {
        return Str::limit(strip_tags($this->DescriptionLang), 110, '...');
    }

    public function getDescriptionStripeStringLongAttribute()
    {
        return Str::limit(strip_tags($this->DescriptionLang), 1000, '...');
    }

    public function getCreatedAtDateAttribute()
    {
        return Carbon::parse($this->created_at);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    public function setImageAttribute($value)
    {
        $this->uploadImage($value, 'image');
    }
}
