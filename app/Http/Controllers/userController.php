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
 
class userController extends Controller
{
   // public function __construct()
   //  {
   //      $this->middleware('auth:api', ['except' => ['doLogin', 'store']]);
   //  }

public function store(Request $request)
    {
    try {
  


      $array =[];

      $admin = new User();

       $admin->email=$request->input('email');

       if (empty($admin->email)) 
       {
        array_push($array, "email Required");
        //return response()->json(['statusCode'=>'0','statusMessage'=>'Email Required','Result'=>NULL]); 
       }

        if (User::where('email','=',Input::get('email'))->exists()) 
         {
         return response()->json(['statusCode'=>'400','statusMessage'=>'email Already Exists','Result'=>NULL]);              
         }
  else
  { 
               $admin = new User();
               $admin->email=$request->input('email');
               // $admin->password=$request->input('password');
               $admin->password=Hash::make(Input::get("password"));
               $admin->fullName=$request->input('fullName'); 

if (!$admin->password)
{
  array_push($array, "Password Required");
}
if (count($array)>0) {

  return response()->json(['statusCode'=>'400','statusMessage'=>'Fill the given fields','Result'=>$array]);
}
       $admin->save();
 
   $token = bin2hex(openssl_random_pseudo_bytes(25));
   
   DB::table('users')->where('id', $admin->id)->update(array('token' => $token));

   $admin->token=$token;

      Mail::send('emails.verify',["data" => $admin], function($message) use ($admin) {
    $message->from('baqalah1@gmail.com', 'FUSE');

    $message->to($admin->email, 'Mail Confirmation')->subject('Testing Mail');
            });


   $collection = collect(['id' => $admin->id, 'email' =>  $admin->email, 'token' =>  $admin->token, 'fullName' =>  $admin->fullName]);
   $collection->toJson(); 
   return response()->json(['statusCode'=>'200','statusMessage'=>'Account Successfully Created','Result'=>$collection]);

        }
      }
        catch (\Exception $e) {
        return response()->json(['statusCode'=>'0','statusMessage'=>'Some thing went wrong','error' => $e->getMessage()]);
      }
    }

public function confirm(Request $request,$id)
     {

 $admin = User::where('token', '=', $id)->first();
        if (!$admin)
{
 return response()->json(['statusCode'=>'1','statusMessage'=>'Something Went wrong','Result'=>$admin]);
} 
        else 
        {
            $account_status = 1;
            DB::table('users')->where('token', $id)->update(array('account_status' => $account_status));

            $admin->save();

            return redirect('http://dr-romia.com/#/pages/auth/login-2');
        }
    } 

protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => Auth::factory()->getTTL() * 60
    ]);
}


    public function doLogin(Request $request)
{ 
        $token = "";
        $Email = Input::get("email");
        // $Password = Input::get("password"); 
        $Password = Hash::make(Input::get("password"));

        // $check_User = DB::table('users')
        //     ->select()
        //     ->where('email', '=', $Email)
        //     ->where('password', '=', $Password) 
        //     ->first();

           $credentials = $request->only('email', 'password');
          if (! $token = Auth::attempt($credentials)) {
              return response()->json(['statusCode'=>'0','statusMessage'=>'Email or password wrong','Result'=>NULL]);
          }
 
        if (!$token)
        {
            return response()->json(['statusCode' => '400', 'statusMessage' => 'Incorrect Email or Password', 'Result' => NULL]);
        }
    
        // $token = bin2hex(openssl_random_pseudo_bytes(25));
        
        // $myUser = DB::table('users')
        //     ->select()
        //     ->where('email', '=', $Email)
        //     ->where('password', '=', $Password)
        //     ->first();
        $myUser = Auth::user();
        // return $myUser;
        if ($myUser->account_status == 0) 
        {
         return response()->json(['statusCode' => '403', 'statusMessage' => 'Kindly Verify Your Email', 'Result' => NULL]);
        } 
 
        if ($myUser) {

            $myUser->token = $token;

            DB::table('users')->where('email', $Email)->update(array('token' => $token));

            return response()->json(['statusCode' => '200', 'statusMessage' => 'Logged In', 'Result' => $myUser]);
        }
        else
        {
          return response()->json(['statusCode' => '400', 'statusMessage' => 'Email or Password Incorrect', 'Result' => NULL]);
        } 
    }
 
