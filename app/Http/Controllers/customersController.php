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
use App\Customers; 
use Illuminate\Support\Facades\Mail;
use DB;
 
class customersController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

  //..............customers funtionality

   public function show()
  {     
    $Messages=Customers::all();

    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Customers','Result'=>$Messages]);
  } 
 
  public function store(Request $request)
  {  
     if ($request->has('avatar')) { 

     $format = '.png';   
     
     $entityBody =$request['avatar'];// file_get_contents('php://input');

     $Activities = Customers::create($request->except(['avatar']));
     $imageName = $Activities->id.$format; 
    // return $entityBody;
      $directory = "/images/customerImages/";
      $path = base_path()."/public".$directory;
      $data = base64_decode($entityBody);

     file_put_contents($path.$imageName, $data);

      $response = $directory.$imageName;

      $Activities->avatar = $response;

      $Activities->save();
    }
    else{
      $Activities = Customers::create($request->except(['avatar']));
    return response()->json(['statusCode'=>'1','statusMessage'=>'Customers Created','Result'=>$Activities]);
    }

     // $Activities = Customers::create($request->all());

    return response()->json(['statusCode'=>'1','statusMessage'=>'Customers Created','Result'=>$Activities]);
  }
  

   public function update($id,Request $request)
  {     
   $Category=Customers::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
       $Category->update($request->all());

    return response()->json(['statusCode'=>'1','statusMessage'=>'Customers Data is Updated','Result'=>$Category]);

  } 

  public function destroy($id,Request $request)
  { 
   $Category=Customers::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
    $Category->delete();
    return response()->json(['statusCode'=>'1','statusMessage'=>'Customers deleted','Result'=>NULL]);
  }
 
    
 
}