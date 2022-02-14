<?php

namespace App\Traits;

use App\Models\Level;
use App\Models\Contest;
use App\Models\Question;
use App\Models\WorkShop;

trait MatchModelTrait
{

    public function actionType($table, $value, $type = 'find_id')
    {
        $model = $this->modelMatching($table);

        if (!$model) {
            return false;
        }

        switch ($type) {
            case 'find_id':
                $data = $model::find($value);
                break;
            case 'model':
                $data = new $model;
                break;
            case 'ajax':
                $data = $model::AjaxSelect2Single($value);
                break;
            default:
                $data = false;
                break;
        }

        return $data;
    }

    public function modelMatching($table)
    {
        switch ($table) {
            case 'contests':
                $model = Contest::class;
                break;
            case 'levels':
                $model = Level::class;
                break;
            case 'questions':
                $model = Question::class;
                break;
            case 'workshops':
                $model = WorkShop::class;
                break;
            default:
                $model = false;
                break;
        }

        return $model;
    }
}
