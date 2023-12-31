<?php 

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/* Note! Route::apiResource is similar to each individual endpoint below 
Route::apiResource('users', UserController::class);
*/


Route::middleware([
    //'auth'
    ])
    ->name('users.')
    ->group(function () {

    Route::get('/users', [UserController::class, 'index'])->name('index')
        //->withoutMiddleware('auth')
    ;

    Route::get('/users/{user}', [UserController::class, 'show'])->name('show')
    ->whereNumber('user');
    
    Route::post('/users', [UserController::class, 'store'])->name('store');

    Route::put('/users/{user}', [UserController::class, 'update'])->name('update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('destroy');

});


?>