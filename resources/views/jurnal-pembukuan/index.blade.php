@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <h2>Data Jurnal</h2>
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
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('jurnal_pembukuan.report') }}"  method="GET">
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
                    <div class="float-right p-3">
                            <button class="btn btn-warning" type="submit"><i class="fas fa-print"></i> Proses</button>
                    </div>
                </div>
            </form>
    </div>

    <div class="card" style="padding: 20px;">
        <div class="col">
                <div class="col-lg-12 pb-5">  
                </div>

                <div class="col-lg-12">  
                    <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tgl</th>
                            <th class="text-center">Reff</th>
                            <th class="text-center">Trx</th>
                            <th class="text-center">Debet</th>
                            <th class="text-center">Kredit</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;

                        @endphp
                        @foreach ($jurnal_pembukuan as $j)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td> {{ $j->trx_date }}</td>
                            <td> {{ $j->trx_from }}</td>
                            <td> {{ $j->keterangan }}</td>
                            <td></td>
                            <td></td>
                            <td class="text-center">   
                                    <a class="btn btn-primary btn-md" href=""><i class="fas fa-info"></i></a>
                                    
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
        </div>
    </div>

        
</div> 
@endsection

@section('script')

@endsection