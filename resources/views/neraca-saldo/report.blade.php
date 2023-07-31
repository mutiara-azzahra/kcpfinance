@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <div class="col">
                    <h2>Neraca</h2>
                    <h4>Periode {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h4>
                </div>
            </div>

            <div class="float-right">
                <a class="btn btn-success" href="{{ route('neraca-saldo.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            
        </div>
    </div>
 
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card p-3">
        <div class="col">
                <div class="table-responsive">  
                    <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                    <thead>
                        <tr>
                        
                            <th class="text-center">Perkiraan</th>
                            <th class="text-center">Saldo Awal</th>
                            <th class="text-center">Debet</th>
                            <th class="text-center">Kredit</th>
                            <th class="text-center">Saldo Akhir</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                  
                        @php
                        $no=1;
                        
                        @endphp

                                @foreach ($saldoAwalNeraca as $s)
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'],0,',','.') }}</td>
                                    <td class="text-right">{{ number_format($s['debetSum'],0,',','.') }}</td>
                                    <td class="text-right">{{ number_format($s['kreditSum'],0,',','.') }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal']+$s['debetSum']-$s['kreditSum'],0,',','.')   }}</td>
                                </tr>
                                @endforeach

                            

                                <tr>
                                    <td>Grand Total</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                       
                    </tbody>

              
                </table>
             

                </div>
        </div>
    </div>

        
</div> 
@endsection

@section('script')

@endsection