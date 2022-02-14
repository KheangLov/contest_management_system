<?php

namespace App\Models;

use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use App\Traits\AccessorsTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Document extends Model
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

    public $entityName = 'document';
    protected $table = 'documents';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];

    protected $casts = ['path' => 'array'];

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
    public function getMultipleFilesAttribute(){
        $file = [];
        if (is_array($this->path)) {
            $arr = [];
            foreach($this->path as $path){
                array_push($arr, Storage::disk('public')->url($path));
            }
            $file = array_merge($file, $arr);
        }
        return $file;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPathAttribute($value)
    {
        $this->uploadMultipleFilesToDisk($value, 'path', 'public', 'uploads');
    }
}
