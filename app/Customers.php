<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract; 
class Customers extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName','lastName','avatar','company','jobTitle','email','phone','invoiceAddress','invoicelat','invoicelng','shippingAddress','shippinglat','shippinglng',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    public function getipc()
    {
        $result = self::with(['orders','payments','shipping_details'])
              // ->where('id', '=', $id) 
              ->get();
        return $result;
    }


        public function orders()
    {
        return $this->hasMany('App\Orders','customers_Id')->join('statuses','statuses.id','=','orders.statuses_id');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }
    public function payments()
    {
        return $this->hasMany('App\Payments','customers_Id');
    } 

    public function shipping_details()
    {
        return $this->hasMany('App\ShippingDetails','customers_Id');
    } 

   
    // public function statuses()
    // {
    //     return $this->hasMany('App\Statuses');
    // } 

   

}
