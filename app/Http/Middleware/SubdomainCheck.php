<?php

namespace CityNexus\Http\Middleware;

use CityNexus\Organization;
use Closure;
use Illuminate\Support\Facades\Auth;

class SubdomainCheck
{

    public function __construct()
    {
        $this->except_urls = [
            '/login'
        ];
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.env') != 'testing')
        {
            $domain = $request->capture()->server->get('SERVER_NAME');

        if ($domain != config('app.root_app') && !in_array($request->capture()->server->get('REQUEST_URI'), $this->except_urls)) {
            $org = Organization::where('slug', $domain)->first();
            $user = Auth::user();
            if ($user != null && $user->organizations()->exists($org->id)) {
                config([
                    'database.default' => 'tenant',
                    'database.connections' => [
                        'tenant' => $org->db_settings,
                        'default' => [
                            'driver' => 'pgsql',
                            'host' => env('DB_HOST', 'localhost'),
                            'port' => env('DB_PORT', '5432'),
                            'database' => env('DB_DATABASE', 'forge'),
                            'username' => env('DB_USERNAME', 'forge'),
                            'password' => env('DB_PASSWORD', ''),
                            'charset' => 'utf8',
                            'prefix' => '',
                            'schema' => 'public',
                            'sslmode' => 'prefer',
                        ],
                    ]
                ]);
                    config(['database.default' => 'tenant']);
            } else {
                return redirect('/login');
            }
        }
    }

        return $next($request);
    }
}
