<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
   protected $fillable = ['consignee','consignor','dr_number','status','payment_terms'];

   public function items()
   {
   	return $this->hasMany('App\WaybillItem', 'id_waybills');
   }
}
