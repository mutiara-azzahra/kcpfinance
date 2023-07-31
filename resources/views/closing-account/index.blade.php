@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <h2>Akun Tutup Bulan (Bulan)</h2>
            </div>
            
        </div>
    </div>
 
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="col">
            <div class="card" style="padding: 20px;">
                <div class="card-body">
                    <form action="{{ route('closing-account.report') }}" method="GET">
                        <!-- @csrf -->
                        
                        <div class="form-group col-12">
                            <label for="">Periode Tahun</label>
                            <input type="text" name="periode" id="date" class="form-control" placeholder="">
                        </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-warning" href=""><i class="fas fa-print"></i> Proses</button>
                </div>
            </form>
            </div>
</div>
    
</div> 
@endsection

@section('script')

$(function() {
    $( "#date" ).datepicker({dateFormat: 'yyyy'});
});

@endsection