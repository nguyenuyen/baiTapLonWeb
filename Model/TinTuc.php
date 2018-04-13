<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    //
    protected $table = "TinTuc";

    public function loaitin(){
    	return $this->belongsTo('App\LoaiTin','idLoaiTin','id');
    }

    public function comment(){
    	return $this->hasMany('App\Comment','idTinTuc','id');
    }

    public function report(){
    	return $this->hasMany('App\Report','idTinTuc','id');
    }

    public function admin(){
        return $this->belongsTo('App\User','by','id');
    }
    
}
