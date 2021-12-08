<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract; 
class Orders extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customers_Id','products_Id','reference','subtotal','tax','discount','total','transactionId','amount','method','tracking','carrier',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function getipc($reference)
    {
        $result = self::with(['customers','payments','shipping_details'])
              ->where('reference', '=', $reference)
              ->join('statuses','statuses.id','=','orders.statuses_id')
              ->get();
        return $result;
    }


        public function customers()
    {
        return $this->belongsTo('App\Customers','customers_Id');//->join('statuses','statuses.id','=','orders.statuses_id');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }
    public function payments()
    {
        return $this->belongsTo('App\Payments','customers_Id','id');
    } 

    public function shipping_details()
    {
        return $this->belongsTo('App\ShippingDetails','customers_Id','id');
    } 
 

    //     public function getipc()
    // {
    //     $result = self::with(['customers','products','payments','shipping_details'])
    //           // ->where('id', '=', $id) 
    //           ->get();
    //     return $result;
    // }


    //     public function customers()
    // {
    //     return $this->hasMany('App\Customers','id');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    // }
    // public function products()
    // {
    //     return $this->hasMany('App\Products', 'id');
    // } 


    // public function payments()
    // {
    //     return $this->hasMany('App\Payments','customers_Id');
    // } 

    // public function shipping_details()
    // {
    //     return $this->hasMany('App\ShippingDetails','customers_Id');
    // } 


} 