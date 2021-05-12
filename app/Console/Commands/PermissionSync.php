<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use Closure;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

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
    protected function getRoutes()
    {
        $routes = collect($this->router->getRoutes())->filter(function(Route $route){
            return Str::contains($this->getMiddleware($route), 'api');
        });

        return $routes;
    }        

    /**
     * Get the middleware for the route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    protected function getMiddleware($route)
    {
        return collect($this->router->gatherRouteMiddleware($route))->map(function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        })->implode("\n");
    }    

    protected function syncPermission()
    {
        $routes = $this->getRoutes();
        $routes->each(function(Route $route) {

            $data = [
                'name' => $route->getName(),
                'description' => $route->getAction()['desc'] ?? '',
                'action' => $route->getActionName(),
                'verb' => $route->methods()[0],
                'endpoint' => $route->uri
            ];
            Permission::updateOrCreate(['name'=>$data['name']], $data);
        });
    }

    
}
