<?php

namespace CityNexus;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['street_number', 'street_name', 'street_type', 'unit', 'city', 'state', 'postal_code'];
    protected $table = 'citynexus_properties';


}
