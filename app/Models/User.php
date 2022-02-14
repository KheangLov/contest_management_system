<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\WorkShop;
use App\Traits\UploadTrait;
use App\Traits\ForceDeleteTrait;
use App\Models\RegisteredContest;
use App\Traits\ActionMadeByTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\RolePermissionTrait;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles;
    use RolePermissionTrait;
    use SoftDeletes;
    use ActionMadeByTrait;
    use ForceDeleteTrait;
    use UploadTrait;

    public $entityName = 'user';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'gender',
        'dob',
        'phone',
        'school',
        'status',
        'address',
        'created_by',
        'updated_by',
        'deleted_by',
        'profile',
        'login_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function imageField()
    {
        return 'profile';
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dob' => 'date'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function workshopJoiners()
    {
        return $this->belongsToMany(WorkShop::class, 'workshop_joiners', 'joiner_id', 'workshop_id');
    }

    public function userRegContests()
    {
        return $this->hasMany(RegisteredContest::class, 'user_id', 'id');
    }

    public function score()
    {
        return $this->hasOne(Score::class, 'user_id', 'id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'user_id', 'id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getDobFormatAttribute()
    {
        return Carbon::parse($this->dob)->toDateString();
    }

    public function getStatusUCAttribute()
    {
        return strtoupper($this->status);
    }

    public function getGenderCLAttribute()
    {
        return ucfirst($this->gender);
    }

    public function getProfileOrDefaultAttribute()
    {
        return $this->profile ? $this->profile : 'assets/default-user-profile.png';
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    public function setProfileAttribute($value)
    {
        $this->uploadImage($value, 'profile');
    }

    public function scopeCheckNameExist($query, $value)
    {
        return $query->where(DB::raw('name'), $value);
    }

    public function scopeRoleTeacher($query)
    {
        return $query->whereHas('roles', function ($q) {
            return $q->where('id', $this->rptSchool);
        });
    }

    public function setNameAttribute($value)
    {
        if (!$value) {
            $name = trim($this->first_name) . trim($this->last_name);
            if ($this->CheckNameExist($name)->count()) {
                $name .= $this->CheckNameExist($name)->count();
            }
            $this->attributes['name'] = trim($this->first_name) . trim($this->last_name);
        } else {
            $this->attributes['name'] = str_replace(' ', '', $value);
        }
    }
}
