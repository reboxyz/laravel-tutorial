<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\RoutePath;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app', function() {
    return view('app');
});

Route::get(RoutePath::for('password.reset', '/reset-password/{token}'), function($token) {
    return view('auth.password-reset', [
        'token' => $token
    ]);
})
->middleware(['guest:'.config('fortify.guard')])
->name('password.reset');

if (\Illuminate\Support\Facades\App::environment('local')) {
    Route::get('/playground', function () { 

        // Internationalization Sample Start
        //Lang::setLocale('es'); // Note! This is only affects locally and not the App level
        App::setLocale('en');  // Note! This affects the App level

        $trans = Lang::get('auth.failed');
        $trans = __('auth.failed');
        $trans = __('auth.throttle', ['seconds' => 5]); // with placeholder

        // current locale
        dump(App::isLocale('en'));
        dump(App::currentLocale());

        //$trans = __('this is sparta');  // Translation using json

        //$trans = trans_choice('auth.pants', 1); // singular
        $trans = trans_choice('auth.pants', 2); // plural

        // Using range the the translation
        $trans = trans_choice('auth.apples', -1);
        $trans = trans_choice('auth.apples', 0);
        $trans = trans_choice('auth.apples', 1);
        $trans = trans_choice('auth.apples', 2, ['baskets' => 3]); // count and placeholder

        // Capitlization variation
        $trans = __('auth.welcome', ['name' => 'sam']);

        dd($trans);

        // Internationalization Sample End

        /*
        $user = User::factory()->make();

        \Illuminate\Support\Facades\Mail::to($user)
        ->send(new \App\Mail\WelcomeMail($user));
       
        return null;
        */
        //return (new \App\Mail\WelcomeMail($user))->render();
    });
}