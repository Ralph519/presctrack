<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\item;

class itemMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response (item::orderBy('item_description')->get(),200);
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
        'itemdescription' => 'required',
      ]);

      $prescitems = new item;
      $prescitems->item_description = $request->input('itemdescription');
      $prescitems->generic_name = $request->input('genericname');
      $prescitems->package = $request->input('package');
      $prescitems->stocks_on_hand = $request->input('stocksonhand');

      $prescitems->save();

      return response($prescitems, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response (item::orderBy('item_description')->get(),200);
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
    public function update(Request $request, item $item)
    {
      $data = $request->validate([
       'item_description' => 'required',
     ]);

     $item->update($request->all());
     return response($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(item $item)
    {
        $item->delete();

        return response('Deleted Succesfully', 200);
    }
}
