<?php

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\CategoryController;



  Route::apiResource('company', CompanyController::class);
   Route::apiResource('category', CategoryController::class);

