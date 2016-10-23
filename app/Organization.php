<?php

namespace CityNexus;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'slug', 'db_host', 'db_name', 'db_user', 'db_password'];


    public function users()
    {
        return $this->belongsToMany('\CityNexus\User');
    }
}
