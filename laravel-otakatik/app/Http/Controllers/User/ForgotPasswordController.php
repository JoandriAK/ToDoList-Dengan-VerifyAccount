<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgotPasswordForm(){
        return view('user.forgot-password');
    }

    public function doForgotPasswordForm(Request $request){
        $request->validate([
            'email'=>'required|email|exists:users'
        ],[
            'email.required'=>'Email harus diisi',
            'email.email'=>'Format email tidak valid',
            'email.exists'=>'Email yang anda masukkan tidak terdaftar',
        ]);


        UserVerify::where('email',$request->input('email'))->delete();

        $token = Str::uuid();
        $data = [
            'email' => $request->input('email'),
            'token' => $token
        ];

        UserVerify::create($data);

         Mail::send('user.email-reset-password',['token'=>$token],function($message) use($request){
            $message->to($request->input('email'));
            $message->subject('Reset Password');
        });

        return redirect()->route('forgotpassword')->with('success','email berisikan instruksi reset password sudah dikirimkan, silahkan cek terlebih dahulu')->withInput();
    }

    public function resetPassword($token){
        return view('user.reset-password',compact('token'));
    }

    public function doResetPassword(Request $request){
        $request->validate([
                'password'=>'required|string|min:6',
                'password-confirmation' => 'required_with:password|same:password'
            ],[
                'password.required'=>'Password harus diisikan',
                'password.string'=>'Hanya string yang diperbolehkan',
                'password.min'=>'Minimum karakter unuk password adalah 6 karakter',
                'password-confirmation.required_with'=>'Password konfirmasi harus diisi',
                'password-confirmation.same'=>'Password konfirmasi tidak boleh berbeda dengan password yang di masukkan',

            ]
        );

        $dataUser = UserVerify::where('token',$request->input('token'))->first();

        if(!$dataUser){
            return redirect()->back()->withInput()->withErrors('Token tidak valid');
        }

        $email = $dataUser->email;
        $data=[
            'password'=>bcrypt($request->input('password')),
            'email_verified_at'=>Carbon::now()
        ];
        User::where('email',$email)->update($data);

        UserVerify::where('email',$email)->delete();
        return redirect()->route('login')->with('success','Password sudah berganti, silahkan login menggunakan passsword baru anda');
    }
}
