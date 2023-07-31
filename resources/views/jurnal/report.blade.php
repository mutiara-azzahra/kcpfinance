@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <div class="col">
                    <h2>Data Jurnal</h2>
                    <h4>{{ $tanggal_awal}} s/d {{ $tanggal_akhir}}</h4>
                </div>
            </div>
            <div class="float-right">
                    <a class="btn btn-success" href="{{ route('jurnal.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            
        </div>
    </div>
 
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card" style="padding: 20px;">
        <div class="col">
                <div class="col-lg-12">  
                    <table class="table table-hover table-bordered table-sm bg-light" id="example1">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tgl</th>
                            <th class="text-center">Reff</th>
                            <th class="text-center">Trx</th>
                            <th class="text-center">Debet</th>
                            <th class="text-center">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;

                        @endphp
                        @foreach ($jurnalHeader as $j)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td> {{ $j->trx_date }}</td>
                            <td> {{ $j->trx_from }}</td>
                            <td> {{ $j->keterangan }}</td>
                            
                          
                            <td></td>
                            <td>
                                @foreach($j->jurnal_detail as $detail)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$detail->keterangan}}</td>
                                    <td>{{$detail->debet}}</td>
                                    <td>{{$detail->kredit}}</td>
                                </tr>
                               @endforeach
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                {!! $jurnalHeader->appends(['tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir])->links('pagination::bootstrap-4') !!}
                
                </div>

        </div>
    </div>

        
</div> 
@endsection

@section('script')

@endsection