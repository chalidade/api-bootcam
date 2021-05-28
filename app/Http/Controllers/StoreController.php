<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
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
        $input      = $this->request->json()->all();
        $action     = $input["action"];
        return $this->$action($input);
    }

    function addToCart($input) {
      $user_id     = $input["user_id"];
      $product_id  = $input["product_id"];

      $list_cart   = (array) DB::table("tmp_cart")->where("cart_user_id", $user_id)->first();
      $json        = !empty($list_cart["cart_json"]) ? json_decode($list_cart["cart_json"]) : [];

      if(!in_array($product_id, $json)) {
        array_push($json, $product_id);
      } else {
        $list_cart  = DB::table("tx_hdr_product")->whereIn("product_id", $json)->get();
        return ["success"=>false,"message"=>"Product Already on Cart", "product"=>$list_cart];
      }

      $update_cart = DB::table("tmp_cart")->where("cart_user_id", $user_id)->update(["cart_json" => $json]);
      $list_cart   = DB::table("tx_hdr_product")->whereIn("product_id", $json)->get();

      return ["success"=>true, "message"=>"Success add to cart", "product"=>$list_cart];
    }

    function deleteToCart($input) {
      $user_id     = $input["user_id"];
      $product_id  = $input["product_id"];

      $list_cart   = (array) DB::table("tmp_cart")->where("cart_user_id", $user_id)->first();
      $json        = !empty($list_cart["cart_json"]) ? json_decode($list_cart["cart_json"]) : [];

      if(!in_array($product_id, $json)) {
        array_push($json, $product_id);
      }

      if(($key = array_search($product_id,$json)) !== false) {
       unset($json[$key]);
      }

      $update_cart = DB::table("tmp_cart")->where("cart_user_id", $user_id)->update(["cart_json" => $json]);
      $list_cart   = DB::table("tx_hdr_product")->whereIn("product_id", $json)->get();
      return ["success"=>true, "message"=>"Delete item success", "product"=>$list_cart];
    }
    //
}
