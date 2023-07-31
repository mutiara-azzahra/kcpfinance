@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h3><b>Jurnal</b></h3>
            </div>
            <div class="float-right">
                <!-- <a class="btn btn-success" href=""><i class="fas fa-plus"></i> Tambah Jurnal Baru</a>
                <a class="btn btn-warning" href=""><i class="fas fa-print"></i> Export</a> -->
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
                                <th class="text-center">Debet</th>
                                <th class="text-center">Kredit</th>
                                <!-- <th class="text-center">Aksi</th> -->
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
                                <td></td>
                                <td></td>
                                <td class="text-center">   
                                        <a class="btn btn-primary btn-md" href=""><i class="fas fa-info"></i></a>
                                        
                                </td>
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