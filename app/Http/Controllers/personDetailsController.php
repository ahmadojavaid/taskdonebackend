<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use App\Users;
use App\Products;
use App\ProductAttachements;
use Illuminate\Support\Facades\Mail;
use DB;

class personDetailsController extends Controller
{

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

  //..............categories funtionality

   public function person(Request $request)
  {
    $Messages=Users::all();

    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Users','Result'=>$Messages]);
  }



}
