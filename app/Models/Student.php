<?php

namespace App\Models;

use App\Traits\ScopesTrait;
use App\Traits\AccessorsTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Student extends Model
{
    use CrudTrait;
    use SoftDeletes;
    use ActionMadeByTrait;
    use ForceDeleteTrait;
    use AccessorsTrait;
    use ScopesTrait;
    use UploadTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $entityName = 'student';
    protected $table = 'students';
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
        return 'profile';
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

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
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getProfileOrDefaultAttribute()
    {
        return $this->profile ? $this->profile : 'assets/default-user-profile.png';
    }

    public function getHasUserAttribute()
    {
        return $this->user ? true : false;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setProfileAttribute($value)
    {
        $this->uploadImage($value, 'profile');
    }

    public function setEmailAttribute($value)
    {
        if (!$value) {
            $this->attributes['email'] = trim($this->first_name) . trim($this->last_name) . '@gmail.com';
        } else {
            $this->attributes['email'] = $value;
        }
    }
}
