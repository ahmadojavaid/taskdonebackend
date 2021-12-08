<?php
namespace App\Http\Controllers;

use App\User;
use App\MailConfigures;
use App\InboxMails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail; 
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use DB;
use Illuminate\Support\Testing\Fakes\MailFake;
use Illuminate\Support\Facades\Crypt;

class composeMailController extends Controller
{  
	public function show( Request $request)
	{
		
		$from = $request->input('from');	
		$to = $request->input('to');	
		$bcc = $request->input('bcc');	
		$cc = $request->input('cc');	
		$message1 = $request->input('message');	
		$subject = $request->input('subject');	
		$selEmail = $request->input('selEmail');
		
		if($selEmail)
		{
			//$userInbox = MailConfigures::where('mailRef','=',$selEmail)->first();
			
			$userInbox = MailConfigures::select('mail_configures.*','users.fullName')
			->leftJoin('users', 'users.id', '=', 'mail_configures.users_id')
			->where('mail_configures.mailRef','=',$selEmail)->first();				
			 
			
			if($userInbox)
			{				
				$email = $userInbox->email;
				/* $password = Crypt::decryptString($userInbox->password); */
				$password = 'Informatics';
				$port = $userInbox->server_port;
				$type = $userInbox->type;
				$fullName = $userInbox->fullName;
						
				switch($type)
				{
					case 'gmail':
						$host = 'smtp.gmail.com';
					break;
					case 'yahoo':
						$host = 'smtp.mail.yahoo.com';
					break;
					case 'outlook':
						$host = 'smtp-mail.outlook.com';
					break;
					case 'custom':
						$host = 'smtp.gmail.com';
					break;
					default:					
					break;				}	
				 
				/* $config = [
					'mail.driver' 	=> 	'smtp',
					'mail.host' 	=> 	$host,
					'mail.username' => 	$email,
					'mail.password' => 	$password,
					'mail.port'		=> 	$port
				];
				
				config($config); */
				
				/* $config = [
					'mail.driver' => 'smtp',
					'mail.host' 	=> 'smtp.gmail.com',
					'mail.username' => 'patrickphp1@gmail.com',
					'mail.password' => 'Informatics',
					'mail.port'		=> '587'
				];
				
				config($config); */
		
				//$to = 'patrickphp2@gmail.com';
				//print_r($to); 
				
				/* Mail::raw('hello world', function($message) {
				   $message->subject('message subject')->to($to);
				}); */
				Mail::raw($message1, function($message) {
						$message->subject($subject)->to($to);
					});
					
				

				/* Mail::send('emails.compose', [], function ($message) 
				{
					$message->from('patrickphp2@gmail.com', 'Laravel');
					$message->to('patrickphp2@gmail.com');
				}); */
				
				/* echo $email; */
				// check for failures
				if (Mail::failures()) {
					return response()->json(['statusCode'=>'0','message'=>'Please try again.']);	
				}
				
				return response()->json(['statusCode'=>'1','message'=>'Mail has been sent successfully.']);		
			}		
		}
		else
		{
			return response()->json(['statusCode'=>'0','message'=>'Please try again.']);	
		}
	}
	
	public function testing()
	{
		/* echo "dsfsdf";
		die; */
		
		$config = [
					'mail.driver' => 'smtp',
					'mail.host' 	=> 'smtp.gmail.com',
					'mail.username' => 'patrickphp1@gmail.com',
					'mail.password' => 'Informatics',
					'mail.port'		=> '587'
				];
				
		config($config);
		
		/* Mail::queue('emails.invite123', [], function($message)
		{
			$message->to('patrickphp2@gmail.com', 'John Smith')->subject('Welcome!');
		}); */

		 Mail::raw('hello world', function($message) {
		   $message->subject('message subject')->to('patrickphp2@gmail.com');
		});

	}
}