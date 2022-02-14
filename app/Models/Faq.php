<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use App\Traits\AccessorsTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Faq extends Model
{
    use CrudTrait;
    use ActionMadeByTrait;
    use UploadTrait;
    use AccessorsTrait;
    use ScopesTrait;
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'faqs';
    public $entityName = 'faq';
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
    public function getFaqByParentIdAttribute(){
        return Faq::where('parent_id', $this->id)->get();
    }

    public function getCreatedAtFormatAttribute(){
        if ($this->created_at) {
            return Carbon::parse($this->start_date)->format('j M Y');
        }
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
