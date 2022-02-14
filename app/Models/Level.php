<?php

namespace App\Models;

use App\Models\Contest;
use App\Traits\AccessorsTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use CrudTrait;
    use SoftDeletes;
    use ForceDeleteTrait;
    use AccessorsTrait;
    use ScopesTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $entityName = 'level';
    protected $table = 'levels';
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
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function contests()
    {
        return $this->hasMany(Contest::class);
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

    public function getLevelCategoryAttribute()
    {
        return optional($this->category)->TitleLang . ' ' . $this->TitleLang;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
