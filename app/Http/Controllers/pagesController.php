<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\prescription;
use App\item;

class pagesController extends Controller
{
    public function itemmaster()
    {
      return view('itemmaster');
    }

    public function prescription()
    {
      return view('prescription');
    }

    public function dashboard()
    {
      $prescriptions =  item::select(DB::raw('items.item_description, items.stocks_on_hand, sum(qty) as qty'))
                          ->leftJoin('prescriptions', 'items.id', '=', 'prescriptions.item_id')
                          ->groupBy('items.id')
                          ->get();

          return view('welcome', compact('prescriptions'));
    }
}
