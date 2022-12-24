<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Notifications\PasswordResetPublish;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function password_send(Request $request){
     
      $user = User::where('email',$request->email)->first();
      if($user != null){
        $password = Str::random(8);
        $user->password = bcrypt($password);
        $user->password_changed_at = Carbon::now()->toDateTimeString();
        $user->update();

        $user->notify(new PasswordResetPublish($password));
        return redirect('/password-reset')->with('status', 'A new password was sent to your email address.');
      }else{

      }
       return redirect('/password-reset')->with('error', 'Whoops! Something went wrong.
       This email is not in our database.');
     
    }
}
