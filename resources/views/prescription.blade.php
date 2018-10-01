@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h5>Prescription</h5>
            <br>

            <div class="col-md-12">

              <div class="card border-primary mb-3">
                <div class="card-header">Add new prescription</div>
                <div class="card-body">
                  <h4 class="card-title">Prescription Details</h4>

                  <div id="app">
                    <prescription-master></prescription-master>
                  </div>

                </div>
              </div>

            </div>




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
