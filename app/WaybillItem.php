<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaybillItem extends Model
{
    protected $fillable = ['id_waybills','id_products','quantity','price','description'];

    public function waybill()
    {
    	return $this->belongsTo('App\Waybill');
    }
}
