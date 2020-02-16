<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vessels extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mmsi','status', 'stationId', 'speed', 'lon','lat','course','heading','rot','timestamp'
    ];


}
