<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Closure;
use Illuminate\Support\Facades\Gate;

class PermissionSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync system permission';


    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct();
        $this->router = $router;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->syncPermission();
        return 0;
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return collection | array
     */
    protected function getProtectedRoutes()
    {
        $routes = collect($this->router->getRoutes())->filter(function(Route $route){
            return Str::contains($route->uri(), 'api');
        });

        return $routes;
    }        

    /**
     * Get the middleware for the route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return \Illuminate\Support\Collection
     */
    protected function getMiddleware($route)
    {
        return collect($this->router->gatherRouteMiddleware($route))->map(function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        });
    }    

    protected function syncPermission()
    {
        $routes = $this->getProtectedRoutes();
        $routes->each(function(Route $route) {
            $filtered = $this->getMiddleware($route)->filter(function($middleware){
                return Str::contains($middleware,'can');
            });
            if($filtered->count() > 0) {
                $middleware = $filtered->first();
                $temp = explode(':', $middleware);
                $ability = $temp[1];
                $data = [
                    'name' => $ability,
                    'description' => $route->getAction()['desc'] ?? $ability,
                    'action' => $route->getActionName(),
                    'verbs' => $route->methods(),
                    'prefix' => $route->getPrefix(),
                    'endpoint' => $route->uri
                ];

                Permission::updateOrCreate(['name'=>$data['name']], $data);
            }


        });
    }

    
}
