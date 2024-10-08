<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
  
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;
use App\Models\Globalsetting;
  
class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            //return redirect()->back();
            return redirect()->route('home');
        }
        $globalsetting = Globalsetting::where("id", 1)->first();
        return view('login', ["globalsetting" => $globalsetting]);
    }
  
    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string',
            // 'otp'                   => 'required|string',
        ];
  
        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string',
            'otp.required'          => 'OTP harus diisi',
            'otp.string'            => 'OTP harus berupa string'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        if(env('USEOTP') == 1){
            $data = [
                'email'     => $request->input('email'),
                'password'  => $request->input('password'),
                'otp'       => md5($request->input('otp')),
            ];
        }else{
            $data = [
                'email'     => $request->input('email'),
                'password'  => $request->input('password')
            ];
        }
  
        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            $globalsetting = Globalsetting::where("id", 1)->first();
            Session::put('nama_instansi', $globalsetting['nama_instansi']);
            Session::put('logo_instansi', $globalsetting['logo_instansi']);
            Session::put('global_setting', $globalsetting);
            
            User::where("id", Auth::user()->id)->update(["otp" => null]);

            return redirect()->route('home');
            //return redirect()->back();
  
        } else { // false
  
            //Login Fail
            Session::flash('error', 'Email atau password atau OTP salah');
            return redirect()->route('login');
        }
  
    }
  
    public function showFormRegister()
    {
        //return view('register');
        return view('authentication/registration');
    }
  
    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ];
  
        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $simpan = $user->save();
  
        if($simpan){
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }
  
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('login');
    }
  
  
}