<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract; 
class Boards extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','name','uri','created_at','updated_at','createdBy','boardData',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */  
    public function getipc($id)
    {
        $result = self::with(['lists','idCards','settings','cards','Labels','idMembers','members'])
                   ->where('id','=',$id)
                   ->get();
        return $result;
    }

    public function lists()
    {
        return $this->hasMany('App\Lists','boardId');//->select(DB::raw('(start_time-end_time) AS total_sales'));
    }
    public function idCards()
    {
        return $this->hasMany('App\ListCards', 'boardId'); 
    }
    public function settings()
    {
        return $this->hasOne('App\Settings','boardId');

    } 
     public function cards()
    {
        return $this->hasMany('App\Cards','boardId'); 
    }    
    public function labels()
    {
        return $this->hasMany('App\Labels','boardId'); 
    }  
    public function idMembers()
    {
        return $this->hasMany('App\ListMembers','boardId'); 
    }   
     public function members()
    {
        return $this->hasMany('App\Members','boardId'); 
    }  
    // public function owner()
    // {
    //     return $this->belongsTo(ListCards::Lists);
    // } 
}
