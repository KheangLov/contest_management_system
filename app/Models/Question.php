<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\Contest;
use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use App\Traits\AccessorsTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Question extends Model
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

    public $entityName = 'question';
    protected $table = 'questions';
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function answer()
    {
        return $this->hasOne(Answer::class, 'id', 'answer_id');
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
        return $query->IsActive();
    }

    public function scopeNotLinkedQuestions($query, $value = '')
    {
        $query->StatusApproved()->whereNull('contest_id');
        if ($value) {
            $query->orWhere('contest_id', $value);
        }
        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getImageOrDefaultAttribute()
    {
        return $this->image ? $this->image : 'assets/default.png';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($value)
    {
        $this->uploadImage($value, 'image');
    }
}
