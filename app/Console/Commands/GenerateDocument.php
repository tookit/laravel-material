<?php

namespace App\Console\Commands;

use App\Models\User;
use Closure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class GenerateDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:doc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate REST API document';


    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;


    /**
     * Create a new route command instance.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct();

        $this->router  = $router;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // list routes -> parse action -> 
        $this->genRoutes();
        $this->genModels();
        return 0;
    }

    /**
     * Gen all model definination
     */
    public function genModels()
    {
        $ret = collect([]);
        $tables = Schema::connection('mysql')->getAllTables();
        foreach($tables as $table)
        {
            $item = [];
            $tableName = $table->Tables_in_demo;
            $item['table'] = $tableName;
            $item['fields'] = DB::select(DB::raw("SHOW FIELDS FROM {$tableName}"));
            $ret->push($item);
        }
        Storage::put('explore/models.json',$ret->toJson());        
        return $ret;
    }


    public function genRoutes()
    {
        $routes = $this->getRoutes();
        return Storage::put('explore/routes.json',$routes->toJson());

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
        $routes = $routes->map(function (Route $route) {
            return $this->getRouteInformation($route);
        });

        return $routes;
    }    


    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        return [
            'domain' => $route->domain(),
            'method' => implode('|', $route->methods()),
            'uri'    => $route->uri(),
            'name'   => $route->getName(),
            'desc' => $route->getAction()['desc'] ?? '',
            'prefix' => $route->getPrefix(),
            'action' => ltrim($route->getActionName(), '\\'),
            'middleware' => $this->getMiddleware($route),
        ];
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


    /**
     * Remove unnecessary columns from the routes.
     *
     * @param  array  $routes
     * @return array
     */
    protected function pluckColumns(array $routes)
    {
        return array_map(function ($route) {
            return Arr::only($route, $this->getColumns());
        }, $routes);
    }

}
