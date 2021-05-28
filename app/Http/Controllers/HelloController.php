<?php

namespace App\Http\Controllers;

class HelloController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function main() {
      return \DB::table("tx_hdr_user")->get();
    }
    //
}
