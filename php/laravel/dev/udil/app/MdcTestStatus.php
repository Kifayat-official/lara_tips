<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class MdcTestStatus extends CommonUuidModel
{
    private static function insertTestLog($model)
    {
        //if($model->is_pass == null)
        //{
          //  return;
        //}

        $test_log = new \App\TestLog();
        $test_log->mdc_test_status_id = $model->id;
        $test_log->mdc_test_session_id = $model->mdc_test_session_id;
        $test_log->test_id = $model->test_id;
        $test_log->is_pass = $model->is_pass;
        if($model->is_pass == '1')
        {
            $test_log->remarks = null;
            $test_log->attachment = null;
        }else{
            $test_log->remarks = $model->remarks;
            $test_log->attachment = $model->attachment;
        }
        $test_log->request = $model->request;
        $test_log->response_type = $model->response_type;
        $test_log->response = $model->response;
        $test_log->save();
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            self::insertTestLog($model);
        });

        self::updated(function($model) {
            self::insertTestLog($model);
        });
    }
}
