<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class CommunicationProfile extends CommonUuidModel
{
    public function protocol()
    {
        return $this->belongsTo('\App\Protocol');
    }

    public function communicationProfileType()
    {
        return $this->belongsTo('\App\CommunicationProfileType');
    }

    public function toArray()
    {
        return [
            // "id" => $this->id,
            // "communication_profile_type_id" => $this->communication_profile_type_id,
            // "protocol_id" => $this->protocol_id,
            "host" => $this->host,
            "username" => $this->username,
            "password" => $this->password,
            "port" => $this->port,
            "database" => $this->database,
            "code" => $this->code,
            "status" => $this->status,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "protocol" => $this->protocol,
            "communication_profile_type" => $this->communicationProfileType
        ];
    }
}
