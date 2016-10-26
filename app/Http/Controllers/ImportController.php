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
        $s3FormDetails = $this->datastore->aws->getS3Details(config('datastore.S3_bucket'), config('S3_region'));

        return view('import.create', compact('s3FormDetails'));
    }
}
