<?php

namespace App\Http\Controllers;
use App\MailConfigure;
use App\User;
use App\MailConfigures;
use App\InboxMails;
use App\InboxFolders;
use App\InboxCustoms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\CustomData\Utilclass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use DB;
use Webklex\IMAP\Exceptions as imapException;
use Webklex\IMAP\Client;
use Illuminate\Support\Facades\Crypt;


class mailConfiguresController extends Controller
{  
	/*
	** Add new inbox	
	*/
	public function show( Request $request)
	{  
		/*  Get User Token Value */
		$user_token = $request->input('userToken');
		
		$admin = User::where('token', '=', $user_token)->first();
		/*  Check login User */
		if (!$admin)
		{
			return response()->json(['statusCode'=>'0','statusMessage'=>'Something Went wrong','Result'=>'']);
		}
		else
		{		
			/* $inbox = $request->input('inbox'); */
			$email = $request->input('email');
			$type = $request->input('type');
			$password = $request->input('password');
			$port = $request->input('port');
			
			/*  Set host,port,protocol value according to "type" value */			
			switch($type)
			{
				case 'gmail':
					$host = 'imap.gmail.com';
					$port = 993;
					$protocol = 'imap';
				break;
				case 'yahoo':
					$host = 'imap.mail.yahoo.com';
					$port = 993;
					$protocol = 'imap';
				break;
				case 'outlook':
					$host = 'imap-mail.outlook.com';
					$port = 993;
					$protocol = 'imap';
				break;
				case 'custom':
					$host = 'imap.gmail.com';
					$port = 993;
					$protocol = 'imap';
				break;
				default:
				
				break;
			}			
				
			try {	
			
				$oClient = new Client([
				'host'          => $host,
				'port'          => $port,
				'encryption'    => 'ssl',
				'validate_cert' => true,
				'username'      => $email,
				'password'      => $password,
				'protocol'      => $protocol
			]);
			
			
				
				//Connect to the IMAP Server
				$connect_to_client = $oClient->connect();
				
				/** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
				$check_isConnect = $oClient->isConnected();	
				
				/*  CHeck connect established or not. */				
				if($check_isConnect)
				{		
					$mail_array = array();
					/*  Check Mail already congigured or Not. */
					$mailEmail = MailConfigures::where('email', '=', Input::get('email'))->get();
				
					if ($mailEmail->count() == 0) 
					{
						$mailref = substr(md5(time()), 0, 10);
						/*  Insert Mail Data */
						$MailConfigures = new MailConfigures();
						$MailConfigures->users_Id = $admin->id;
						$MailConfigures->mailRef = $mailref;
						$MailConfigures->type = $type;
						$MailConfigures->email = $email;
						$MailConfigures->password =  Crypt::encryptString($password);
						/* $MailConfigures->inbox_name = $inbox; */
						$MailConfigures->server_port = $port;
						$MailConfigures->save();			
						$lastInsertedId = $MailConfigures->id;							

						/*  start - Retrive mails from configured account */	
						$aFolder = $oClient->getFolders();	

						$folder_arr = array();
						$fold_i = 0;
						foreach($aFolder as $folder)
						{
							$folder_name = $folder->fullName;								
							if($folder_name != '[Gmail]')
							{
								$folder_arr[$fold_i]['mailRef'] = $mailref;
								$folder_arr[$fold_i]['title'] = $folder_name;
								$folder_arr[$fold_i]['handle'] = str_slug($folder_name);
								$fold_i++;
							}							
							if($folder->hasChildren()) 
							{
								foreach($folder->children as $childFolder) 
								{
									$exFolderName = explode("/",$childFolder->fullName);
									$folder_arr[$fold_i]['mailRef'] = $mailref;
									$folder_arr[$fold_i]['title'] = $exFolderName[1];
									$folder_arr[$fold_i]['handle'] = str_slug($exFolderName[1]);
									$fold_i++;
								}
							}								
						}				
						/* save bulk Mail folder data  */
						$userInbox = InboxFolders::insert($folder_arr);		
						/* Get Mail folder data  */
						$inb_fold_arr = InboxFolders::select('id','title')->where('mailRef','=',$mailref)->get();
						$fold_arr = $inb_fold_arr->toArray();
						
						if(count($fold_arr) >0)
						{
							$new_fold_arr = array();
							foreach($fold_arr as $val)
							{
								$new_fold_arr[$val['id']] = $val['title'];
							}
						}
					
						foreach($aFolder as $oFolder)
						{						
							//Get all Messages of the current Mailbox $oFolder
							/** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
							//$aMessage = $oFolder->messages()->all()->get();
								
							
							$i=0;
							if($oFolder->hasChildren()) 
							{	
								/** @var \Webklex\IMAP\Message $oMessage */
								foreach($oFolder->children as $oChildFolder)
								{		
									$aFolder = $oClient->getFolder($oChildFolder->fullName);
									
									$fold_name = $oChildFolder->fullName;
									$messages = $oFolder->query()->since(now()->subDays(5))->limit(2)->get();
									foreach($messages as $oMessage)
									{		
										$mail_array[$i]['uid'] 		= $oMessage->uid;
										$mail_array[$i]['inbox_id'] = $lastInsertedId;
										$mail_array[$i]['mail_id'] 	= (string)$oMessage->getMessageId();
										
										/* From  */
										$from = array();	
										
										$from_full 	= $oMessage->getFrom()[0]->full;
										$fr_arr = explode('<',$from_full);
										
										$mail_array[$i]['from_name'] 	= $from_full;
										
										$from['name'] 	= $fr_arr[0];								
										$from['avatar'] = '';
										$from['email'] 	= $oMessage->getFrom()[0]->mail;							
										
										$mail_array[$i]['from'] 	= serialize($from);
										
										/* To  */							
										$to 			= array();							
										$to['name'] 	= 'me';
										$to['email'] 	= $email;
										
										$mail_array[$i]['to'] 		= serialize($to);
										
										$mail_array[$i]['cc'] 		= serialize($oMessage->getCc());
										$mail_array[$i]['bcc'] 		= serialize($oMessage->getBcc());	
										
										/* Subject  */
										$sub = $oMessage->getSubject();
										$mail_array[$i]['subject'] 	= $sub;								
										
										/* Message  */
										$mail_array[$i]['message'] 	= $oMessage->getHTMLBody();
										//$mail_array[$i]['message'] = '';
										
										$flags = $oMessage->getFlags();									
										/* Read */
										$mail_array[$i]['read'] 		= $flags['seen'];
										
										/* Important */
										$mail_array[$i]['important'] 	= $flags['flagged'];
										
										/* Folder */
										$k = array_search($fold_name , $new_fold_arr);	
										$mail_array[$i]['folder'] 		= $k;	
										
										/* Time */
										$mail_array[$i]['mail_date'] = $oMessage->getDate()->toDayDateTimeString();	
										
										/* Starred */
										$mail_array[$i]['starred'] = '';		
										
										if ($oMessage->hasAttachments()) 
										{
											$mail_array[$i]['hasAttachments'] = true;										
											/* Find all attachments */
											$attachmentIndex = 0;
											$msgAttachments = $oMessage->getAttachments();
											foreach($msgAttachments as $msgAttachment) 
											{
												$attachmentList[$attachmentIndex]['fileName']  = $msgAttachment->getName();
												$attachmentList[$attachmentIndex]['type']  = $msgAttachment->getType();
												
												// attachments code 
												// checking directory exists
												if(is_dir("..\\public\\attachments\\".$user_token)) 
												{
													$msgAttachment->save("..\\public\\attachments\\".$user_token,$msgAttachment->getName());	
													
													$attachmentList[$attachmentIndex]['url']     = "public/attachments/".$user_token."/".$msgAttachment->getName();
													$attachmentList[$attachmentIndex]['size']    = filesize("../public/attachments/".$user_token."/".$msgAttachment->getName());
												}
												else 
												{
													mkdir("..\\public\\attachments\\".$user_token);
													$msgAttachment->save("..\\public\\attachments\\".$user_token,$msgAttachment->getName());	
													
													$attachmentList[$attachmentIndex]['url']     = "public/attachments/".$user_token."/".$msgAttachment->getName();;
													
													$attachmentList[$attachmentIndex]['size']    = filesize("../public/attachments/".$user_token."/".$msgAttachment->getName());
												}	
												
												$attachmentList[$attachmentIndex]['preview'] = 'assets/images/etc/sunrise-thumb.jpg';											
												$attachmentIndex ++;
											}												
											return json_encode($attachmentList);
											die;
											
											$mail_array[$i]['attachments'] = serialize($attachmentList);
										}
										else
										{
											$mail_array[$i]['hasAttachments'] = '';
											$mail_array[$i]['attachments'] = '';
										}						
										$i++;
									}
								}
							}
							else
							{
								$aMessage = $oFolder->query()->since(now()->subDays(5))->limit(2)->get();	
								/** @var \Webklex\IMAP\Message $oMessage */
								foreach($aMessage as $oMessage)
								{								
									
									$mail_array[$i]['uid'] 		= $oMessage->uid;
									$mail_array[$i]['inbox_id'] = $lastInsertedId;
									$mail_array[$i]['mail_id'] 	= (string)$oMessage->getMessageId();
									
									/* From  */
									$from = array();	
									
									$from_full 	= $oMessage->getFrom()[0]->full;
									$fr_arr = explode('<',$from_full);
									
									$mail_array[$i]['from_name'] 	= $from_full;
									
									$from['name'] 	= $fr_arr[0];								
									$from['avatar'] = '';
									$from['email'] 	= $oMessage->getFrom()[0]->mail;							
									
									$mail_array[$i]['from'] 	= serialize($from);
									
									/* To  */							
									$to 			= array();							
									$to['name'] 	= 'me';
									$to['email'] 	= $email;
									
									$mail_array[$i]['to'] 		= serialize($to);
									
									$mail_array[$i]['cc'] 		= serialize($oMessage->getCc());
									$mail_array[$i]['bcc'] 		= serialize($oMessage->getBcc());	
									
									/* Subject  */
									$sub = $oMessage->getSubject();
									$mail_array[$i]['subject'] 	= $sub;								
									
									/* Message  */
									$mail_array[$i]['message'] 	= $oMessage->getHTMLBody();
									//$mail_array[$i]['message'] = '';
									
									$flags = $oMessage->getFlags();									
									/* Read */
									$mail_array[$i]['read'] 		= $flags['seen'];
									
									/* Important */
									$mail_array[$i]['important'] 	= $flags['flagged'];
									
									/* Folder */
									$k = array_search($oFolder->fullName , $new_fold_arr);	
									$mail_array[$i]['folder'] 		= $k;	
									
									/* Time */
									$mail_array[$i]['mail_date'] = $oMessage->getDate()->toDayDateTimeString();	
									
									/* Starred */
									$mail_array[$i]['starred'] = '';		
									
									if ($oMessage->hasAttachments()) 
									{
										$mail_array[$i]['hasAttachments'] = true;										
										/* Find all attachments */
										$attachmentIndex = 0;
										$msgAttachments = $oMessage->getAttachments();
										foreach($msgAttachments as $msgAttachment) 
										{
											$attachmentList[$attachmentIndex]['fileName']  = $msgAttachment->getName();
											$attachmentList[$attachmentIndex]['type']  = $msgAttachment->getType();
											
											// checking directory exists
											if(is_dir("..\\public\\attachments\\".$user_token)) 
											{
												$msgAttachment->save("..\\public\\attachments\\".$user_token,$msgAttachment->getName());	
												
												$attachmentList[$attachmentIndex]['url']     = "public/attachments/".$user_token."/".$msgAttachment->getName();
												$attachmentList[$attachmentIndex]['size']    = filesize("../public/attachments/".$user_token."/".$msgAttachment->getName());
											}
											else 
											{
												mkdir("..\\public\\attachments\\".$user_token);
												$msgAttachment->save("..\\public\\attachments\\".$user_token,$msgAttachment->getName());	
													
												$attachmentList[$attachmentIndex]['url']     = "public/attachments/".$user_token."/".$msgAttachment->getName();;
													
												$attachmentList[$attachmentIndex]['size']    = filesize("../public/attachments/".$user_token."/".$msgAttachment->getName());
											}
											
											$attachmentList[$attachmentIndex]['preview'] = 'assets/images/etc/sunrise-thumb.jpg';											
											$attachmentIndex ++;
										}												
												
										$mail_array[$i]['attachments'] = serialize($attachmentList);
									}
									else
									{
										$mail_array[$i]['hasAttachments'] = '';
										$mail_array[$i]['attachments'] = '';
									}						
									$i++;
								}
								
							}	
						}
						$userInbox = InboxMails::insert($mail_array);
						/*  end - Retrive mails from configured account */	
					}
					else
					{
						/*  Mail already configured */
						return response()->json(['statusCode'=>'0','statusMessage'=>'Mail has been already configured.']);
					}		

					/*  Mail configured */
						return response()->json(['statusCode'=>'1','statusMessage'=>'New mail configuration added successfully.']);	
				}
				else
				{
					/*  Connection not establised */
					return response()->json(['statusCode'=>'0','statusMessage'=>'Try again later.']);
				}
				
			}catch (imapException\ConnectionFailedException $e) 
			{
				/*  Get error messages */
				 $error_message = $e->getMessage();
				 return response()->json(['statusCode'=>'0','statusMessage'=>$error_message]);
			}
		} 
	}

	/*
	** Get List of user all inbox	
	*/
	public function userInbox(Request $request)
	{
		$ret_arr = array();
		$select_mail ='';
		$user_token = $request->input('userToken');		
		$admin = User::where('token', '=', $user_token)->first();
		$userInbox = MailConfigures::select('mailRef','email')->where('users_Id', '=',$admin->id)->get();
		
		
		if(!$userInbox->isEmpty())
		{	
				$i=1;
				foreach ($userInbox as $key=>$val)
				{ 
					if($i==1)
					{
						$select_mail = $val['mailRef'];
					}
					
					$ret_arr[$val['mailRef']] = $val['email'];
					
					$i++;
				}
				return response()->json(['statusCode'=>'1','Result'=>$ret_arr,'selEmail'=>$select_mail]);
		}
		else
		{
			return response()->json(['statusCode'=>'0','Result'=>$ret_arr,'selEmail'=>$select_mail]);
		}
	}
	
	/*
	** Get all mail	
	*/
	public function checkimap(Request $request)
	{	
		
		$user_token 		= $request->input('userToken');	
		$selectedAccount 	= $request->input('userSelEmail');	
		
		$admin = User::where('token', '=', $user_token)->first();
		
		if($admin)
		{
			$userInbox = MailConfigures::where('users_Id', '=',$admin->id)
				->where('mailRef','=',$selectedAccount)
				->first();
			
			if($userInbox)
			{
				$inbox_id = $userInbox->id;
				$userInboxMail = InboxMails::where('inbox_id', '=',$inbox_id)->get();
				$userInboxMailCount = $userInboxMail->count();
				
				
				if($userInboxMailCount > 0)
				{	
					$mail_array = array();
					$i=0;
					//Loop through every Mailbox
					/** @var \Webklex\IMAP\Folder $oFolder */
					foreach($userInboxMail as $oMessage)
					{	
						//Get all Messages of the current Mailbox $oFolder
						/** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
					
						$mail_array[$i]['id'] = $oMessage['mail_id'];
						
						/* From  */
						$mail_array[$i]['from'] = unserialize($oMessage['from']);
						
						/* From  */
						$mail_array[$i]['to'] = array(unserialize($oMessage['to']));
						
						/* Subject  */
						$mail_array[$i]['subject'] = substr($oMessage['subject'],0,50);
						
						/* Message  */
						$mail_array[$i]['message'] = $oMessage['message'];
						//$mail_array[$i]['message'] = 'Dummy Text Email  - Static';
						
						
						/* Time */
						$mail_array[$i]['time'] = date('d M', strtotime($oMessage['mail_date']));
						//$mail_array[$i]['time'] = '28 Jun';
						
						/* Read */
						$mail_array[$i]['read'] = false;
						
						/* Starred */
						$mail_array[$i]['starred'] = false;
						
						/* Important */
						$mail_array[$i]['important'] = true;
						
						
						$mail_array[$i]['hasAttachments'] = $oMessage['hasAttachments'];
						
						$mail_array[$i]['attachments'] = unserialize($oMessage['attachments']);
						
						$mail_array[$i]['labels'] = array();
						$mail_array[$i]['folder'] = 0;
						
						$i++;
					}
					
					return response()->json(['statusCode'=>'1','result'=>$mail_array]);
				}
				else
				{
				  return response()->json(['statusCode'=>'0']);
				}
			}
		}
		
	}
	
	public function getMessageDetail( )
	{		
		
		$admin = User::where('id', '=', 2)->first();		
		
		if($admin)
		{
			$userInbox = MailConfigures::where('users_Id', '=',$admin->id)
				->where('mailRef','=','9c2a594eae')
				->first();
			
			if($userInbox)
			{
				$email = $userInbox->email;
				$password = Crypt::decryptString($userInbox->password);
				$type = $userInbox->type;
				
				switch($type)
				{
					case 'gmail':
						$host = 'imap.gmail.com';
						$port = 993;
						$protocol = 'imap';
					break;
					case 'yahoo':
						$host = 'imap.mail.yahoo.com';
						$port = 993;
						$protocol = 'imap';
					break;
					case 'outlook':
						$host = 'imap.mail.yahoo.com';
						$port = 993;
						$protocol = 'imap';
					break;
					case 'custom':
						$host = 'imap.gmail.com';
						$port = 993;
						$protocol = 'imap';
					break;
					default:
					
					break;
				}	
				
				try {	
					$oClient = new Client([
						'host'          => $host,
						'port'          => $port,
						'encryption'    => 'ssl',
						'validate_cert' => true,
						'username'      => $email,
						'password'      => $password,
						'protocol'      => $protocol
					]);
					
					//Connect to the IMAP Server
					$connect_to_client = $oClient->connect(1);
					
					$check_isConnect = $oClient->isConnected();	
					
					$mail_array = array();
					$folder_array = array();
					//Get all Mailboxes
					/** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
					$aFolder = $oClient->checkConnection();		
					
					$aFolder = $oClient->getFolders();
					
					$f=0;
					foreach($aFolder as $oFolder){
						
							//Get all Messages of the current Mailbox $oFolder
							/** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
							//$aMessage = $oFolder->messages()->all()->get();
							$aMessage = $oFolder->query()->limit(5)->get()->all();
							
							
							$i=0;
							/** @var \Webklex\IMAP\Message $oMessage */
							foreach($aMessage as $oMessage)
							{								
								
								$mail_array[$i]['uid'] 		= $oMessage->uid;
								$mail_array[$i]['inbox_id'] = 5;
								$mail_array[$i]['mail_id'] 	= $oMessage->getMessageId();
								
								/* From  */
								$from = array();							
								$from['name'] 	= $oMessage->getFrom()[0]->full;
								$from['avatar'] = 'assets/images/avatars/alice.jpg';
								$from['email'] 	= $oMessage->getFrom()[0]->mail;							
								
								$mail_array[$i]['from'] 	= serialize($from);
								
								/* To  */							
								$to 			= array();							
								$to['name'] 	= 'me';
								$to['email'] 	= $email;
								
								$mail_array[$i]['to'] 		= serialize($to);
								
								$mail_array[$i]['cc'] 		= serialize($oMessage->getCc());
								$mail_array[$i]['bcc'] 		= serialize($oMessage->getBcc());	
								
								/* Subject  */
								$mail_array[$i]['subject'] 	= $oMessage->getSubject();
								
								/* Message  */
								$mail_array[$i]['message'] 	= $oMessage->getHTMLBody();
								//$mail_array[$i]['message'] = '';
								
								$flags = $oMessage->getFlags();
								
								/* Read */
								$mail_array[$i]['read'] 		= $flags['seen'];
								/* Important */
								$mail_array[$i]['important'] 	= $flags['flagged'];
								
								/* Time */
								$mail_array[$i]['mail_date'] = $oMessage->getDate()->toDayDateTimeString();	
								
								/* Starred */
								$mail_array[$i]['starred'] = '';		
								
								if ($oMessage->hasAttachments()) 
								{
									$mail_array[$i]['hasAttachments'] = true;
									
									/* Find all attachments */
									$attachmentIndex = 0;
									$msgAttachments = $oMessage->getAttachments();
									foreach($msgAttachments as $msgAttachment) 
									{
										$attachmentList[$attachmentIndex]['fileName']  = $msgAttachment->getName();
										$attachmentList[$attachmentIndex]['type']  = $msgAttachment->getType();
										$attachmentList[$attachmentIndex]['size']  = $msgAttachment->getType();
										$attachmentList[$attachmentIndex]['preview'] = 'assets/images/etc/sunrise-thumb.jpg';
										$attachmentList[$attachmentIndex]['url']     = 'assets/images/etc/early-sunrise.jpg';
										$attachmentList[$attachmentIndex]['size']    = '17Mb';
										
										$attachmentIndex ++;
									}
											
											
									$mail_array[$i]['attachments'] = serialize($attachmentList);
								}
								else
								{
									$mail_array[$i]['hasAttachments'] = '';
									$mail_array[$i]['attachments'] = '';
								}								
																
								/* $mail_array[$i]['labels'] = '';
								$mail_array[$i]['folder'] = 0; */
								
								$i++;
							}
							
						}
						$userInbox = InboxMails::insert($mail_array);
				
				}catch (imapException\ConnectionFailedException $e) 
				{
				  $error_message = $e->getMessage();
				}
			}
		}
	}
	
	
	/*
	** Get List of all default folder	
	*/
	public function defaultFolder(Request $request)
	{
		$ret_arr = array();
		$selectedAccount = $request->input('userSelEmail');
		$userFolder = InboxFolders::select('id','handle','title','color')
		->where('mailRef', '=',$selectedAccount)
		->get();
		
		if ($userFolder)
		{	
			return response()->json($userFolder);			
		}
		else
		{
			return response()->json(['statusCode'=>'0']);
		}
	}
	
	/*
	** Get folder detail	
	*/
	public function folderDetail(Request $request)
	{
		$ret_arr = array();
		//	return response()->json(['statusCode'=>'0']);die;
		$selectedAccount = $request->input('userSelEmail');
		$folders = $request->input('folder');
		
		$customInbox = InboxFolders::select('id','handle','title','color')
		->where('mailRef', '=',$selectedAccount)
		->where('handle','=',$folders)
		->get();
		
		if ($customInbox)
		{	
			/* [{"id":1,"handle":"inbox","title":"INBOX","color":null}] */
			
			return response()->json($customInbox);			
		}
		else
		{
			return response()->json(['statusCode'=>'0']);
		}
	}
	
	/*
	** Get List of all mail folder wise	
	*/
	public function getFolderMail(Request $request)
	{
		$ret_arr = array();
			
		$selectedAccount = $request->input('userSelEmail');	
		//$selectedAccount = 'c629d76ccd';
		$folderId = $request->input('folderId');		
		
		/*$userInboxMail = DB::table('mail_folders')
		->select('inbox_mails.*')
		->leftJoin('inbox_mails', 'inbox_mails.id', '=', 'mail_folders.mail_id')
		->where('mail_folders.folder_id', '=', $folderId)
		->where('mail_folders.mailRef', '=', $selectedAccount)			
		->get();*/
		
		$userInboxMail = DB::table('inbox_folders')
		->select('inbox_mails.*')
		->leftJoin('inbox_mails', 'inbox_mails.folder', '=', 'inbox_folders.id')
		->where('inbox_folders.id', '=', $folderId)
		->where('inbox_folders.mailRef', '=', $selectedAccount)			
		->get();
		
		$userInboxMailCount = $userInboxMail->count();
		
		//return response()->json($userInboxMail);	
				
		if($userInboxMailCount > 0)
		{	
			$mail_array = array();
			$i=0;
			//Loop through every Mailbox
			/** @var \Webklex\IMAP\Folder $oFolder */
			foreach($userInboxMail as $oMessage)
			{	
				//Get all Messages of the current Mailbox $oFolder
				/** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
			
				$mail_array[$i]['id'] = $oMessage->mail_id;
				
				/* From  */
				$mail_array[$i]['from'] = unserialize($oMessage->from);
				
				/* From  */
				$mail_array[$i]['to'] = array(unserialize($oMessage->to));
				
				/* Subject  */
				$mail_array[$i]['subject'] = $oMessage->subject;
				
				/* Message  */
				$mail_array[$i]['message'] = $oMessage->message;
				//$mail_array[$i]['message'] = 'Dummy Text Email  - Static';
				
				
				/* Time */
				$mail_array[$i]['time'] = date('d M', strtotime($oMessage->mail_date));
				
				/* Read */
				$mail_array[$i]['read'] = false;
				
				/* Starred */
				$mail_array[$i]['starred'] = false;
				
				/* Important */
				$mail_array[$i]['important'] = true;
				
				
				$mail_array[$i]['hasAttachments'] = $oMessage->hasAttachments;
				
				$mail_array[$i]['attachments'] = unserialize($oMessage->attachments);
				
				$mail_array[$i]['labels'] = array();
				$mail_array[$i]['folder'] = 0;
				
				$i++;
			}
			
			return response()->json($mail_array);
		}
		else
		{
		  return response()->json(['statusCode'=>'0']);
		}
	}
	
}
