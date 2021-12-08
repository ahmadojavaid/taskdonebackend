<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use App\Groupdetails;
use App\Users;
use App\Products;
use App\ProductAttachements;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\resources\emails\mailExample;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Testing\Fakes\MailFake;
use DB;
use DateTime;
class groupsController extends Controller
<<<<<<< HEAD
{ 
     public function groups( $uid,Request $request)
=======
{

     public function groups( $uid, Request $request)
>>>>>>> 0848162366d5ed5133a9e53a5bb83254dad6408f
      {
        // return response()->json(['statusCode'=>'0','statusMessage'=>'This is Sparta','Result'=>NULL]);
		// die();
		$userid = $this->getUserId($uid);
		// print_r($userid); die;
        // return $userid;
        // if($userid==[])
        if(empty($userid))
        {
            return response()->json(['statusCode'=>'0','statusMessage'=>'Groups Record Not Found','Result'=>NULL]);
        }else{

			$board=DB::table('boardname')->select('id')->where('userid', '=', $userid[0]->id)->get(); //board id
            $Groups=Groupdetails::where('logged_userid', $userid[0]->id)->get()->toArray();
			
                if(empty($Groups))
                {
                    return response()->json(['statusCode'=>'0','statusMessage'=>'Groups Record Not Found','Result'=>NULL]);
                }else{
                   $details=array();
				   $len = count($Groups);
                   for ($i=0; $i < $len; $i++){

                    $gid = $Groups[$i]['id'];
                    $gpheader = $Groups[$i]['group_header'];
                    $Groups_tabs = DB::table('group_tabs_details')
									->where('header_id', '=', $Groups[$i]['id'])
									->get()
									->toArray();

						$cnt = count($Groups_tabs); 
						$boards = array();	
                        if(!empty($cnt)){
							foreach($Groups_tabs as $tabs){
								$boards[] = json_decode($tabs->tab_data);
							  }
             } 
				   		$details[$i]=array('boardid'=>$board[0]->id,'groupid'=> $Groups[$i]['id'],'heading'=>json_decode($Groups[$i]['group_header']),'boards'=>$boards);
          }
					
                    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all groups','Result'=>$details]);
                }
        } 
      } 

    //board name
    public function boardName($tid,Request $request){
         $userid =  $this->getUserId($tid);
        if($userid==[]){
          return response()->json(['statusCode'=>'0','statusMessage'=>'error while getting board Name','Result'=>null]);
        }else {
          $board=DB::table('boardname')
                  ->select('project_name')
                  ->where('userid', '=', $userid[0]->id)
                  ->get()->toArray();
            //return $board;
            if(empty($board)){
              return response()->json(['statusCode'=>'0','statusMessage'=>'error while getting board Name','Result'=>null]);
            }else {
              return response()->json(['statusCode'=>'1','statusMessage'=>'showing Board Name','Result'=>$board]);
            }
        }
    }
    
    //update board name 
    public function newBoardName(Request $request){
        $tid = $request->input('tid');
        $proName= $request->input('boardName');
        $userid = $this->getUserId($tid);
        //return $userid[0]->id;
        if($userid==[]){
          return response()->json(['statusCode'=>'0','statusMessage'=>'no boards for this user','Result'=>null]);
        }else {
            $board=DB::table('boardname')
                  ->select('id')
                  ->where('userid', '=', $userid[0]->id)
                  ->get()->toArray();
            if(empty($board)){
              //return response()->json(['statusCode'=>'0','statusMessage'=>'error while getting board ID','Result'=>null]);
              //insert board if not exist
                $data=array('userid'=>$userid[0]->id,"project_name"=>$proName);
                $boardData=DB::table('boardname')->insert($data);
                $id = DB::getPdo()->lastInsertId();
                    if(empty($boardData)){
                          return response()->json(['statusCode'=>'0','statusMessage'=>'Error while inserting board name','Result'=>NULL]);
                    }else{
                        return response()->json(['statusCode'=>'1','statusMessage'=>'inserting Board Name','Result'=>$id]);
                    }
            }else {
                //update existing
                $GroupsBoardName=DB::table('boardname')->where('id', $board[0]->id)->update(array('project_name' => $proName));
                if(empty($GroupsBoardName)){
                      return response()->json(['statusCode'=>'0','statusMessage'=>'Error while updating board name','Result'=>NULL]);
                }else{
                    //$GroupsBoardID=DB::table('groupdetails')->where('board_id', $board[0]->id,'logged_userid'=>$userid[0]->id)->update(array('board_id' => $board[0]->id));
                    return response()->json(['statusCode'=>'1','statusMessage'=>'updating Board Name','Result'=>'Board Name Updated!']);
                }
            }
        }
    }

    // insert dummy groups
    public function InsertingGroupData(Request $request)
    {
      $data = $request->input('data');
      $userid = DB::table('users')
                  ->select('id')
                  ->where('token', '=', $request->input('loggedUser'))
                  ->get();
       if(empty($userid)){
          return response()->json(['statusCode'=>'0','statusMessage'=>'error while inserting data','Result'=>null]);
        }else {  
              $loggedUSerID = $userid[0]->id;
              $board=DB::table('boardname')->select('id')->where('userid', '=', $userid[0]->id)->get(); //board id
              $Groups=Groupdetails::where('logged_userid', $loggedUSerID)->get()->toArray();
              if(count($Groups) == 0){
                foreach ($data as $heading) {
                   $gp = new Groupdetails();
                   $gp->group_header = json_encode($heading['heading']);
                   $gp->logged_userid = $loggedUSerID;
                   $gp->board_id = $board[0]->id;
                   $gp->save();
                    foreach ($heading['boards'] as $tabData) {
                      // code...
                      $data=array('header_id'=>$gp->id,"tab_data"=>json_encode($tabData));
                      DB::table('group_tabs_details')->insert($data);
                    }
                }
                return response()->json(['statusCode'=>'1','statusMessage'=>'showing all groups','Result'=>'Data Inserted!!!']);
              }else {
                  return response()->json(['statusCode'=>'0','statusMessage'=>'Records are already in DB','Result'=>NULL]);
              }
        }
    }

    // updating groups data
    function UpdatingGroupData(Request $request){
          $data = $request->input('data');
        if($request->input('tag') == 'header'){
          //get board id
          
          $heading = json_encode($data['heading']);
          $GroupsHead=DB::table('groupdetails')->where('id', $request->input('groupid'))->update(array('group_header' => $heading,'board_id'=>$data['boardid']));
          if(empty($GroupsHead)){
              return response()->json(['statusCode'=>'0','statusMessage'=>'Error while updating groups '.$request->input('tag'),'Result'=>NULL]);
          }else{
            return response()->json(['statusCode'=>'1','statusMessage'=>'updating groups '.$request->input('tag'),'Result'=>'Data Updated!']);
          }
        }
        elseif ($request->input('tag') == 'row') {
          $gid = $request->input('groupid');
          //return $data;
          $board = json_encode($data[$request->input('groupPos')]);
          $Groups_tabsdata=DB::table('group_tabs_details')
               ->where('header_id', '=', $gid)
               ->get()->toArray();
          $tabId = $Groups_tabsdata[$request->input('groupPos')]->id;
          $GroupsBoard=DB::table('group_tabs_details')->where('id', $tabId)->update(array('tab_data' => $board));
          if(empty($GroupsBoard)){
              return response()->json(['statusCode'=>'0','statusMessage'=>'Error while updating Board'.$request->input('tag'),'Result'=>$tabId]);
          }else{
            return response()->json(['statusCode'=>'1','statusMessage'=>'updating groups '.$request->input('tag'),'Result'=>$tabId]);
          }
        }
        elseif($request->input('tag') == 'deleteheader'){
            $heading = json_encode($data['heading']);
            $GroupsHead=DB::table('groupdetails')->where('id', $request->input('groupid'))->update(array('group_header' => $heading,'board_id'=>$data['boardid']));
            if(empty($GroupsHead)){
                  return response()->json(['statusCode'=>'0','statusMessage'=>'Error while deleting group column'.$request->input('tag'),'Result'=>NULL]);
              }else{
                return response()->json(['statusCode'=>'1','statusMessage'=>'delete column of header','Result'=>'Data deleted!']);
              }
        }
        elseif($request->input('tag') == 'deleterowCol'){
            for($i=0;$i < count($data); $i++){
                $gid = $request->input('groupid');
                $board = json_encode($data[$i]);
                $Groups_tabsdata=DB::table('group_tabs_details')
                   ->where('header_id', '=', $gid)
                   ->get()->toArray();
                $tabId = $Groups_tabsdata[$i]->id;
                $GroupsBoard=DB::table('group_tabs_details')->where('id', $tabId)->update(array('tab_data' => $board));
            }
        }
        elseif($request->input('tag') =='deleteRow'){
            $tabRow=DB::table('group_tabs_details')->where('header_id', $request->input('groupid'))->get(); //get all with same group id
            $tabId=$tabRow[$request->input('groupColPos')]->id;
            //return json_encode($tabId);
             $DeletetabRow=DB::table('group_tabs_details')->where('id', $tabId)->delete(); //delete the particular data
             if(empty($DeletetabRow))
                {
                 return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
                }
            return response()->json(['statusCode'=>'1','statusMessage'=>'Group Row deleted','Result'=>NULL]);
        }
    }

    //add new column or row Data
    public function RowColData(Request $request){
      if($request->input('tag') == 'col'){
        $data = $request->input('data');
        $heading = json_encode($data['heading']);
        $GroupsBoard=DB::table('groupdetails')->where('id', $data['groupid'])->update(array('group_header' => $heading));

        //update $tabs
        $tabs=DB::table('group_tabs_details')
             ->where('header_id', '=', $data['groupid'])
             ->get()->toArray();
             if(count($tabs) > 0 ){
               $boards=array();
                 $n=0;
                 foreach($tabs as $row){
                    // echo $tabs->tab_data.'.---------'.'<br>';
                    $tabId = $row->id;
                    $tabdata = json_encode($data['boards'][$n]);
                    $GroupsBoard=DB::table('group_tabs_details')->where('id', $tabId)->update(array('tab_data' => $tabdata));
                    $n++;
                 }
             }
            if(empty($GroupsBoard)){
              return response()->json(['statusCode'=>'0','statusMessage'=>'Error during updating '.$request->input('tag'),'Result'=>NULL]);
            }else{
              return response()->json(['statusCode'=>'1','statusMessage'=>'updating groups '.$request->input('tag'),'Result'=>'Data Updated!']);
            }

        }elseif ($request->input('tag') == 'row') {
            $row = $request->input('data');
            $head= $row['header'];
              for($i=0; $i< count($head); $i++){
                if($head[$i]['type'] == 'link'){
                    $tab[]=array('url'=>'','name'=>'link');
                }else if($head[$i]['type'] == 'auto-number'){
					$tab[]=$row['rowno']+1;
                }else if($head[$i]['type'] == 'timeline'){
					$tab[]=array('start'=>'','end'=>'');
                }else{
                  $tab[]=$head[$i]['type'];
                }
              }
            $tabdata = array('tab'=> $tab);
            $data=array('header_id'=>$row['gid'],"tab_data"=>json_encode($tabdata));
            $tabsData=DB::table('group_tabs_details')->insert($data);
            $res = array('i'=>$row['arrpos'],'row'=>$tabdata);
            if(empty($tabsData)){
              return response()->json(['statusCode'=>'0','statusMessage'=>$request->input('tag').' error occured','Result'=>NULL]);
            }else {
              return response()->json(['statusCode'=>'1','statusMessage'=>$request->input('tag').' Data Updated!','Result'=>$res]);
            }
        }//end of else if
    }

    //get date list :
    public function dateList($id,Request $request){
         //return response()->json(['statusCode'=>'1','statusMessage'=>$request->input('tag').' Data Updated!','Result'=>$request->all()]);
         $userid = $this->getUserId($id);
         if($userid==[])
            {
                return response()->json(['statusCode'=>'0','statusMessage'=>'Groups Record Not Found','Result'=>NULL]);
            }else{
                $Groups=Groupdetails::where('logged_userid', $userid[0]->id)->get()->toArray();

                    if(empty($Groups))
                    {
                        return response()->json(['statusCode'=>'0','statusMessage'=>'Groups Record Not Found','Result'=>NULL]);
                    }else{
                        for($g=0; $g<count($Groups);$g++){
                            $tabdata = array();
                            $data = json_decode($Groups[$g]['group_header'], true);
                            //return $data;
                            for($i=0; $i<count($data);$i++){
                                if($data[$i]['type'] == "date"){
                                    $tab_n[$g]['group_col'][]=$i;
                                }
                            }
                                    $grp_tabs=DB::table('group_tabs_details')->where('header_id', $Groups[$g]['id'])->get()->toArray();
                                    $n=0;
                                    foreach($grp_tabs as $tab){
                                        $tabdata[]=json_decode($tab->tab_data,true);
                                        $date = array();
                                         for($k=0;$k<count($tabdata);$k++){
                                             $date[$k]['tab']=$tabdata[$k]['tab'];
                                             $tab_n[$g]['date'][$k]=$tabdata[$k]['tab'];
                                        }
                                       $n++;
                                    }                  
                            
                        }
                        //return $dateVal;
                        $dateVal=array();
                                for($j=0;$j<count($tab_n);$j++) { 
                                    //$dateVal[]=$tab_n[$j]['group_col'];
                                    foreach($tab_n[$j]['date'] as $d){
                                         foreach($tab_n[$j]['group_col'] as $c){
                                             $dateVal[] = $d[$c];
                                         }
                                    }
                                }
                        //return $dateVal;
                    }
             }
         
    }

    //status list 
    public function statusOptionList(Request $request){
        $uid = $this->getUserId($request->input('token'));
        if(!empty($uid)){
           $board=DB::table('boardname')->select('id')->where('userid', '=', $uid[0]->id)->get()->toArray(); //board id    
           if(!empty($board)){
                if($request->input('tag')=='get'){
                    $statuslist=DB::table('board_status')->select('status_options')->where('board_id', $board[0]->id)->where('userid',$uid[0]->id)->get()->toArray(); //list

                    if(empty($statuslist)){
                      return response()->json(['statusCode'=>'0','statusMessage'=>'status list:error','Result'=>NULL]);
                    }else {
                      $list = json_decode($statuslist[0]->status_options);
                      return response()->json(['statusCode'=>'1','statusMessage'=>'fetched status list','Result'=>$list]);
                    }
                }
                elseif($request->input('tag')=='update'){
                     $statuslistup=DB::table('board_status')->where('board_id', $board[0]->id)->where('userid',$uid[0]->id)->update(array('status_options' => json_encode($request->input('list'))));

                    if(empty($statuslistup)){
                      return response()->json(['statusCode'=>'0','statusMessage'=>'status list:error','Result'=>NULL]);
                    }else {
                      return response()->json(['statusCode'=>'1','statusMessage'=>'updated status successfully','Result'=>$request->input('list')]);
                    }
                }
                if($request->input('tag')=='insert'){
                 //return $request->all();
                    $data=array('userid'=>$uid[0]->id,"board_id"=> $request->input('bid'),"status_options"=>json_encode($request->input('option')));
                    $boardData=DB::table('board_status')->insert($data);
                    $id = DB::getPdo()->lastInsertId();
                        if(empty($boardData)){
                              return response()->json(['statusCode'=>'0','statusMessage'=>'Error while inserting status options','Result'=>NULL]);
                        }else{
                            return response()->json(['statusCode'=>'1','statusMessage'=>'inserting Board status options','Result'=>$id]);
                        }
                }
            }else{
                return response()->json(['statusCode'=>'0','statusMessage'=>'board not found','Result'=>NULL]);
            }
        }



    }
	
	//relation for col
	public function getRelationsList($col,Request $request){
		 $relList=DB::table('relationalcols')->where('col_location', $col)->orWhere('relatedto_location',$col)->get()->toArray();
		  if(!empty($relList)){
				return response()->json(['statusCode'=>'1','statusMessage'=>'Related col list','Result'=>$relList]);
		  }else{
			  return response()->json(['statusCode'=>'0','statusMessage'=>'No Related col','Result'=>NULL]);
		  }
	}
	
	public function deleteRelation(Request $request){
		if($request->input('tag')=='norel'){
			$reldb=DB::table('relationalcols')->where('col_location',$request->input('col'))->delete();
			if(empty($reldb)){
				return response()->json(['statusCode'=>'0','statusMessage'=>'No Related col','Result'=>NULL]);
			}else{
				return response()->json(['statusCode'=>'1','statusMessage'=>'Related col deleted','Result'=>$reldb]);
			}
		}
		elseif($request->input('tag')=='rel'){
			$reldb=DB::table('relationalcols')->where('relatedto_location',$request->input('col'))->delete();
			if(empty($reldb)){
				return response()->json(['statusCode'=>'0','statusMessage'=>'No Related col','Result'=>NULL]);
			}else{
				return response()->json(['statusCode'=>'1','statusMessage'=>'ALl Related col list deleted','Result'=>$reldb]);
			}
		}
		
<<<<<<< HEAD
	} 
=======
	}
	
	
	//invite 
	public function sendInvite(Request $request){
		
		$data = $request->all();
		$loggeduser =  DB::table('users')->where('token', '=', $data['from'])->get()->toArray();
		$toUser = DB::table('users')->where('token', '=', $data['to'])->get()->toArray();
		
		$gid = $request->input('groupid');
        $Groups_tabsdata=DB::table('group_tabs_details')
               ->where('header_id', '=', $gid)
               ->get()->toArray();
        $tabId = $Groups_tabsdata[$request->input('tabid')]->id;
		$invdata=array('tab_id'=>$tabId,'email'=>$loggeduser[0]->email);
		Mail::send('emails.invite',["data" => $invdata], function($message) use ($data,$loggeduser) {
			//$message->from($loggeduser[0]->email, $loggeduser[0]->fullName);
			$message->to($data['email'], 'Mail Invite')->from( $loggeduser[0]->email, $loggeduser[0]->fullName )->subject('Invitation Mail');
					});
		// check for failures
			if (Mail::failures()) {
				// return response showing failed emails
				return response()->json(['statusCode'=>'0','statusMessage'=>'no mail sent','Result'=>NULL]);
			}else{
				$invList=DB::table('invitation')->where('sent_by', $loggeduser[0]->id)->where('tab_id',$tabId)->get()->toArray();
				  if(!empty($invList)){
						//update
						$InvData=DB::table('invitation')->where('id', $invList[0]->id)->update(array('sent_by'=>$loggeduser[0]->id,'recevied_by'=> $toUser[0]->id,'status'=>'0','created_at' => $invList[0]->created_at,'updated_at' => date('Y-m-d H:i:s',time())));
						if($InvData){
							return response()->json(['statusCode'=>'1','statusMessage'=>'Update:Mail Send','Result'=>$InvData]);
						}else{
							return response()->json(['statusCode'=>'0','statusMessage'=>'insertion error','Result'=>NULL]);
						}
				  }else{
					  $inv=array('sent_by'=>$loggeduser[0]->id,"recevied_by"=> $toUser[0]->id,"status"=>'0','tab_id'=>$tabId,'created_at' => date('Y-m-d H:i:s',time()),'updated_at' => date('Y-m-d H:i:s',time()));
						$InvData=DB::table('invitation')->insert($inv);		
						if($InvData){
							return response()->json(['statusCode'=>'1','statusMessage'=>'Insert: Mail Send','Result'=>$InvData]);
						}else{
							return response()->json(['statusCode'=>'0','statusMessage'=>'insertion error','Result'=>NULL]);
						}						
				  }
				  
				
				
			}
		
	}
	
	
	public function acceptInvite($tabid,Request $request){
			//return $tabid;
			$InvData=DB::table('invitation')->where('tab_id', $tabid)->update(array('status'=>'1','created_at' =>  date('Y-m-d H:i:s',time()),'updated_at' => date('Y-m-d H:i:s',time())));
				if($InvData){
					return response()->json(['statusCode'=>'1','statusMessage'=>'Update:Mail Send','Result'=>$InvData]);
				}else{
					return response()->json(['statusCode'=>'0','statusMessage'=>'insertion error','Result'=>NULL]);
				}
		 return redirect();
	}
	
>>>>>>> 0848162366d5ed5133a9e53a5bb83254dad6408f
    //get login user id
    public function getUserId($token){
        $userid = DB::table('users')
                  ->select('id')
                  ->where('token', '=', $token)
                  ->get()->toArray();
        return $userid;
    }
}
