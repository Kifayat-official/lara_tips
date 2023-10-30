<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    use HasFactory;

    protected $fillable = [
        'sim_id',
        'sim_no',
        'telco_name',
        'disco_name',
        'po_no',
        'po_date',
        'status'
    ];
}
