<?php

namespace CityNexus;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'slug', 'schema'];


    public function users()
    {
        return $this->belongsToMany('\CityNexus\User');
    }
}
