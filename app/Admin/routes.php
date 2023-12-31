<?php

use App\Admin\Controllers\ContentController;
use App\Admin\Controllers\LinkController;
use App\Admin\Controllers\ReportController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('reports', ReportController::class);
    $router->resource('contents', ContentController::class);
    $router->resource('links', LinkController::class);
});
