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
use App\calendar_events; 
use App\Lists; 
use App\Customers; 
use App\ListCards; 
use App\ListMembers; 
use App\ListLabels; 
use Illuminate\Support\Facades\Mail;
use DB;
 
class calendarController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }


   public function showcalendar()
  { 
  

    // $Messages=calendar_events::find($id);
    $calendarArray = []; 

    $createdBy = input::get('createdBy');

      $temp  =   DB::table('calendar_events') 
                   ->where('createdBy','=',$createdBy)
                      ->pluck('calendarData');
                  
           //    array_push($calendarArray, ...$temp);
         
           // $about = DB::table('calendar_events')       
           //               ->get();  

           //    for ($i=0; $i <count($about) ; $i++) { 
                    
           //         $jsonT =  json_decode($about[$i]->members);
                     
           //          for ($j=0; $j <count($jsonT) ; $j++) { 
                                
           //                  if ($jsonT[$j] == $createdBy) {
           //                      // return json_encode($about[$i]->calendarData);
           //                    array_push($calendarArray, $about[$i]->calendarData);
           //                   }
           //             }       
           //        }
 
                 return json_encode($temp);  
             
      return response()->json(['statusCode'=>'1','statusMessage'=>'calendar_events Created','Result'=>$slash]);
   
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all calendar_events','Result'=>$Messages]);
  }  
  
  public function store(Request $request)
  {  

    // return $request->createdBy;

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);
    $members = json_encode($json_obj->members);
  
    // return json_encode($json_obj);
 
    $calendar_events=   DB::table('calendar_events') 
             ->where('createdBy','=',$request->createdBy)
             ->pluck('id')
             ->first();

             // return json_encode($calendar_events);
       if ($calendar_events) {

          DB::table('calendar_events') 
             ->where('createdBy','=',$request->createdBy)
             ->delete();
   

    $temp = array('createdBy' => $request->createdBy,'members' => $members,'calendarData' => json_encode($json_obj));
     
     $calendar_events =  DB::table('calendar_events')->insertGetId($temp);
 
     $calendar_events=   DB::table('calendar_events') 
             ->where('id','=',$request->createdBy)
             ->get()
             ->toArray();
 
        // $return =  str_replace('\\', '', $calendar_events);
    
               return $calendar_events;      
             }      
           else{   

      $temp = array('createdBy' => $request->createdBy,'calendarData' => json_encode($json_obj));
            
           $temp = array('createdBy' => $request->createdBy,'members' => $members,'calendarData' => json_encode($json_obj));
           $calendar_events =  DB::table('calendar_events')->insertGetId($temp);

            $calendar_events=   DB::table('calendar_events') 
                   ->where('id','=',$request->createdBy)
                   ->get()
                   ->toArray(); 
                   
                  return $calendar_events;     


           }
   }
 
}