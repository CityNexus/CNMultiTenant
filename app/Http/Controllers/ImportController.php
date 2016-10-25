<?php

namespace CityNexus\Http\Controllers;

use CityNexus\DataStore\DataStore;
use Illuminate\Http\Request;

class ImportController extends Controller
{

    public function __construct()
    {
        $this->datastore = new DataStore();
    }


    public function create()
    {
        return view('import.create');
    }
}
