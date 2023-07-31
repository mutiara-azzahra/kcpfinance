@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h3><b>Neraca Saldo</b></h3>
            </div>
            <div class="float-right">
              
            </div>
            
        </div>
    </div>
 
   @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    @if ($message = Session::get('warning'))
    <div class="alert alert-warning">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="col">
        <div class="card" style="padding: 20px;">
                    <!-- <div class="float-left col-md-12">
                        <h4>Filter</h4>
                    </div> -->

                    <div class="card-body">
                        <form action="{{ route('neraca-saldo.report') }}"  method="GET">
                            <!-- @csrf -->
                            <div class="col">
                                
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="">Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" id="" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="">Tanggal Akhir</label>
                                        <input type="date" name="tanggal_akhir" id="" class="form-control" placeholder="">
                                    </div>
                                </div>

                                <div class="float-right pt-2">
                                    <button class="btn btn-warning" type="submit"><i class="fas fa-eye"></i> Tampil</button>
                                    <!-- <button class="btn btn-success" type="submit"><i class="fas fa-file"></i> Excel</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                    
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection