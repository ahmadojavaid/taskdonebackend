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
 
class boardsController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

  //..............Boards funtionality

   public function show()
  {      
    // $Messages=Boards::all();
    // return $Messages;


      $mainArray = [];

      $createdBy  = Input::get('createdBy');

      $boards  =  DB::table('boards')
                 ->where('createdBy','=',$createdBy)  
                 ->pluck('boardData');

          if (count($boards) == 0) {
       
              $boards  =  DB::table('boards') 
                     ->pluck('boardData');
 
                    $boards =  json_decode($boards);
 
                 
           for ($i=0; $i <count($boards) ; $i++) {

              $zeroth  =json_decode($boards[$i]);

          // return json_encode($zeroth->cards);
                     for ($j=0; $j <count($zeroth->cards) ; $j++) {  

                         
                           for ($k=0; $k <count($zeroth->cards[$j]->idMembers) ; $k++) {


                                if ($zeroth->cards[$j]->idMembers[$k] == $createdBy) {
                                       
                                      array_push($mainArray, $boards[$i]);
                            }
    
                            }   
                    } 
          
            } 

            return $mainArray;

       }

          

        return $boards;


   return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Boards','Result'=>$boards]);
    

  }  

   public function showOwnerandTeam()
  {      
    // $Messages=Boards::all();
    // return $Messages;


      $mainArray = [];

      $boardId  = Input::get('boardId');

      $boards  =  DB::table('boards')
                 ->where('boards.id','=',$boardId)
                 ->join('users','users.id','=','boards.createdBy')
                 // ->pluck('boardData');
                 ->get()
                 ->first();


     $forUs  =  DB::table('boards')
                 ->where('boards.id','=',$boardId)
                  ->join('users','users.id','=','boards.createdBy')
                  ->pluck('boardData');


           for ($i=0; $i <count($forUs) ; $i++) {

              $zeroth  =json_decode($forUs[$i]);

          // return json_encode($zeroth->cards);
                     for ($j=0; $j <count($zeroth->cards) ; $j++) {  

                           for ($k=0; $k <count($zeroth->cards[$j]->idMembers) ; $k++) {


                               $users  =  DB::table('users')
                                         ->where('id','=',$zeroth->cards[$j]->idMembers[$k]) 
                                          ->first(); 
                                 array_push($mainArray, $users);

                            //     if ($zeroth->cards[$j]->idMembers[$k] == $boardId) {
                                       
                            //           array_push($mainArray, $boards[$i]);
                            // }
    
                            }   
                    } 
          
            } 

        // return $mainArray;



   return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Boards','members'=>$mainArray,'owner'=>$boards]);
    

  }  


 
   public function showBoard($id)
  { 

   //..............New Implementation 

    // $Messages=Boards::find($id);
 
    $temp  =   DB::table('boards') 
                   ->where('id','=',$id)
                     ->pluck('boardData')
                     ->toArray();    
        
                     $return =  str_replace('\\', '', $temp);

                     return $return;

          // return str_replace('\/','/',json_encode($temp));

          // $string=implode(" ",explode("\\\\ ",$temp));
          // $return=stripslashes(trim($string)); 

          // $slash =  json_encode($return, JSON_UNESCAPED_SLASHES);
      return response()->json(['statusCode'=>'1','statusMessage'=>'Boards Created','Result'=>$slash]);
  
         $model = new Boards();
   
        $ipc  = $model->getipc($id); 

        return $ipc;
   
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Boards','Result'=>$Messages]);
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
  // return $request->createdBy;

    $json_str = file_get_contents('php://input');
    $json_obj = json_decode($json_str);
  
    // return json_encode($json_obj);
 
    $boards=   DB::table('boards') 
             ->where('id','=',$id)
             ->pluck('id')
             ->first();
             // return json_encode($json_obj);
       if ($boards) {

          DB::table('boards') 
             ->where('id','=',$id)
             ->delete();

     $temp = array("id" => $boards,'createdBy' => $request->createdBy,'boardData' => json_encode($json_obj));
   
     $boards =  DB::table('boards')->insertGetId($temp);
 
     $boards=   DB::table('boards') 
             ->where('id','=',$id)
             ->get()
             ->toArray();
 
        $return =  str_replace('\\', '', $boards);
    
               return $return;      
             }      
           else{   
            
           $temp = array("id" => $id,'createdBy' => $request->createdBy,'boardData' => json_encode($json_obj));
           $boards =  DB::table('boards')->insertGetId($temp);

            $boards=   DB::table('boards') 
                   ->where('id','=',$id)
                   ->get()
                   ->toArray(); 
              $return =  str_replace('\\', '', $boards);
             return $return;   
} 
 $pages =  Boards::updateOrCreate(
          ['id' => $id],['boardData' => json_encode($request),'name' => $request->Input('name')]
      );

     $temp = array("boardData" => json_encode($request));
     
     $boards =  DB::table('boards')->insertGetId($temp);
     


    // return  $request['cards'][0]['id'];
    // return $readdir()quest;
    // return $request['cards'];
    // return $request['settings']['color'];
    // return $request['lists'][0]['idCards'][0];

    // $temp = DB::table('table')->insert(Input::all($request['members']));
    // Model::save (); 
      
      $name  = $request->Input('name');
      $Boards  =$request->Input('uri'); 
      $Boards  =$request->Input('uri'); 

     $pages =  Boards::updateOrCreate(
          ['id' => $id],['uri' => $request->Input('uri'),'name' => $name]
      );

      // $Boards = new Boards();

      // $Boards->id = $id;
      // $Boards->name = $request->Input('name');
      // $Boards->uri =$request->Input('uri');
      // $Boards->createdBy = $request->Input('createdBy');
      // $Boards->save(); 

       

     //....Deleteing Old Record of lists

        DB::table('lists') 
               ->where('boardId','=',$id)
               ->delete();

       //.........Adding Lists
    if (count($request['lists'])>0) {

            for ($i=0; $i <count($request['lists']) ; $i++) {
                    
                  $temp = $request['lists'][$i];

                  $temp = array("boardId" => $id, "name" => $request['lists'][$i]['name']);

                 $lists =  DB::table('lists')->insertGetId($temp);
                 
                          // echo $i;
                                 // return $lists;
                                   // .......Adding list_cards 

                 // if (isset($request['lists'][$i]['idCards']) {
                
                 if (count($request['lists'][$i]['idCards'])>0) {
                  
                           for ($j=0; $j <count($request['lists'][$i]['idCards']) ; $j++) {
                             
                                  $ListCards = new ListCards(); 

                                    // $ListCards->id = $id;
                                    $ListCards->listId = $lists;
                                    $ListCards->boardId = $id;
                                    $ListCards->cardId = $request['cards'][$i]['id'][$j];
                                    $ListCards->save();   
                                // return $request['lists'][$i]['idCards'];
                                // $temp = $request['settings'][$i];

                                // $temp = array("boardId" =>$id, "listId" =>$lists,  "cardId" =>$request['lists'][$i]['idCards']);

                                    // DB::table('list_cards')->insertGetId(json_encode($temp));
                             }  
                   }

                            // }
                 } 
         } 
                     //...deleting previous cards 

                      DB::table('cards') 
                               ->where('boardId','=',$id)
                               ->delete();   




                     //...deleting previous idMembers from listMemebers 

                      DB::table('list_members') 
                               ->where('boardId','=',$id)
                         ->delete();

                         //.........Adding cards
                  
                  if (count($request['lists'])>0) {      
                       
                        for ($i=0; $i <count($request['cards']) ; $i++) {
                                
                              $temp = $request['cards'][$i]; 

                              $temp = array( 
                               "boardId" => $id,
                               "listId" => $lists,
                               "name" => $request['cards'][$i]['name'],
                               "description" => $request['cards'][$i]['description'],
                               "idAttachmentCover" => $request['cards'][$i]['idAttachmentCover'],
                               "due" => $request['cards'][$i]['due']
                             );  

                             $cards =  DB::table('cards')->insertGetId($temp);


                               //    for ($j=0; $j <count($request['cards'][$i]['idMembers']) ; $j++) {
                                 
                               //        $ListMembers = new ListMembers(); 

                               //          // $ListCards->id = $id;
                               //          $ListMembers->listId = $lists;
                               //          $ListMembers->boardId = $id;
                               //          $ListMembers->idMembers = $request['cards'][$i]['idMembers'][$j]; 
                               //          // $ListMembers->cardId = $request['cards'][$i]['id'];
                               //          $ListMembers->save();    

                               //     } 

                               //    for ($k=0; $k <count($request['cards'][$i]['idLabels']) ; $k++) {
                                 
                               //        $ListLabels = new ListLabels(); 

                               //          // $ListCards->id = $id;
                               //          $ListLabels->listId = $lists;
                               //          $ListLabels->boardId = $id;
                               //          $ListLabels->idLabels = $request['cards'][$i]['idLabels'][$k];
                               //          $ListLabels->save();    

                               // }  
                         } 

                  }       //...deleting previous labels 

                          DB::table('labels') 
                                   ->where('boardId','=',$id)
                                   ->delete();

                           //.........Adding labels
                          
                                      
                    if (count($request['lists'])>0) { 

                          for ($i=0; $i <count($request['labels']) ; $i++) {
                                $temp = $request['labels'][$i];
                      // 'boardId','cardId','color','name',
                                $temp = array( 
                                 "boardId" => $id,
                                 "listId" => $lists,
                                 "name" => $request['labels'][$i]['name'],
                                 "color" => $request['labels'][$i]['color']
                               ); 
                                   // return $lists;

                               $labels =  DB::table('labels')->insertGetId($temp);
                                
                           }
                     }  

        //....Deleteing Old Record of settings

          DB::table('settings') 
                 ->where('boardId','=',$id)
                 ->delete();
       
        //.......Adding Settings 
        
       for ($i=0; $i <count($request['settings']) ; $i++) {
            
          // $temp = $request['settings'][$i];

           $temp = array("boardId" => $id, "color" => $request['settings']['color'],  "subscribed" => $request['settings']['subscribed'],  "cardCoverImages" => $request['settings']['cardCoverImages']);

          DB::table('settings')->insertGetId($temp);
 
     }   
 
       //....Deleteing Old Record of members

        // DB::table('members') 
        //        ->where('boardId','=',$id)
        //        ->delete();
     
    //  .......Adding members  

    for ($i=0; $i <count($request['members']) ; $i++) {
      // return $request['settings'][$i];
        
        $temp = $request['members'][$i];

          $temp = array("boardId" => $id,"name" => $request['members'][$i]['name'], "avatar" => $request['members'][$i]['avatar']);

          DB::table('members')->insertGetId($temp);
     }    

     return response()->json(['statusCode'=>'1','statusMessage'=>'Boards Created','Result'=>$request]);
  } 
  
   public function update($id,Request $request)
    {     
     $Category=Boards::find($id);

       if(!$Category)
      {
       return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
      }
         $Category->update($request->all());

      return response()->json(['statusCode'=>'1','statusMessage'=>'Boards Data is Updated','Result'=>$Category]);
    }  
  public function destroy($id,Request $request)
  { 
   $Category=Boards::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
    
    $Category->delete();
 
    return response()->json(['statusCode'=>'1','statusMessage'=>'Boards deleted','Result'=>NULL]);
  }

  public function showmembers(Request $request)
  { 
     $temp =  DB::table('users') 
                 ->select('id','fullName as name','avatar') 
                 ->get();    
 
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing members','Result'=>$temp]);
  } 

  public function showmembersforContacList(Request $request)
  { 
     $temp =  DB::table('users') 
                 ->select() 
                 ->get();     

    return response()->json(['statusCode'=>'1','statusMessage'=>'showing members','Result'=>$temp]);
  } 
  
   //..............Lists funtionality

   public function showList()
  {      
    $boardId =  Input::get('boardId');

    $Messages=Lists::where('boardId' ,'=', $boardId)->get();
  
   return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Lists','Result'=>$Messages]);
  }  
  public function storeList(Request $request)
  {   
      $Activities = Lists::create($request->all());
 
    return response()->json(['statusCode'=>'1','statusMessage'=>'Lists Created','Result'=>$Activities]);
  } 
   public function updateList($id,Request $request)
    {     
     $Category=Lists::find($id);

       if(!$Category)
      {
       return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
      }
         $Category->update($request->all());

      return response()->json(['statusCode'=>'1','statusMessage'=>'Lists Data is Updated','Result'=>$Category]);
    }  
  public function destroyList($id,Request $request)
  { 
   $Category=Lists::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
    
    $Category->delete();
 
    return response()->json(['statusCode'=>'1','statusMessage'=>'Lists deleted','Result'=>NULL]);
  }
  
}