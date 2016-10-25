<?php

namespace CityNexus\Http\Middleware;

use CityNexus\Organization;
use Closure;
use Illuminate\Support\Facades\Auth;

class TenantCheck
{
    public function __construct()
    {
        $this->except_urls = [
            '/login',
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
        if (config('App.env') != 'testing')
        {


            $domain = $request->capture()->server->get('SERVER_NAME');
            $slug = str_replace('.' . config('app.root_app'), '', $domain);

            $org = Organization::where('slug', $slug)->first();
            $user = Auth::user();

            if ($user != null && $user->organizations()->exists($org->id)) {
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
                    ]
                ]);
                config(['database.default' => 'tenant']);
            } else {
                return redirect('/login');
            }
        }

        return $next($request);
    }
}
