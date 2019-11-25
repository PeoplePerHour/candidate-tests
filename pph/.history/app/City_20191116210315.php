<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    const ID = "id";
    
    // Table Name
    protected $table = 'cities';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
