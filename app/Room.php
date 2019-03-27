<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'date',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'room';

    /**
     * @var array
     */
    protected $dates = ['date'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];
}
