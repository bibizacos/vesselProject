<?php
/**
 * Created by PhpStorm.
 * User: bibiz
 * Date: 16-Feb-20
 * Time: 6:16 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class RequestedUsers extends Model
{


    protected $table='requestedusers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip', 'updated_at','created_at','requests',
    ];
}