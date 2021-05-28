<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
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

    public function save($input) {
      $data   = $input["data"];
      $insert = DB::table($input["table"])->insert($data);
      if($insert) {
        return ["success"=> true, "message"=>"Register Success"];
      } else {
        return ["success" => false, "message"=>"Register Failed"];
      }
    }

    public function update($input) {
      $data   = $input["data"];
      $update = DB::table($input["table"])->where($input["where"])->update($input["data"]);
      if($update) {
        return "success";
      } else {
        return "failed";
      }
    }
    //
}
