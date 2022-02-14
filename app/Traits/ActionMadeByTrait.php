<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait ActionMadeByTrait
{
    public function authBy()
    {
        return $this->belongsTo(User::class, 'auth_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getAuthByFullNameAttribute()
    {
        return optional($this->authBy)->FullName;
    }

    public function getCreatedByFullNameAttribute()
    {
        return optional($this->createdBy)->FullName;
    }

    public function getUpdatedByFullNameAttribute()
    {
        return optional($this->updatedBy)->FullName;
    }

    public function getDeletedByFullNameAttribute()
    {
        return optional($this->deletedBy)->FullName;
    }

    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }

    public static function BootActionMadeByTrait()
    {
        static::creating(function ($obj) {
            $obj = $obj->actionBy($obj, 'created_by');
        });

        static::updating(function ($obj) {
            $obj = $obj->actionBy($obj, 'updated_by');
        });
    }

    public function actionBy($model, $type)
    {
        if (Auth::check()) {
            $model->{$type} = request()->{$type}
                ? request()->{$type}
                : backpack_user()->id;
        }


        return $model;
    }
}
