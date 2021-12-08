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
use App\Payments; 
use Illuminate\Support\Facades\Mail;
use DB;
 
class paymentsController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

  //..............customers funtionality

   public function show()
  {     
    $Payments=Payments::all();

    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Orders','Result'=>$Payments]);
  } 
 
  public function store(Request $request)
  {    

    $Payments = Payments::insert(Input::all());

    return response()->json(['statusCode'=>'1','statusMessage'=>'Payments Created','Result'=>$Payments]);
  }
   
   public function update($id,Request $request)
  {     
   $Category=Payments::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
       $Category->update($request->all());

    return response()->json(['statusCode'=>'1','statusMessage'=>'Payments Data is Updated','Result'=>$Category]);
  }  
  public function destroy($id,Request $request)
  { 
   $Category=Payments::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
    $Category->delete();
    return response()->json(['statusCode'=>'1','statusMessage'=>'Payments deleted','Result'=>NULL]);
  }
 

 
}