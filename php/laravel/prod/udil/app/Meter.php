<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Meter extends CommonUuidModel
{

    public function meterType()
    {
        return $this->belongsTo('\App\MeterType');
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "mdc_test_session_id" => $this->mdc_test_session_id,
            "msn" => $this->msn,
            "meter_type_id" => $this->meter_type_id,
            "meter_type" => $this->meterType->name,
            "global_device_id" => $this->global_device_id,
            "status" => $this->status,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
