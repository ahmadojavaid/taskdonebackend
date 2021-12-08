<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use App\Categories;
use App\Products; 
use App\Orders; 
use App\Customers; 
use App\ShippingDetails; 
use App\Payments; 
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon;
class ordersController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

  //..............customers funtionality

   public function show()
  {     
    // $Messages=Orders::all();

       $model = new Customers();
 
       $ipc  = $model->getipc();
 
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Orders','Result'=>$ipc]);
  }

   public function showsingleOrder(Request $request)
  {     
     $reference = $request->input('reference');

       $model = new Orders();
 
       $ipc  = $model->getipc($reference);
 
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing Orders','Result'=>$ipc]);
  }

  public function store(Request $request)
  {   

    // return $request->products_Id;
   // $Orders = Orders::insert(Input::all());

    // return $request[1]['products_Id'];
    $token = bin2hex(openssl_random_pseudo_bytes(25));

    for ($i=0; $i <count($request->products_Id) ; $i++) { 
     

        $Messages=DB::table('products')
                    ->where('id', '=', $request->products_Id) 
                    ->get();  

        $priceTaxIncl = DB::table('products') 
                 ->where('id',$request->products_Id[$i])
                 ->pluck('priceTaxIncl')
                 ->first();
        
        $priceTaxExcl = DB::table('products') 
                 ->where('id',$request->products_Id[$i])
                 ->pluck('priceTaxExcl')
                 ->first();
          // return $priceTaxIncl;

          $tax = $priceTaxIncl-$priceTaxExcl;


             $subT = DB::table('products') 
                     ->where('id',$request->products_Id[$i])
                     ->sum('priceTaxExcl');



             $totT = $subT+$tax;
                 // ->first();
            // return $priceTaxExcl;    
// $input = Input::except('credit_card');

        $Orders = new Orders();

        $Orders->customers_Id = $request->input('customers_Id');
        $Orders->products_Id = $request->products_Id[$i];
        $Orders->reference = $token;
        $Orders->subtotal = $subT;
        $Orders->tax = $tax;
        $Orders->discount = $request->input('discount');
        $Orders->total = $totT-$Orders->discount;
        $Orders->save();

               // return $request->products_Id;

    } 

        $count =  DB::table('orders') 
                     ->whereIn('products_Id',$request->products_Id)
                     ->sum('total');
                     // return $count;


     $Payments = new Payments();
     $Payments->customers_Id = $request->input('customers_Id');
     $Payments->transactionId = $request->input('transactionId');
     $Payments->method = $request->input('method');
     $Payments->amount = $count;
     $Payments->save();


     $ShippingDetails = new ShippingDetails();
     $ShippingDetails->customers_Id = $request->input('customers_Id');
     $ShippingDetails->tracking = $request->input('transactionId');
     $ShippingDetails->carrier = $request->input('carrier'); 
     $ShippingDetails->save();

    // $input = Input::only('username', 'password');

// 'customers_Id','transactionId','amount','method','date',


    return response()->json(['statusCode'=>'1','statusMessage'=>'Orders Created','Result'=>$Orders]);
  }
   
   public function update($id,Request $request)
  {     
   $Category=Orders::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
       $Category->update($request->all());

    return response()->json(['statusCode'=>'1','statusMessage'=>'Orders Data is Updated','Result'=>$Category]);
  }  
  public function destroy($id,Request $request)
  { 
   $Category=Orders::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
    $Category->delete();
    return response()->json(['statusCode'=>'1','statusMessage'=>'Orders deleted','Result'=>NULL]);
  }

   public function showorderAgainstCust(Request $request)
  {     
    $customerId = $request->Input('customerId');

            $Messages=DB::table('orders')
                    ->where('customers_Id', '=', $customerId)
                    ->join('customers','customers.id','=','orders.customers_Id')
                    ->get();
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Products','Result'=>$Messages]);
  } 


   public function updateOrderStatus(Request $request)
  {  
       $reference = $request->Input('reference');
       $status = $request->Input('status');  

        $temp = DB::table('orders')->where('reference', $reference)->update(array('statuses_id' => $status));
        $temp = DB::table('orders')->where('reference', $reference)->update(array('date' => Carbon\Carbon::now()));
        // $temp = DB::table('statuses')->where('order_reference', $reference)->update(array('colour' => $token));

    return response()->json(['statusCode'=>'1','statusMessage'=>'Order status updated','Result'=>$temp]);
  } 
   public function showproductsAgainstCust(Request $request)
  {     
    $customerId = $request->Input('customerId');

            $Messages=DB::table('orders')
                    ->where('customers_Id', '=', $customerId)
                    ->join('products','products.id','=','orders.products_Id')
                    ->join('product_attachements','product_attachements.id','=','orders.products_Id')
                    ->get();
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Products','Result'=>$Messages]);
  } 



 
}