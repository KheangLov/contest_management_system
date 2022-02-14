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
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class WorkShop extends Model
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

    public $entityName = 'workshop';
    protected $table = 'workshops';
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

    public function workshopJoiners(){
        return $this->belongsToMany(User::class, 'workshop_joiners' ,'workshop_id', 'joiner_id');
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
    public function getStartDateFormatAttribute(){
        if ($this->created_at) {
            return Carbon::parse($this->start_date)->format('j M Y');
        }
    }
    public function getEndDateFormatAttribute(){
        if ($this->created_at) {
            return Carbon::parse($this->end_date)->format('j M Y');
        }
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

    public function getWorkshopJoinersAttribute(){
        $workShopJoiners = DB::table('workshop_joiners')->where('workshop_id', $this->id)->pluck('joiner_id')->toArray();
        if($workShopJoiners){
            return User::whereIn('id', $workShopJoiners)->orderBy('id','desc')->get();
        }
        return [];
    }

    public function getCheckUserAlreadyJoinAttribute(){
        $user = $this->workshopJoiners;
        if($user && backpack_user()){
            $arr = $user->pluck('id')->toArray();
            if(in_array(backpack_user()->id, $arr)){
                return true;
            }
        }
    }
    public function getListWorkShopJoinerAttribute(){
        $user = $this->workshopJoiners;
        return $user ? $user : [];
    }

    public function getCountWorkShopJoinerAttribute(){
        $user = $this->workshopJoiners;
        return $user ? count($user) : 0;
    }

    public function getWorkShopDescriptionLangAttribute(){
        return Str::limit(strip_tags($this->DescriptionLang), 200, '...');
    }

    public function getDescriptionStripeStringLongAttribute()
    {
        return Str::limit(strip_tags($this->DescriptionLang), 1000, '...');
    }

    public function getUpCommingWorkShopAttribute(){
        if($this->end_date > Carbon::now()){
            return true;
        }
    }

    public function dayKh($val)
    {
        $day = '';
        $nums = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        foreach (str_split($val) as $v) {
            $day .= $nums[$v];
        }
        return $day;
    }

    public function monthKh($val)
    {
        $months = ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'];
        return $months[$val - 1];
    }

    public function getStartDayKhmerAttribute()
    {
        return $this->dayKh(Carbon::parse($this->start_date)->day);
    }

    public function getEndDayKhmerAttribute()
    {
        return $this->dayKh(Carbon::parse($this->end_date)->day);
    }

    public function getMonthKhmerAttribute()
    {
        return $this->monthKh(Carbon::parse($this->start_date)->month);
    }

    public function getYearKhmerAttribute()
    {
        return $this->dayKh(Carbon::parse($this->start_date)->year);
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
