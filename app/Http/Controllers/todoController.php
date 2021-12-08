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
use App\Lists; 
use App\Customers; 
use App\ListCards; 
use App\ListMembers; 
use App\ListLabels; 
use App\Tags; 
use App\Todos; 
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;

 
class todoController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

  //..............tags funtionality

  //  public function show()
  // {      
  //   // $Messages=tags::all();
  //   // return $Messages;
 
  //   $tags  =   DB::table('tags')  
  //                ->pluck('boardData');    
  //       return $tags;
  //  return response()->json(['statusCode'=>'1','statusMessage'=>'showing all tags','Result'=>$tags]);
  // }  
 
   public function showBoard($id)
  { 

   //..............New Implementation 

    // $Messages=tags::find($id);
 
    $temp  =   DB::table('tags') 
                   ->where('id','=',$id)
                     ->pluck('boardData')
                     ->toArray();    
        
                     $return =  str_replace('\\', '', $temp);

                     return $return;

          // return str_replace('\/','/',json_encode($temp));

          // $string=implode(" ",explode("\\\\ ",$temp));
          // $return=stripslashes(trim($string)); 

          // $slash =  json_encode($return, JSON_UNESCAPED_SLASHES);
      return response()->json(['statusCode'=>'1','statusMessage'=>'tags Created','Result'=>$slash]);
  
         $model = new tags();
   
        $ipc  = $model->getipc($id); 

        return $ipc;
   
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all tags','Result'=>$Messages]);
  }  
  
  // public function unsetValue(array $array, $value, $strict = TRUE)
  
  //     {
  //         if(($key = array_search($value, $array, $strict)) !== FALSE) {
  //             unset($array[$key]);
  //         }
  //         return $array;
  //   } 

  public function store(Request $request,$id)
  {  

    // return $request; 

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);
    

    $tantri = json_encode($json_obj->tags);
    $tantri2 = json_encode($json_obj->members);

    // return $tantri;
    // return json_encode($json_obj);
 
    $tags=   DB::table('todos') 
             ->where('id','=',$id)
             ->pluck('id')
             ->first();
             // return json_encode($json_obj);
       if ($tags) {

          DB::table('todos') 
             ->where('id','=',$id)
             ->delete();
 

        $Todos = new Todos();
  
        $Todos->id = $tags;
        $Todos->title = $request->Input('title');
        $Todos->userId = $request->Input('userId');
        $Todos->notes = $request->Input('notes');
        $Todos->startDate = $request->Input('startDate'); 
        $Todos->dueDate = $request->Input('dueDate');
        $Todos->completed = $request->Input('completed');
        $Todos->starred = $request->Input('starred');
        $Todos->important = $request->Input('important');
        $Todos->deleted = $request->Input('deleted');
        $Todos->tags = $tantri;
        $Todos->members = $tantri2;

        $Todos->save();  


 // $temp = array("id" => $tags,'title' =>$request->Input('title'),'notes' =>  $request->Input('notes'),'startDate' => $request->Input('startDate'),'dueDate' => $request->Input('dueDate'),'completed' => $request->Input('completed'),'starred' => $request->Input('starred'),'important' => $request->Input('important'),'deleted' => $request->Input('deleted'),'tags' => $request->Input('tags'),'members' => $request->Input('members'));
 
 //     $tags =    DB::table('todos')->insertGetId($temp);

     // $temp = array("id" => $id,'title' => json_encode($json_obj->title),'notes' => json_encode($json_obj->notes),'startDate' => json_encode($json_obj->startDate),'dueDate' => json_encode($json_obj->dueDate),'completed' => json_encode($json_obj->completed),'starred' => json_encode($json_obj->starred),'important' => json_encode($json_obj->important),'deleted' => json_encode($json_obj->deleted),'tags' => json_encode($json_obj->tags));
 
     // $tags =    DB::table('todos')->insertGetId($temp);
 
     // $tags=   DB::table('todos') 
     //         ->where('id','=',$id)
     //         ->get()
     //         ->toArray();
 
     //    $return =  str_replace('\\', '', $tags);
    
     //           return $return;      
             }      
           else{   

                   $Todos = new Todos();

        $Todos->id = $id;
        $Todos->title = $request->Input('title');
        $Todos->userId = $request->Input('userId');
        $Todos->notes = $request->Input('notes');
        $Todos->startDate = $request->Input('startDate'); 
        $Todos->dueDate = $request->Input('dueDate');
        $Todos->completed = $request->Input('completed');
        $Todos->starred = $request->Input('starred');
        $Todos->important = $request->Input('important');
        $Todos->deleted = $request->Input('deleted');
        $Todos->tags = $tantri;
        $Todos->members = $tantri2;

        $Todos->save(); 


       
                // $temp = array("id" => $id,'title' => json_encode($json_obj->title),'notes' => json_encode($json_obj->notes),'startDate' => json_encode($json_obj->startDate),'dueDate' => json_encode($json_obj->dueDate),'completed' => json_encode($json_obj->completed),'starred' => json_encode($json_obj->starred),'important' => json_encode($json_obj->important),'deleted' => json_encode($json_obj->deleted),'tags' => json_encode($json_obj->tags));

                 // $tags =  DB::table('todos')->insertGetId($temp);


               $tags=   DB::table('todos') 
                         ->where('id','=',$id)
                         ->get()
                         ->toArray(); 
                    $return =  str_replace('\\', '', $tags);
                   return $return;     
 
                } 
         } 


   public function getTodo()
    { 
  
   $todoArray= [];
   $todoArray2= [];


   $userId =  input::get('userId'); 
   
      $temp  =   DB::table('todos')
                    ->where('userId', '=', $userId)  
                    ->get()   
                    ->toArray();

                    array_push($todoArray2, $temp);
            // if ($temp == []) {

           $about = DB::table('todos')       
                         ->get(); 

              for ($i=0; $i <count($about) ; $i++) { 
                    
                   $jsonT =  json_decode($about[$i]->members);
                     
                    for ($j=0; $j <count($jsonT) ; $j++) { 
                                
                            if ($jsonT[$j] == $userId) {
                                
                              array_push($todoArray, $about[$i]);
                             }

                         }      

                }
                $resultArray = array_merge($todoArray, ...$todoArray2);

                 return $resultArray; 
                 
             return $temp;
     }   
   public function getFileters()
    { 
 
      $temp  =   DB::table('filters')
                    ->get()   
                     ->toArray();     
                      return $temp;
     }  
 
      public function getTags()
     { 
 
      $temp  =   DB::table('tags')
                     ->get()   
                     ->toArray();    
                      return $temp;
     } 
        public function getByTag($handle,Request $request)
        {   

          $array= [];

          $todoArray= [];
           // $handle = $request->input('handle');  

                  $tagsID   =  DB::table('tags') 
                                ->where('handle', '=', $handle)  
                                ->pluck('id')  
                                ->first(); 

                 $about = DB::table('todos')       
                            ->get(); 

              for ($i=0; $i <count($about) ; $i++) { 
                    
                   $jsonT =  json_decode($about[$i]->tags);
                     
                   for ($j=0; $j <count($jsonT) ; $j++) { 
                                
                            if ($jsonT[$j] == $tagsID) {
                                
                              array_push($todoArray, $about[$i]);
                            }

                         }      

              }
                 return $todoArray;
                 

                   return  json_decode($about); 

   
     }

     public function getByFilter(Request $request)
    {  
      $important = $request->Input('important');
      $starred = $request->Input('starred');
      $completed = $request->Input('completed');
      $today = $request->Input('today');
      $dueDate = $request->Input('dueDate');
 
      if ($request->has('important')) {
       
          $temp  =   DB::table('todos')
                        ->where('important','=',1)
                        ->get()   
                         ->toArray(); 
                      return $temp;
      }
  
      if ($request->has('starred')) {
       
            $temp  =   DB::table('todos')
                          ->where('starred','=',1)
                          ->get()   
                          ->toArray(); 
                          
                           return $temp;
      } 

   if ($request->has('completed')) {
       
         $temp  =  DB::table('todos')
                      ->where('completed','=',1)
                      ->get()   
                      ->toArray();  
                  return $temp;
      } 
      if ($request->has('today')) {
       
      $temp  =   DB::table('todos')
                      ->whereDate('startDate', Carbon::today())
                      ->get()   
                      ->toArray(); 

                       return $temp;
      }
 
      if ($request->has('dueDate')) {
         
        $temp  =   DB::table('todos')
                    ->whereDate('dueDate', Carbon::today())
                    ->get()
                    ->toArray();

                     return $temp;
       } 
 
     }   
  
}