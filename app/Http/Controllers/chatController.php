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
use App\Boards; 
use App\Lists; 
use App\Customers; 
use App\ListCards; 
use App\ListMembers; 
use App\ListLabels; 
use Illuminate\Support\Facades\Mail;
use DB;
 
class chatController extends Controller
{  

 public function chats(Request $request)
  {       



			    $json_str = file_get_contents('php://input');
			    $json_obj = json_decode($json_str);


			  	 // return  $json_obj->id; 
			  
			    // return json_encode($json_obj);
			 
			    // $boards=   DB::table('boards') 
			    //          ->where('id','=',$id)
			    //          ->pluck('id')
			    //          ->first();
			    //          // return json_encode($json_obj);
			    //    if ($boards) { 

			    //       DB::table('boards') 
			    //          ->where('id','=',$id)
			    //          ->delete();

			     $temp = array('sentBy' => $request->sentBy,'dialogue' => json_encode($json_obj),'chatId' => $json_obj->id);
			   
			     $boards =  DB::table('chats')->insertGetId($temp);
 		 	 	 	
			     // $boards=   DB::table('boards') 
			     //         ->where('id','=',$id)
			     //         ->get()
			     //         ->toArray(); 
			     //    $return =  str_replace('\\', '', $boards);
			    
			               return $boards;      
			           //   }      
			           // else{   
			            
			           // $temp = array("id" => $id,'createdBy' => $request->createdBy,'boardData' => json_encode($json_obj));
			           // $boards =  DB::table('boards')->insertGetId($temp);

			           //  $boards=   DB::table('boards') 
			           //         ->where('id','=',$id)
			           //         ->get()
			           //         ->toArray(); 
			           //    $return =  str_replace('\\', '', $boards);
			           //   return $return;   

			   return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Boards','Result'=>$boards]);
			     
	 	 // }  

	}


	 public function userData(Request $request)
	  {        

			    $json_str = file_get_contents('php://input');
			    $json_obj = json_decode($json_str);


			  	 // return json_encode($json_obj); 
			  
			    // return json_encode($json_obj);
			 
			    // $boards=   DB::table('boards') 
			    //          ->where('id','=',$id)
			    //          ->pluck('id')
			    //          ->first();
			    //          // return json_encode($json_obj);
			    //    if ($boards) {

			    //       DB::table('boards') 
			    //          ->where('id','=',$id)
			    //          ->delete();

			     $temp = array('userId' => $request->userId,'userStaticData' => json_encode($json_obj));
			   
			     $boards =  DB::table('user_data')->insertGetId($temp);

			     // $boards=   DB::table('boards') 
			     //         ->where('id','=',$id)
			     //         ->get()
			     //         ->toArray();
			 
			     //    $return =  str_replace('\\', '', $boards);
			    
			               return $boards;      
			           //   }      
			           // else{   
			            
			           // $temp = array("id" => $id,'createdBy' => $request->createdBy,'boardData' => json_encode($json_obj));
			           // $boards =  DB::table('boards')->insertGetId($temp);

			           //  $boards=   DB::table('boards') 
			           //         ->where('id','=',$id)
			           //         ->get()
			           //         ->toArray(); 
			           //    $return =  str_replace('\\', '', $boards);
			           //   return $return;   
			   return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Boards','Result'=>$boards]);
			     
 	 // }  s
	}

	   public function showUserData($id)
  { 

   //..............New Implementation 

    // $Messages=Boards::find($id);
 
    	$temp  =   DB::table('users') 
                     ->where('id','=',$id) 
                     ->first();


            return json_encode($temp);


   }


   public function showByChatId($id)
  { 

   //..............New Implementation 

    // $Messages=Boards::find($id);
 
    	$temp  =   DB::table('chats') 
                     ->where('chatId','=',$id) 
                     ->get();

                     return $temp;
            return json_encode($temp);


   }

   	   public function showUserdialogue($id)
  { 

   //..............New Implementation 

    // $Messages=Boards::find($id);
 
    	$temp  =   DB::table('chats') 
                     ->where('sentBy','=',$id) 
                     ->get(); 

            return json_encode($temp);


   }

}
