<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
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

    public function get_all_user() {
      $user = DB::table("tx_hdr_user")->get();
      return $user;
    }

    public function get_filter_user($id) {
      $user = DB::table("tx_hdr_user")->where("USER_ID", $id)->get();
      return $user;
    }

    public function create_user() {
      $input    = $this->request->json()->all();
      $request_header   = [
        "USER_NAME"     => $input["username"],
        "USER_PASSWORD" => $input["password"]
      ];
      $check      = (array) DB::table("tx_hdr_user")->where("USER_NAME", $input["username"])->first();
      if (!$check) {
        $insert     = DB::table("tx_hdr_user")->insert($request_header);

        // $get_header = (array) DB::table("tx_hdr_user")->orderBy("USER_ID", "DESC")->first();
        // $id_header  = $get_header["USER_ID"];

        // $request_detail   = [
        //   "DTL_HDR_ID"        => $id_header,
        //   "DTL_USER_EMAIL"    => $input["email"],
        //   "DTL_USER_ADDRESS"  => $input["address"],
        //   "DTL_USER_PHONE"    => $input["phone"]
        // ];
        //
        // $insert   = DB::table("tx_dtl_user")->insert($request_detail);

        if ($insert) {
          return ["success"=>true, "data"=>"Register User Success"];
        } else {
          return ["success"=>false, "data"=>"Cannot Insert User"];
        }
      } else {
        return ["success"=>false, "data"=>"User Already Registered"];
      }
    }

    public function login() {
      $input    = $this->request->json()->all();
      $where    = [
        ["USER_NAME","=",$input["username"]],
        ["USER_PASSWORD" ,"=", $input["password"]]
      ];

      $check = (array) DB::table("tx_hdr_user")->where($where)->first();
      if ($check) {
        return ["success"=>true, "data"=>$check];
      } else {
        return ["success"=>false, "data"=>"Please Check Username / Password"];
      }
    }
}
