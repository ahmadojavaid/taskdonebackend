<?php

namespace App\Http\Controllers;
use App\User;
use App\BookLeisureCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\resources\emails\mailExample;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Testing\Fakes\MailFake;
use App\config\services;
use GuzzleHttp\Client;
use Log;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Client as GuzzleHttpClient;
use DB;

class tabularColController extends Controller
{

	public function col_relation_store(Request $request,$uid) {

		//return response()->json($request->all());

		$uId = self::getUserId($uid)->id;

		$args = array('user_Id' => $uId,
		              'board_Id' => $request->boardId,
					  'group_Id' => $request->groupId,
					  'col_location' => $request->col_loc,
					  'relatedto_location' => $request->relatedto_loc,
					  'relation' => $request->type,
					  'created_at' => date('Y-m-d H:i:s',time()),
					  'updated_at' => date('Y-m-d H:i:s',time())
					);

		//check if record already exist

		$checkIf_exist = DB::table('relationalcols')
						->Where(['user_Id' => $uId,
					             'board_Id' => $request->boardId,
								 'col_location' => $request->col_loc
								 ])
								 ->first();

		if(empty($checkIf_exist)) {

			$insertRec = DB::table('relationalcols')->insertGetId($args);

			return response()->json(array('success' => true,'insert_id' => $insertRec));
		} else {

			$updateRec = DB::table('relationalcols')
						 ->where('rcol_Id',$checkIf_exist->rcol_Id)
						 ->update($args);

		}//endif

		//return response()->json($request->all());

	} //end col_relation_store

	public function get_relationalcols($uid,Request $request) {
<<<<<<< HEAD
		 
=======

		//return response()->json($request->boardId);

>>>>>>> 0848162366d5ed5133a9e53a5bb83254dad6408f
		$uId = self::getUserId($uid)->id; //user id from token

		$record = DB::table('relationalcols')->where(['user_Id' => $uId, 'board_Id' => $request->boardId])->get();
<<<<<<< HEAD

		return response()->json(['statusCode'=>'1','statusMessage'=>'showing all records','Result'=>$record]);
		
	} 
=======
		return response()->json(['statusCode'=>'1','statusMessage'=>'showing all records','Result'=>$record]);

		//return response()->json(array('success' => true,'data' => $record));


	}

>>>>>>> 0848162366d5ed5133a9e53a5bb83254dad6408f
	private function getUserId($token) {

		return $user = DB::table('users')
					->where('token',$token)
					->first();

	}

	// to store activity logs
	public function activity_log_store(Request $request) {

		$uId = self::getUserId($request->userToken)->id; // to get user id
		$tabRow = DB::table('group_tabs_details')->where('header_id', $request->input('groupid'))->get(); //get all with same group id
		$tabId = $tabRow[$request->input('rowindex')]->id; // to get row id

		$args = array('board_id' => $request->boardid,
					  			'group_id' => $request->groupid,
					  			'row_id' => $tabId,
					  			'change_field' => $request->changeField,
									'change_field_type' => $request->changeFieldType,
					  			'change_value' => json_encode($request->changeValue),
					  			'user_id' => $uId,
					  			'editTime' => date('Y-m-d H:i:s')
					  );

		if ($args['change_field_type']=='timeline') {
		  $timeline = json_decode($args['change_value']);
			if ($timeline->after->end != "" && $timeline->after->end != "") {
				return response()->json(['statusCode'=>'1','statusMessage'=>'activity log stored','Result'=>$args]);
				DB::table('activity_log')->insert($args);
			}else {
				return response()->json(['statusCode'=>'1','statusMessage'=>'activity log not stored','Result'=>array()]);
			}
		}
		else {
			DB::table('activity_log')->insert($args);
			return response()->json(['statusCode'=>'1','statusMessage'=>'activity log stored','Result'=>$args]);
		}
	}

	// to get activity logs
		public function activity_log_fetch(Request $request) {

			$tabRow = DB::table('group_tabs_details')->where('header_id', $request->input('groupid'))->get(); //get all with same group id
			$tabId = $tabRow[$request->input('rowindex')]->id; // to get row id

			$logs = DB::table('activity_log')->where('row_id', $tabId)->get();
			//echo json_encode($logs); die;

			if(empty($logs[0]))
			{
					return response()->json(['statusCode'=>'0','Result'=>array()]);
			}
			else{
							$status = DB::table('board_status')->select('status_options')->where('board_id', $logs[0]->board_id)->get(); // get all board status
			$statusOptions = json_decode($status[0]->status_options);



			foreach ($logs as $log) {
				if ($log->change_field_type=="status") {
					 $log->change_value = json_decode($log->change_value);

					 if ($log->change_value->before == "status") {
						 $log->change_value->before = "status";
						 $log->change_value->after = $statusOptions[$log->change_value->after]->name;
					 } else {
						 $log->change_value->before = $statusOptions[$log->change_value->before]->name;
						 $log->change_value->after = $statusOptions[$log->change_value->after]->name;
					 }
					 $log->user_id = DB::table('users')->select('id','fullName')->where('id', $log->user_id)->get();
				}
				elseif($log->change_field_type=="person") {
						$value =  json_decode($log->change_value,TRUE);
						$beforePerson = DB::table('users')->select('id','fullName')->where('id', $value['before'])->get();
						$afterPerson = DB::table('users')->select('id','fullName')->where('id', $value['after'])->get();
						$log->change_value = array('before' => $beforePerson,'after' => $afterPerson);
						$log->user_id = DB::table('users')->select('id','fullName')->where('id', $log->user_id)->get();
				}
				else {
						$log->change_value = json_decode($log->change_value);
						$log->user_id = DB::table('users')->select('id','fullName')->where('id', $log->user_id)->get();
				}
			}

			return response()->json(['statusCode'=>'1','statusMessage'=>'ALl Logs','Result'=>$logs]);
		}


		}

}
