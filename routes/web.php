<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });
	//........User Routes

	$router->post('signup', array('uses' => 'userController@store'));
	$router->post('doLogin', array('uses' => 'userController@doLogin'));
	$router->post('updateUserData', array('uses' => 'userController@updateUserData'));

	// .............categroies and products Routes

	$router->get('category', array('uses' => 'catproductsController@show'));
	$router->post('category', array('uses' => 'catproductsController@store'));


	$router->delete('category/{id}', array('uses' => 'catproductsController@destroy'));



	$router->get('products', array('uses' => 'catproductsController@showProducts'));
	$router->get('showProductsAgainstCAt', array('uses' => 'catproductsController@showProductsAgainstCAt'));
	$router->post('products', array('uses' => 'catproductsController@storeprodutcs'));
	$router->post('products/{id}', array('uses' => 'catproductsController@updateproducts'));
	$router->delete('products/{id}', array('uses' => 'catproductsController@destroyproducts'));
	$router->get('productDetail/{id}', array('uses' => 'catproductsController@productDetail'));

    //..........Customers Routes

	$router->get('customer', array('uses' => 'customersController@show'));
	// $router->get('showProductsAgainstCAt', array('uses' => 'customersController@showProductsAgainstCAt'));
	$router->post('customer', array('uses' => 'customersController@store'));
	$router->post('customer/{id}', array('uses' => 'customersController@update'));
	$router->delete('customer/{id}', array('uses' => 'customersController@destroy'));
 
    //..........orders Routes

	$router->get('order', array('uses' => 'ordersController@show'));
	$router->get('showorderAgainstCust', array('uses' => 'ordersController@showorderAgainstCust'));
	$router->get('showsingleOrder', array('uses' => 'ordersController@showsingleOrder'));
	$router->get('showproductsAgainstCust', array('uses' => 'ordersController@showproductsAgainstCust'));
	$router->post('order', array('uses' => 'ordersController@store'));
	$router->post('order/{id}', array('uses' => 'ordersController@update'));
	$router->post('updateOrderStatus', array('uses' => 'ordersController@updateOrderStatus'));
	$router->delete('order/{id}', array('uses' => 'ordersController@destroy'));

     //..........board Routes

	$router->get('board', array('uses' => 'boardsController@show'));
	$router->get('showOwnerandTeam', array('uses' => 'boardsController@showOwnerandTeam'));
	$router->get('showmembers', array('uses' => 'boardsController@showmembers'));
	$router->get('showmembersCL', array('uses' => 'boardsController@showmembersforContacList'));
	$router->get('showBoard/{id}', array('uses' => 'boardsController@showBoard'));
 	$router->post('updateboard/{id}', array('uses' => 'boardsController@update'));
	$router->post('board/{id}', array('uses' => 'boardsController@store'));
	$router->delete('board/{id}', array('uses' => 'boardsController@destroy'));
  
     //..........calendar Routes
 
	$router->get('calendar', array('uses' => 'calendarController@showcalendar')); 
	$router->post('calendar', array('uses' => 'calendarController@store')); 

      //..........todo Routes

	$router->get('filters', array('uses' => 'todoController@getFileters'));
	$router->get('tags', array('uses' => 'todoController@getTags'));
	$router->get('todo', array('uses' => 'todoController@getTodo'));
	$router->get('getByTag/{handle}', array('uses' => 'todoController@getByTag'));
	$router->get('getByFilter', array('uses' => 'todoController@getByFilter'));
    // $router->post('updateboard/{id}', array('uses' => 'todoController@update'));
	$router->post('todo/{id}', array('uses' => 'todoController@store'));
	// $router->delete('board/{id}', array('uses' => 'todoController@destroy'));
 
     //..........Lists Routes

	$router->get('list', array('uses' => 'boardsController@showList'));
 	$router->post('list/{id}', array('uses' => 'boardsController@updateList'));
	$router->post('list', array('uses' => 'boardsController@storeList'));
	$router->delete('list/{id}', array('uses' => 'boardsController@destroyList'));
   
      //..........chats Routes

	$router->post('chats', array('uses' => 'chatController@chats'));
	$router->post('userData', array('uses' => 'chatController@userData'));
	$router->get('showUserData/{id}', array('uses' => 'chatController@showUserData'));
	$router->get('showUserdialogue/{id}', array('uses' => 'chatController@showUserdialogue'));
	$router->get('showByChatId/{id}', array('uses' => 'chatController@showByChatId'));
	
 	 
 
    // to fetch person details
	$router->get('person', array('uses' => 'personDetailsController@person'));

    // to fetch group details /{uid}
	$router->post('group', array('uses' => 'groupsController@group'));
	$router->post('groups/{uid}', array('uses' => 'groupsController@groups'));
    $router->post('insertGroup', array('uses' => 'groupsController@InsertingGroupData'));
	$router->post('UpdateGroup', array('uses' => 'groupsController@UpdatingGroupData'));
    $router->post('newRowCol', array('uses' => 'groupsController@RowColData'));
	//fetch user id according to token_type
    $router->post('getUserId', array('uses' => 'userController@FetchUserId'));

    $router->post('col_relations/{uid}',array('uses' =>'tabularColController@col_relation_store'));
    $router->post('colrelations/{uid}',array('uses' =>'tabularColController@get_relationalcols'));

    $router->post('getBoardName/{tid}',array('uses' =>'groupsController@boardName'));
    $router->post('UpdateBoardName',array('uses' =>'groupsController@newBoardName'));
    $router->post('getDateList/{id}',array('uses' => 'groupsController@dateList'));
    $router->post('UpdateDateList',array('uses' => 'groupsController@UpdateDateList'));
    $router->post('statusOption',array('uses' => 'groupsController@statusOptionList'));   
	
	$router->post('check_relation/{col}',array('uses'=>'groupsController@getRelationsList'));
	$router->post('delete_relation',array('uses'=>'groupsController@deleteRelation'));
	
	//..........mail configure Routes
	
	$router->post('mail-configure', array('uses' => 'mailConfiguresController@show'));
	$router->post('checkimap', array('uses' => 'mailConfiguresController@checkimap'));
	$router->post('user-inbox', array('uses' => 'mailConfiguresController@userInbox'));
	$router->get('message-detail/{id}', array('uses' => 'mailConfiguresController@getMessageDetail'));
	
	$router->post('default-folder', array('uses' => 'mailConfiguresController@defaultFolder'));
	$router->post('custom-folder', array('uses' => 'mailConfiguresController@customFolder'));
	
	
	$router->post('folderdetail', array('uses' => 'mailConfiguresController@folderDetail'));
	$router->post('folder-mails', array('uses' => 'mailConfiguresController@getFolderMail'));
	
	
	$router->get('test-mail', array('uses' => 'testMailsController@show'));
	
	$router->post('inviteMail',array('uses'=>'groupsController@sendInvite'));
	$router->post('acceptInvitation/{tabid}',array('uses'=>'groupsController@acceptInvite'));
	
	//activity log Routes
	$router->post('activitylogstore',array('uses' =>'tabularColController@activity_log_store'));
	$router->post('activitylogfetch',array('uses' =>'tabularColController@activity_log_fetch'));
	/* Send Mail */
	$router->post('compose-mail', array('uses' => 'composeMailController@show'));
	$router->get('compose-test', array('uses' => 'composeMailController@testing'));

