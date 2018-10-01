<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prescription extends Model
{
  protected $fillable = [
    'item_id',
    'doctor_name',
    'patient_name',
    'qty'
    ];

   public function items()
   {
     return $this->belongsTo('App\item', 'item_id', 'id');
   }
}
