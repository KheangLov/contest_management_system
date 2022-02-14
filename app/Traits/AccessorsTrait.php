<?php

namespace App\Traits;

trait AccessorsTrait
{
    public function getTitleLangAttribute()
    {
        $field = 'title';

        if (app()->isLocale('kh')) {
            $field .= '_kh';
        }

        return $this->{$field} ?? $this->title;
    }

    public function getDescriptionLangAttribute()
    {
        $field = 'description';

        if (app()->isLocale('kh')) {
            $field .= '_kh';
        }

        return $this->{$field} ?? $this->description;
    }
    public function getNameLangAttribute()
    {
        $field = 'name';

        if (app()->isLocale('kh')) {
            $field .= '_kh';
        }

        return $this->{$field} ?? $this->name;
    }
}
