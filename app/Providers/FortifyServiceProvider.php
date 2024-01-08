<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\DummyDummy;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Customize Login or override default login logic
        /*
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::find(1); // Note! For demo purpose only, hard code User as sample
            return $user;

            // grab credentials from request

            // lookup user from db

            // verify credentials

            // return user model if correct

        });
        */

        // Note! This is just a demo for custom authentication if needed to be customzied
        /*
        Fortify::authenticateThrough(function (Request $request) {
            
            // ...invokable classes or class with __invoke method
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
//                DummyDummy::class,
//                DummyDummy::class,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,
            ]);
        });
        */

        /* Note! This a demo for custom password confirmation
        Fortify::confirmPasswordsUsing(function ($user, $password){
            // for the confirm password endpoint
            // return true if password is correct
            // return false if password input is wrong
        });
        */

        // Note! The following are the views to be customized if needed
        /*
        Fortify::confirmPasswordView(function (){
            return view('some.view.in.your.app');
        });
        Fortify::verifyEmailView(function (){
            return view('auth.verify');
        });
        Fortify::loginView(fn () => view('some.view.in.your.app'));
        Fortify::registerView(fn () => view('some.view.in.your.app'));
        Fortify::twoFactorChallengeView(fn () => view('some.view.in.your.app'));
        Fortify::requestPasswordResetLinkView(fn () => view('some.view.in.your.app'));
        Fortify::resetPasswordView(fn () => view('some.view.in.your.app'));
        */
    }
}
