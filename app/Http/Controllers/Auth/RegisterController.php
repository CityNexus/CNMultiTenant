<?php

namespace CityNexus\Http\Controllers\Auth;

use CityNexus\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use CityNexus\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['slug'] = $this->clean($data['slug']);

        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'title' => 'required|max:255',
            'department' => 'max:255',
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:255', // organization name
            'password' => 'required|min:6|confirmed',
            'slug' => 'required|max:50|unique:organizations'

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {

        $org = \CityNexus\Organization::create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'schema' => $this->clean($data['slug'], true)
        ]);

        // create user object
        $user = User::create([
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
        ]);

        DB::statement('CREATE SCHEMA ' . $org->schema);

        config([
                'database.connections' => [
                    'tenant' => [
                        'driver' => 'pgsql',
                        'host' => env('DB_HOST', 'localhost'),
                        'port' => env('DB_PORT', '5432'),
                        'database' => env('DB_DATABASE', 'forge'),
                        'username' => env('DB_USERNAME', 'forge'),
                        'password' => env('DB_PASSWORD', ''),
                        'charset' => 'utf8',
                        'prefix' => '',
                        'schema' => $org->schema,
                        'sslmode' => 'prefer',
                    ],
                ],
                'database.default' => 'default'
            ]);

        config([
            'database.default' => 'tenant'
        ]);

        // create migration table
        Schema::create('migrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('migration');
            $table->integer('batch')->unsigned();
        });

        // ignore the public migration tables
        DB::table('migrations')->insert([
            ['migration' => '2014_10_12_000000_create_users_table', 'batch' => 1],
            ['migration' => '2014_10_12_100000_create_password_resets_table', 'batch' => 1],
            ['migration' => '2016_09_09_225010_create_organizations_table', 'batch' => 1],
            ['migration' => '2016_09_09_225531_create_organization_user_table', 'batch' => 1]
        ]);

        Artisan::call('migrate', ['--force' => true]);

        config([
            'database.default' => 'default'
        ]);

        $user->organizations()->attach($org, ['title' => $data['title'], 'department' => $data['department']]);

        return $user;
    }

    function clean($string, $schema = false)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        if($schema) $string = str_replace('-', '_', $string);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
