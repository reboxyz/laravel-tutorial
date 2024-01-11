<?php

use App\Models\Post;
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

Route::get('/shared/posts/{post}', function(Illuminate\Http\Request $request, Post $post) {
    return "Specially made just for you:) Post id: {$post->id}";
})->name('shared.post')->middleware('signed');

if (\Illuminate\Support\Facades\App::environment('local')) {

    // Note! This is the route to be shared but with signature
    Route::get('/shared/videos/{video}', function(Illuminate\Http\Request $request, $video) {

        /* Note! This is explicit code if not using the 'signed' middleware
        if (! $request->hasValidSignature())
        {
            abort(401);
        }
        */

        return 'git gud';
    })->name('share-video')->middleware('signed');

    Route::get('/playground', function () { 

        // Signed Route
        $url = URL::temporarySignedRoute('share-video', now()->addSeconds(30), [
            'video' => 134
        ]);
        return $url;

        // Internationalization Sample Start
        /*
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
        */
        /*
        $user = User::factory()->make();

        \Illuminate\Support\Facades\Mail::to($user)
        ->send(new \App\Mail\WelcomeMail($user));
       
        return null;
        */
        //return (new \App\Mail\WelcomeMail($user))->render();
    });
}