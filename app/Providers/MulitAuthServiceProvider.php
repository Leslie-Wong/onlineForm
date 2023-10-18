<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Laravel\Fortify\Contracts\LoginResponse;

class MulitAuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->when([AuthenticatedSessionController::class, AttemptToAuthenticate::class,
        RedirectIfTwoFactorAuthenticatable::class])

            ->needs(StatefulGuard::class)

            ->give(function() {
                if(request()->email){
                    $user = \App\Models\User::where('email', request()->email)->first();

                    if ($user &&
                    Hash::check( request()->password, $user->password)){
                        return Auth::guard('web');
                    }

                    $admin = \App\Models\Admin::where('email', request()->email)->first();
                    if($admin &&
                    Hash::check( request()->password, $admin->password)){
                        return Auth::guard('admin');
                    }
                }


                return Auth::guard(config('fortify.guard', null));
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if(\Auth::guard('admin')->user()){
                    return redirect('admin/');
                }else{
                    // return redirect('admin/gen-quotation-logs');
                    return redirect('admin/');
                }
                // if(in_array('admin', \Auth::user()->roles->map->name))
                //     return redirect('admin/');
                // else
                //     eturn redirect('admin/');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
