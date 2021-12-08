<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract; 
class Products extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categories_Id','name','handle','description','priceTaxExcl','priceTaxIncl','taxRate','comparedPrice','comparedPrice','sku','width','height','depth','weight','extraShippingFee','active','quantity','product_Id','categories','status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */ 

         public function getipc($id)
    {
        $result = self::with(['images'])
               ->where('products.id', '=', $id)
               // ->join('categories','categories.id','=','products.categories')
               ->get();
        return $result;
    }

        public function categories()
    {
        return $this->hasMany('App\Categories','id');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }
    public function images()
    {
        return $this->hasMany('App\ProductAttachements','product_id');
    } 

}

// $inventory_products = DB::table('inventory_products')
//               ->where('vendor_id', '=', $vendor_id)
//               ->get();
//         try {
//           for($i = 0; $i < count($inventory_products); $i++) {
//             $inventory_products[$i]->{'options'} = DB::table('inventory_product_options')->where('product_Id', '=',  $inventory_products[$i]->id)->pluck('product_Id');
//             $inventory_products[$i]->{'skus'} = DB::table('inventory_product_sku_infos')->where('product_Id', '=',  $inventory_products[$i]->id)->get();

//             for ($j = 0; $j < count($inventory_products[$i]->skus); $j++) {
//               $inventory_products[$i]->skus[$j]->{'option_values'} = DB::table('inventory_product_options_values')->where('sku_id', '=',  $inventory_products[$i]->skus[$j]->id)->select('option_value_id', 'option_id')->get();
//             }
//           }
//         return response()->json(['statusCode'=>'1','statusMessage'=>'Showing All Inventory Products','Result'=>$inventory_products]);
//       } catch (\Exception $e) {
//         return response()->json(['statusCode'=>'0','statusMessage'=>'Some thing went wrong','error' => $e->getMessage()]);
//       }