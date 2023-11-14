<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use Webpatser\Uuid\Uuid;
use DB;

class MdcTestSession extends CommonUuidModel
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $last = self::select('id_numeric')->orderBy('id_numeric', 'desc')->limit(1)->get();
            $id_numeric = $last != null && $last->count() > 0 ? $last[0]->id_numeric + 1 : 1;
            $model->id_numeric = $id_numeric;
        });
    }

    public function readDatabaseConnection()
    {
        config(['database.connections.onthefly' => [
            'driver' => $this->readCommunicationProfile->protocol->idt,
            'host' => $this->readCommunicationProfile->host,
            'port' => $this->readCommunicationProfile->port,
            'database' => $this->readCommunicationProfile->database,
            'username' => $this->readCommunicationProfile->username,
            'password' => $this->readCommunicationProfile->password,
        ]]);

        $connection = DB::connection('onthefly');
        return $connection;
    }

    public function company()
    {
        return $this->belongsTo('\App\Company');
    }

    public function meters()
    {
        return $this->hasMany('\App\Meter');
    }

    public function readCommunicationProfile()
    {
        return $this->belongsTo('\App\CommunicationProfile', 'read_profile_id');
    }

    public function writeCommunicationProfile()
    {
        return $this->belongsTo('\App\CommunicationProfile', 'write_profile_id');
    }

    public function testProfile()
    {
        return $this->belongsTo('\App\TestProfile');
    }

    public function mdcTestStatuses()
    {
        return $this->hasMany('\App\MdcTestStatus');
    }

    public function getMdcTestStatusByTestId($test_id)
    {
        return $this->mdcTestStatuses()->where('test_id', $test_id)->first();
    }

    public function isAllTestsExecuted()
    {
        $isAllTestsExecuted = true;

        $allMdcTestStatuses = $this->mdcTestStatuses;

        foreach ($this->testProfile->tests as $test) {
            $found_status = $allMdcTestStatuses->first(function ($status, $index) use ($test) {
                return $status->test_id == $test->id;
            });

            if ($found_status == null) {
                $isAllTestsExecuted = false;
                break;
            }
        }

        return $isAllTestsExecuted;
    }

    public function passedTestsCount()
    {
        $allMdcTestStatuses = $this->mdcTestStatuses;

        $passedTestsCount = 0;

        foreach ($this->testProfile->tests as $test) {
            $found_status = $allMdcTestStatuses->first(function ($status, $index) use ($test) {
                return $status->test_id == $test->id;
            });

            if ($found_status != null && $found_status->is_pass == 1) {
                $passedTestsCount++;
            }
        }

        return $passedTestsCount;
    }
}
