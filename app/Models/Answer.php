<?php

namespace App\Models;

use App\Models\Question;
use App\Traits\AccessorsTrait;
use App\Traits\UploadTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use App\Traits\RolePermissionTrait;
use App\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Answer extends Model
{
    use CrudTrait;
    use RolePermissionTrait;
    use SoftDeletes;
    use ActionMadeByTrait;
    use ForceDeleteTrait;
    use UploadTrait;
    use AccessorsTrait;
    use ScopesTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $entityName = 'answer';
    protected $table = 'answers';
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
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeNotLinkedAnswers($query, $value = '')
    {
        $query->whereNull('question_id');
        if ($value) {
            $query->orWhere('question_id', $value);
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
    public function setProfileAttribute($value)
    {
        $this->uploadImage($value, 'image');
    }
}
