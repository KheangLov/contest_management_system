<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use App\Traits\AccessorsTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class News extends Model
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

    public $entityName = 'news';
    protected $table = 'news';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = ['gallery' => 'array'];
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
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
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
    public function getImageOrDefaultAttribute(){
        return $this->image ? $this->image : 'assets/default.png';
    }
    public function getMergeImageGalleryAttribute(){
        $images = [];
        if($this->image){
            $images = array_merge([asset($this->image)]);
        }
        if (is_array($this->gallery)) {
            $arr = [];
            foreach($this->gallery as $gallery){
                array_push($arr, Storage::disk('public')->url($gallery));
            }
            $images = array_merge($images, $arr);
        }
        return $images;
    }
    public function getCreatedAtFormatAttribute(){
        if ($this->created_at) {
            return Carbon::parse($this->created_at)->format('j M Y');
        }
    }
    public function getDescriptionStripeStringAttribute()
    {
        return Str::limit(strip_tags($this->DescriptionLang), 110, '...');
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

    public function setGalleryAttribute($value)
    {
        $attribute_name = "gallery";
        $disk = 'public';
        $destination_path = "uploads";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
