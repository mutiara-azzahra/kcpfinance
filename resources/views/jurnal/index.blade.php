@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h3><b>Jurnal</b></h3>
            </div>
            <!-- <div class="float-right">
                <a class="btn btn-success" href="{{ route('jurnal.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div> -->
            
        </div>
    </div>
 
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="col">
        <div class="card" style="padding: 20px;">
                <div class="col">
                    <div class="float-left p-3 col-md-12">
                        <h4>Filter</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('jurnal.report') }}"  method="GET">
                            <!-- @csrf -->
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
                        </div>

                    <div class="float-right pt-2">
                        <button class="btn btn-warning" type="submit"><i class="fas fa-eye"></i> Tampil</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card" style="padding: 20px;">
            <div class="col">
                    <div class="col-lg-12 pb-5">
                        <h4>Data Jurnal</h4>      
                    </div>

                    <div class="col-lg-12">  
                        <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tgl</th>
                                <th class="text-center">Reff</th>
                                <th class="text-center">Trx</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp
                            @foreach ($jurnal as $j)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td> {{ $j->trx_date }}</td>
                                <td> {{ $j->trx_from }}</td>
                                <td> {{ $j->keterangan }}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $jurnal->links('pagination::bootstrap-4') !!}
                    </div>

            </div>
        </div>
</div> 
@endsection

@section('script')

@endsection