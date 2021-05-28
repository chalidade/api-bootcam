<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function main() {
      $user = \DB::table("tx_hdr_user")->get();
      return $user;
    }

    public function hello() {
      $user = DB::table("tx_hdr_user")->get();
      return $user;
    }

    public function filter_user($id) {
      $user = (array) \DB::table("tx_hdr_user")->where("user_id", $id)->first();
      return $user;
    }

    public function create_user() {
      $input  = $this->request->all();
      $data   = [
        "USER_NAME" => $input["USER_NAME"],
        "USER_PASSWORD" => base64_encode($input["USER_PASSWORD"])
      ];

      $user   = \DB::table("tx_hdr_user")->where("USER_NAME", $input["USER_NAME"])->count();

      if(empty($user)) {
          $insert = \DB::table("tx_hdr_user")->insert($data);
          return ["success"=>TRUE, "message"=>"Insert Success"];
      } else {
          return ["success"=>False, "message"=>"Insert Failed"];
      }

    }

    public function update_user($id) {
      $input  = $this->request->all();
      $update = DB::table("tx_hdr_user")->where("user_id", $id)->update(["USER_NAME"=>$input["USER_NAME"], "USER_PASSWORD"=>$input["USER_PASSWORD"] ]);

      if($update)
        return ["success"=>TRUE, "message"=>"Update Success"];
      else
        return ["success"=>False, "message"=>"Update Failed"];
    }

    public function delete_user($id) {
      $delete = DB::table("tx_hdr_user")->where("user_id", $id)->delete();

      if($delete)
        return ["success"=>TRUE, "message"=>"Delete Success"];
      else
        return ["success"=>False, "message"=>"Delete Failed"];
    }

    //
}
