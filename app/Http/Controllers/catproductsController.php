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
use App\ProductAttachements; 
use Illuminate\Support\Facades\Mail;
use DB;
 
class catproductsController extends Controller
{  

    //   public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

  //..............categories funtionality

   public function show()
  {     
    $Messages=Categories::all();

    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Categories','Result'=>$Messages]);
  } 


  public function store(Request $request)
  {  
      $Activities = Categories::insert(Input::all());
     // $Activities = Categories::create($request->all());
 
    return response()->json(['statusCode'=>'1','statusMessage'=>'Categories Created','Result'=>$Activities]);
  }
  

   public function update($id,Request $request)
  {     
   $Category=Categories::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    } 
       $Category->update($request->all());

    return response()->json(['statusCode'=>'1','statusMessage'=>'Categories Data is Updated','Result'=>$Category]);

  } 

  public function destroy($id,Request $request)
  { 
   $Category=Categories::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
    $Category->delete();
    return response()->json(['statusCode'=>'1','statusMessage'=>'Categories deleted','Result'=>NULL]);
  }

 
  //..............Products funtionality
 

   public function showProducts()
  { 
        $catArray =[]; 

        $Messages=DB::table('categories') 
                    ->join('products','products.categories','=','categories.id')
                    ->select('products.*','categories.categoryName','categories.id as categoryId') 
                    ->get();

        // $Messages=DB::table('products') 
        //             ->join('categories','categories.product_Id','=','products.id')
        //             ->select('products.*','categories.categoryName','categories.id as categoryId') 
        //             ->get();
 
      
    for ($i=0; $i <count($Messages) ; $i++) { 

       $cat=DB::table('categories')
                    ->where('product_Id', '=', $Messages[$i]->id)
                    ->pluck('categoryName');
                    // return $cat;
                  array_push($catArray,$cat);
    } 
    $Messages->{"categori"} = $catArray; 
     return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Products','Result'=>$Messages,'categories'=>$catArray]);
  } 

   public function showProductsAgainstCAt(Request $request)
  {
       $cat = $request->Input('CategoryId');

            $Messages=DB::table('products')
                    ->where('categories', '=', $cat )
                    ->get();
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing all Products','Result'=>$Messages]);
  } 


  public function storeprodutcs(Request $request)
  {  
      try {
     $Activities = Products::create($request->except(['tags','images']));

 // if ($request->has('categories')) {
 
 //  for ($i=0; $i <count($request['categories']) ; $i++) {

 //             $temp = $request['categories'][$i];

 //             $temp = array("product_Id" => $Activities->id, "categoryName" => $temp);
 
 //        DB::table('categories')->insertGetId($temp);
 //     }
 //  }

  if ($request->has('images')) {

   for ($i=0; $i <count($request['images']) ; $i++) {

      $unique = bin2hex(openssl_random_pseudo_bytes(10));

        $temp = $request['images'][$i];
 
     // $format = $request->input('content_type');   
        $format = '.png';   
     
     // $entityBody =$request['attchements'];// file_get_contents('php://input');
 
     $imageName = $Activities->id.$unique.$format; 
    // return $entityBody;
      $directory = "/images/productAttachements/";
      
      $path = base_path()."/public".$directory;

      $data = base64_decode($temp);

     file_put_contents($path.$imageName, $data);

      $response = $directory.$imageName;
 
        //  $temp = array("product_id" => $Activities->id, "attachement_url" => $response);
 
        // DB::table('product_attachements')->insertGetId($temp);

      $product_attachements  = new ProductAttachements();
      
      $product_attachements->url = $response;
      $product_attachements->product_id = $Activities->id;

      $product_attachements->save();

       }
    }

    $productAtt=DB::table('product_attachements')
                    ->where('product_attachements.product_id', '=', $Activities->id ) 
                    ->get();

    return response()->json(['statusCode'=>'1','statusMessage'=>'Products Created','Result'=>$Activities,'images'=>$productAtt]);
      }

    catch (Illuminate\Database\QueryException $e) {
            return response()->json(['statusCode'=>'0','statusMessage'=>'Some thing went wrong','error' => $e->getMessage()]);
          } catch (PDOException $e) {
            return response()->json(['statusCode'=>'0','statusMessage'=>'Some thing went wrong','error' => $e->getMessage()]);
          } catch (\Exception $e) {
            return response()->json(['statusCode'=>'0','statusMessage'=>'Some thing went wrong','error' => $e->getMessage()]);
          }
}
 
  

   public function updateproducts($id,Request $request)
  { 
   $Category=Products::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
 
       $Category->update($request->except(['tags','images','categories']));
       // $Category->update($request->all());

      if ($request->has('images')) {


             $productAtt=DB::table('product_attachements')
                          ->where('product_id', '=', $Category->id ) 
                          ->delete();


   for ($i=0; $i <count($request['images']) ; $i++) {

      $unique = bin2hex(openssl_random_pseudo_bytes(10));

        $temp = $request['images'][$i];
 
     // $format = $request->input('content_type');   
        $format = '.png';   
     
     // $entityBody =$request['attchements'];// file_get_contents('php://input');
 
     $imageName = $Category->id.$unique.$format; 
    // return $entityBody;
      $directory = "/images/productAttachements/";
      
      $path = base_path()."/public".$directory;

      $data = base64_decode($temp);

     file_put_contents($path.$imageName, $data);

      $response = $directory.$imageName;
 
        //  $temp = array("product_id" => $Activities->id, "attachement_url" => $response);
 
        // DB::table('product_attachements')->insertGetId($temp);

      $product_attachements  = new ProductAttachements();
      
      $product_attachements->url = $response;
      $product_attachements->product_id = $Category->id;

      $product_attachements->save();

       }
    }





    return response()->json(['statusCode'=>'1','statusMessage'=>'Products Data is Updated','Result'=>$Category]);

  } 


  public function productDetail($id)
  { 
   // $Category=Products::find($id);
  
       $model = new Products();
 
       $ipc  = $model->getipc($id);





      // $ipc = DB::table('products')
      //               ->where('products.id', '=', $id )
      //               ->join('categories','categories.id','=','products.categories')
      //               ->get();


    //  $products=DB::table('products')
    //                 ->where('products.id', '=', $id )
    //                 // ->join('product_attachements','product_attachements.product_id','=','products.id')
    //                 ->first();

    //   $categories=DB::table('categories')
    //                 ->where('product_Id', '=', $products->id)
    //                 // ->join('categories','categories.product_Id','=','products.id')
    //                 ->get();
                     
               
    //   $product_attachements=DB::table('product_attachements')
    //                 ->where('product_id', '=', $products->id)
    //                 // ->join('categories','categories.product_Id','=','products.id')
    //                 ->get();
                     
               

    //  if(!$products)
    // {
    //  return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    // }
        
    return response()->json(['statusCode'=>'1','statusMessage'=>'showing product details','Result'=>$ipc]);
    // return response()->json(['statusCode'=>'1','statusMessage'=>'Products Data is Updated','Result'=>$productsat,'categories'=>$categories,'images'=>$product_attachements]);

  } 

  public function destroyproducts($id,Request $request)
  { 
   $Category=Products::find($id);

     if(!$Category)
    {
     return response()->json(['statusCode'=>'0','statusMessage'=>'Record Not Found','Result'=>NULL]);
    }
    
    $Category->delete();

    return response()->json(['statusCode'=>'1','statusMessage'=>'Products deleted','Result'=>NULL]);
  }
    
 
}