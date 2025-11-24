<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    function login(){
        return view('user.login');
    }
    
    function doLogin(Request $request){
        $data = [
            'email'=>$request->input('email'),
            'password'=>$request->input('password')
        ];

        if(Auth::attempt($data)){
            if(Auth::user()->email_verified_at==''){
                Auth::logout();
                return redirect()->route('login')->withErrors('Email belum terverifikasi, Silakan cek email anda kembali.')->withInput();

            }else{
            return redirect()->route('todo');
            }
        }else{
            return redirect()->route('login')->withErrors('Username dan password tidak sesuai')->withInput();
        }

    }

    function register(){
        return view('user.register');
    }

    function doRegister(Request $request){
        $request->validate([
                'email'=>'required|string|email:rfc,dns|max:100|unique:users,email',
                'name'=>'required|min:5|max:25',
                'password'=>'required|string|min:6',
                'password-confirmation' => 'required_with:password|same:password'
            ],[
                'email.required'=>'Email harus diisi',
                'email.string'=>'Email harus diisi dalam type string',
                'email.email'=>'Email harus diisi haruslah valid',
                'email.max'=>'Maksimum karakter untuk email adalah 100 karakter',
                'email.unique'=>'Email sudah terdapat di database kami',
                'name.required'=>'Kolom nama harus di isi',
                'name.min'=>'Minimum karakter untuk nama adalah 5 karakter',
                'name.max'=>'Maksimum karakter untuk nama adalah 25 karakter',
                'password.required'=>'Password harus diisikan',
                'password.string'=>'Hanya string yang diperbolehkan',
                'password.min'=>'Minimum karakter unuk password adalah 6 karakter',
                'password-confirmation.required_with'=>'Password konfirmasi harus diisi',
                'password-confirmation.same'=>'Password konfirmasi tidak boleh berbeda dengan password yang di masukkan',

            ]
        );

        $data=[
            'email'=>$request->input('email'),
            'name'=>$request->input('name'),
            'password'=>bcrypt($request->input('password')),
        ];

        User::create($data);
        $cekToken = UserVerify::where('email',$request->input('email'))->first();
        if($cekToken){
            UserVerify::where('email',$request->input('email'))->delete();
        }

        $token=Str::uuid();
        $data=[
            'email'=>$request->input('email'),
            'token'=> $token
        ];
        UserVerify::create($data);

        Mail::send('user.email-verification',['token'=>$token],function($message) use($request){
            $message->to($request->input('email'));
            $message->subject('Email verification');
        });

        return redirect()->route('register')->with('success', 'Email verifikasi telah dikirimkan, silakan cek terlebih dahulu')->withInput();
    }
    
    


    function updateData(){
        return view('user.update-data');
    } 

    function doUpdateData(Request $request){
            $request->validate([
                'name'=>'required|min:5|max:25',
                'password'=>'nullable|string|min:6',
                'password-confirmation' => 'required_with:password|same:password'
            ],[
                'name.required'=>'Kolom nama wajib diisi',
                'name.min'=>'Minimum karakter untuk nama adalah 5 karakter',
                'name.max'=>'Maksimum karakter untuk nama adalah 25 karakter',
                'password.string'=>'Hanya string yang diperbolehkan',
                'password.min'=>'Minimum karakter unuk password adalah 6 karakter',
                'password-confirmation.required_with'=>'Password konfirmasi harus diisi',
                'password-confirmation.same'=>'Password konfirmasi tidak boleh sama dengan password yang di masukkan',

            ]
        );

        $data = [
            'name'=>$request->input('name'),
            'password'=>$request->input('password')?bcrypt($request->input('password')):Auth::user()->password

        ];

        User::where('id',Auth::user()->id)->update($data);
        return redirect()->route('user.updatedata')->with('success','Berhasil update data user');

    }

    function logOut(){
        Auth::logout();
        return redirect()->route('login');
    }

    function verifyAccount($token){
       $chekuser = UserVerify::where('token', $token)->first();
       if (!is_null($chekuser)){
        $email = $chekuser->email;

        $datauser = User::where('email',$email)->first();
        if($datauser->email_verified_at){
            $message = "Akun anda sudah terverifikasi sebelumnya";

        }else{
            $data=[
                'email_verified_at' => Carbon::now()
            ];
            
            User::where('email', $email)->update($data);
            UserVerify::where('email', $email)->delete();
            $message = "Akun anda sudah terverifikasi, silakan login";
        }

        return redirect()->route('login')->with('success', $message);
       }else{
        return redirect()->route('login')->withErrors('Link token tidak valid');
       }
    }

}
