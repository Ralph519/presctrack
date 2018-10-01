<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
  protected $fillable = [
    'item_description',
    'generic_name',
    'package',
    'stocks_on_hand',
    ];

  public function prescription()
  {
    return $this->hasMany('App\prescription');
  }
}
