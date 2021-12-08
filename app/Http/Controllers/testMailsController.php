<?php

namespace App\Http\Controllers;
use App\MailConfigure;
use App\User;
use App\MailConfigures;
use App\InboxMails;
use App\InboxFolders;
use App\InboxCustoms;
use App\MailFolders;
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
 
class testMailsController extends Controller
{
	/*
	** Add new inbox	
	*/
	public function show()
	{  
				
			/* $inbox = $request->input('inbox'); */
			$email = 'patrickphp2@gmail.com';
			$type = 'gmail';
			$password = 'Informatics';
			$port = 993;
			
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
				$mailref = substr(md5(time()), 0, 10);	
					$mail_array = array();
						
						/*  start - Retrive mails from configured account */	
						$aFolder = $oClient->getFolders();	
						
						$fold_i = 0;
						if(count($aFolder) > 0)
						{
							$folder_arr = array();
							
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
						//$userInbox = InboxFolders::insert($folder_arr);
						$inb_fold_arr = InboxFolders::select('id','title')->where('mailRef','=','3d2d7ea316')->get();
						$fold_arr = $inb_fold_arr->toArray();
						
						if(count($fold_arr) >0)
						{
							$new_fold_arr = array();
							foreach($fold_arr as $val)
							{
								$new_fold_arr[$val['id']] = $val['title'];
							}
						}
						
						
						print_r($new_fold_arr);
					
						foreach($aFolder as $oFolder)
						{						
							//Get all Messages of the current Mailbox $oFolder
							/** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
							//$aMessage = $oFolder->messages()->all()->get();
							$aMessage = $oFolder->query()->since(now()->subDays(5))->limit(2)->get();	
							
							$i=0;
							/** @var \Webklex\IMAP\Message $oMessage */
							foreach($aMessage as $oMessage)
							{		
								echo $oFolder->fullName;
								
								$k = array_search($oFolder->fullName , $new_fold_arr);	
								$mail_array[$i]['folder'] 		= $k;
								die;
								
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
								
								/* Folder */
								$k = array_search($childFolder->fullName , $new_fold_arr);	
								$mail_array[$i]['folder'] 		= $k;
								
								
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
						//$userInbox = InboxMails::insert($mail_array);
						/*  end - Retrive mails from configured account */	
					}
	}


}
