<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function main() {
      $input  = $this->request->json()->all();
      $action = $input["action"];
      return $this->$action($input);
    }

    public function login() {
        // 1. Buat format Json {username:"", password:""}
        // 2. Panggil table user where username dan password
        // 3. Jika data ada maka return ["success"=>true, "message"=>"Anda Berhasil Login"]
        // 4. Jika data Nggak Ada maka return ["success"=>false, "message"=>"Periksa Username dan Password"]
    }
}