public function logout(Request $request) {
    Auth::logout();
   return response()->json(['statusCode'=>'1','statusMessage'=>'Logout Successfully', 'Result' => Auth::user()]);
    // return response()->json(['statusCode'=>'0','statusMessage'=>'Something went wrong, Please try again latter']);
  }

  public function notFound()
  {
       return response()->json(['statusCode'=>'404','statusMessage'=>'Something Went Wrong', 'Result' =>NULL]);

  }

  public function External_Login(Request $request)
    { 
        //Get Input parameters from the service URL

        $email = $request->input('email');
        if (empty($email)) {
          return 'email is Required';
        }
        $token = $request->input('token');
        $fullName = $request->input('fullName');

        //Check either provider is facebook or not

            //if($Provider=='FaceBook')

       //  if ($Provider == 'facebook' || $Provider == 'FACEBOOK') {
       //      // return 'Facebook';
       //      if (!($this->IsFacebookToken($token))) {

       //          return response()->json(['statusCode' => '0', 'statusMessage' => 'Facebook Token is not valid', 'Result' => NULL]);
       //      }
       //  }  
       //          // if($Provider=='gmail')

       //  if ($Provider == 'gmail' || $Provider == 'GMAIL') {
       //      // return 'Gmail';
       //      if (!($this->IsGmailToken($token))) {
       //          return response()->json(['statusCode' => '0', 'statusMessage' => 'Gmail Token is not valid', 'Result' => NULL]);
       //      }
       //  }       
       //           //if($Provider=='Twitter')

       // if ($Provider == 'Twitter' || $Provider == 'TWITTER') {
       //      // return 'Twitter';
       //      if (!($this->IsTwitterToken($token))) {
       //          return response()->json(['statusCode' => '0', 'statusMessage' => 'Twitter Token is not valid', 'Result' => NULL]);
       //      }
       //  } 
       //  else 
       //  {
       //      $token = bin2hex(openssl_random_pseudo_bytes(25)); // If provider is not facebook then generate token
       //  }

            $myUser = '';
            //If user does not exiSt, create the user
            if (!(User::where('email', '=', $email)->exists())) {
                $admin = new User();
                $admin->email = $username;
                $admin->token = $token;
                $admin->fullName = $fullName;
                $admin->password = $token;
                $admin->Account_Status = 1;
                $admin->save();

                //...creating profile
                
                // $VendorProfiles = new VendorProfiles();
                // $VendorProfiles->vendor_id=$admin->id;
                // $VendorProfiles->profileImage=$request->input('profileImage');
                // $VendorProfiles->save();
                // $myUser = $admin;

            } 
            else   
          //If user exists
            {
                //Get user
                $myUser = DB::table('users')
                    ->select('id', 'email', 'token')
                    ->where('email', '=', $email)
                    ->first();
            }
                if ($myUser) {
                    $token = bin2hex(openssl_random_pseudo_bytes(25));
                    $myUser->token = $token;
                    DB::table('users')->where('email', $email)->update(array('token' => $token)); // updating table with newly retrieved token from facebook
                    // $this->saveUUIDandUserID($myUser->id, $UUID, $myUser->Role);
                  
             return response()->json(['statusCode' => '1', 'statusMessage' => 'Logged In', 'Result' => $myUser]);
                }
                else 
            {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Email or Password Incorrect', 'Result' => NULL]);
            }
        
    } 

      public function ForgotPassWord(Request $request)
    { 
        $user = new User();

        $user = $request->input('email');


        $users = DB::table('users')
            ->select()
            ->where('email', '=', $user)
            ->first();
        if (!$users) {
            return response()->json(['statusCode' => '0', 'statusMessage' => 'Email Account is not found in our system.', 'Result' => NULL]);
        }
        // return response($users);

        $concatedToken = $users->token;
        // $concatedToken .= ':';
        // $concatedToken .= $users->id; 

        Mail::send('emails.forgotPass', ['tokenVal' => $concatedToken ], function ($message) use ($user) {
            $message->from('baqalah1@gmail.com', 'FUSE');
            $message->to($user, '')->subject('Reset Password Request');
        });
       return response()->json(['statusCode' => '1', 'statusMessage' => 'Email Sent to Your Mailing Address', 'Result' => NULL]);
    } 
  public function updatePassWord(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        $password = $request->input('password');
        $up = DB::table('users')->where('email','=',$email)->where('token','=',$token)->update(array('password' => Hash::make(Input::get("password"))));
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Password is updated', 'Result' => $up]);
    }   
     public function updateUserData(Request $request)
    {   
        $userId = $request->input('userId');  
        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str);
        $up = DB::table('users')->where('id','=',$userId)->update(array('mood' => json_encode($json_obj->mood)));
        $up = DB::table('users')->where('id','=',$userId)->update(array('status' => json_encode($json_obj->status)));
        $up = DB::table('users')->where('id','=',$userId)->update(array('chatList' => json_encode($json_obj->chatList)));
        return response()->json(['statusCode' => '1', 'statusMessage' => 'Data is updated', 'Result' => $up]);
    } 
}