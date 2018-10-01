<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\prescription;
use App\item;

class prescriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response (prescription::with('items')->get(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->validate([
        'doctor_name' => 'required',
      ]);

      $prescription = new prescription;
      $prescription->item_id = $request->input('item_id');
      $prescription->doctor_name = $request->input('doctor_name');
      $prescription->patient_name = $request->input('patient_name');
      $prescription->qty = $request->input('qty');

      $prescription->items; //include the relationship to items table to include it in the response

      $prescription->save();

      return response($prescription, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, prescription $prescription)
    {
      $data = $request->validate([
       'doctor_name' => 'required',
     ]);

     $prescription->update($request->all());
     $prescription->items;


     return response($prescription, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(prescription $prescription)
    {
      $prescription->delete();

      return response('Deleted Succesfully', 200);
    }

    public function getInventory($itemid)
    {
      $inventory =  item::select(DB::raw('items.item_description, items.stocks_on_hand, sum(qty) as qty'))
                          ->leftJoin('prescriptions', 'items.id', '=', 'prescriptions.item_id')
                          ->where([
                            ['items.id', $itemid]
                            ])
                          ->groupBy('items.id')
                          ->get();

      return response($inventory, 201);
    }
}
