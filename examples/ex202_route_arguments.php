<?php

/**
 * @TODO Add explanation
 * 
 * To run:
 * $ bin/aerys -a examples/ex202_route_arguments.php
 */

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/support/Ex202_RouteArguments.php';

$app = (new Aerys\Framework\App)
    ->addRoute('GET', '/', 'Ex202_RouteArguments::index')
    ->addRoute('GET', '/$#arg1', 'Ex202_RouteArguments::numericArg')
    ->addRoute('GET', '/$arg1', 'Ex202_RouteArguments::anythingArg')
    ->addRoute('GET', '/$#arg1/$#arg2/$arg3', 'Ex202_RouteArguments::mixedArgs')
;
