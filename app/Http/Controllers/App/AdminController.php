<?php

namespace CityNexus\Http\Controllers;

use CityNexus\Http\Controllers\Controller;
use CityNexus\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function refreshMigrations($all = false)
    {
        // rollback all if $all is true
        if($all) Artisan::call('migrate:reset', ['--force' => true]);

        // migrate
        Artisan::call('migrate', ['--force' => true, '--seed' => true]);

        return redirect()->back();
    }
}
