@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Dashboard</h3>
            <br>
            <table id="employees" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%">
                  <thead>
                      <tr>
                          <th>Item Description</th>
                          <th class="text-right">Beg. Qty</th>
                          <th class="text-right">Qty Dispensed</th>
                          <th class="text-right">Stocks on hand</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                        <th>Item Description</th>
                        <th class="text-right">Beg. Qty</th>
                        <th class="text-right">Qty Dispensed</th>
                        <th class="text-right">Stocks on hand</th>
                      </tr>
                  </tfoot>
                  <tbody>
                    @foreach($prescriptions as $prescription)

                      <tr>
                        <td><h6>{{$prescription->item_description}}</h6></td>
                        <td><h6 class="text-right">{{$prescription->stocks_on_hand}}</h6></td>
                        <td><h6 class="text-right">{{$prescription->qty}}</h6></td>
                        <td><h4 class="text-right">{{$prescription->stocks_on_hand - $prescription->qty}}</h4></td>
                      </tr>
                    @endforeach
                  </tbody>
            </table>

        </div>
    </div>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
@endsection

@section('pagescripts')
<link href="{{ asset("/css/jquery.dataTables.css")}}" rel="stylesheet" />
<script src="{{ asset("/js/jquery.datatables.js")}}"></script>

<script>
$(document).ready(function() {
  $('#employees').DataTable( {
      "order": [[ 0, "asc" ]],
      "columnDefs": [
   { className: "fontbolddatatable", "targets": [ 3 ] }
    ]
  } );
} );
</script>
@endsection
