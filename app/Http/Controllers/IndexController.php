<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
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

    public function main()
    {
        $input  = $this->request->json()->all();
        $action = $input["action"];
        return $this->$action($input);
    }

    public function list($input) {
      $table  = $input["table"];
      $data   = DB::table($table);

      if(!empty($input["where"]))
        $data->where($input["where"]);

      if(!empty($input["whereIn"]))
        $data->whereIn($input["whereIn"][0], $input["whereIn"][1]);

      if(!empty($input["select"]))
        $data->select($input["select"]);

      if(!empty($input["join"])) {
        $join   = $input["join"];
        $data->join($join[0], $join[1], $join[2], $join[3]);
      }

      $data   = $data->get();

      $result["count"] = count($data);
      $result["data"]  = $data;

      return $result;
    }
    //
}
