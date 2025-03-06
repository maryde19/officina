<?php

use Illuminate\Support\Facades\Route;

Route::get('/',[\App\Http\Controllers\HomeController::class,'index']);

//Clients
Route::get('/clients',[\App\Http\Controllers\ClientsController::class,'index'])->name('clients.index');
Route::get('/clients/{id}/show',[\App\Http\Controllers\ClientsController::class,'show'])->name('clients.show');

Route::prefix('api')->group(function () {
    //Clients
    Route::get('/clients', [\App\Http\Controllers\Api\ClientsController::class, 'getClients'])->name('clients.ajax');
    Route::post('/clients', [\App\Http\Controllers\Api\ClientsController::class, 'store'])->name('clients.store');
    Route::put('/clients/{id}', [\App\Http\Controllers\Api\ClientsController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [\App\Http\Controllers\Api\ClientsController::class, 'destroy'])->name('clients.destroy');

    //Vehicles
    Route::get('/vehicles',[\App\Http\Controllers\Api\VehiclesController::class,'getVehicles'])->name('vehicles.ajax');
    Route::post('/vehicles',[\App\Http\Controllers\Api\VehiclesController::class,'store'])->name('vehicles.store');
    Route::delete('/vehicles/{id}',[\App\Http\Controllers\Api\VehiclesController::class,'destroy'])->name('vehicles.destroy');

    //Services
    Route::get('/services',[\App\Http\Controllers\Api\ServicesController::class,'getServices'])->name('services.ajax');
    Route::post('/services',[\App\Http\Controllers\Api\ServicesController::class,'store'])->name('services.store');
    Route::delete('/services/{id}',[\App\Http\Controllers\Api\ServicesController::class,'destroy'])->name('services.destroy');

    //Calendar
    Route::get('/calendar',[\App\Http\Controllers\HomeController::class,'getEventsCalendar'])->name('calendar.index');
});
