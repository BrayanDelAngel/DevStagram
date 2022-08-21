<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
   public  function index() {
        return view('auth.register');
    }
    public  function store(Request $request) {
        // dd($request);
        //  dd($request->get('username'));
        //Modificar request
        $request->request->add(['username'=>Str::slug($request->username)]);
        //Validacion
        $this-> validate($request,[
            'name'=>['required','max:30'],
            'username'=>['required','unique:users','min:3','max:20'],
            'email'=>['required','unique:users','max:60','email'],
            'password'=>['required','min:6','confirmed']
        ]);
        
        User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=> Hash::make($request->password),
        ]);
        //Autenticar
        // auth()->attempt([
        //     'email'=>$request->email,
        //     'password'=>$request->password
        // ]);
        //Otra forma
            auth()->attempt($request->only('email','password'));
        //Redireccionar
        return redirect()->route('post.index',auth()->user()->username);
    }
}
