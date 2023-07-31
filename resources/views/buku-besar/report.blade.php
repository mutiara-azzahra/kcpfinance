@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <div class="col">
                    <h2>Buku Besar</h2>
                    <h4>Periode {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}</h4>
                    <h6>{{ $perkiraan }}</h6>
                </div>
            </div>

            <div class="float-right">
                <a class="btn btn-success" href="{{ route('buku-besar.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            
        </div>
    </div>
 
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card p-1">
        <div class="col">
                <div class="table-responsive">  
                    <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">No</th> -->
                            <th class="text-center">Reff</th>
                            <th class="text-center">Tgl</th>
                            <th class="text-center">Trx Date</th>
                            <th class="text-center">Trx From</th>
                            <th class="text-center">Debet</th>
                            <th class="text-center">Kredit</th>
                            <th class="text-center">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-top: 1px solid black;text-align:center;" colspan="4">Saldo Awal</td>
                            <td style="border-top: 1px solid black;text-align:center;">{{ $escapedValue }}</td>
                            <td style="border-top: 1px solid black;text-align:center;"></td>
                            <td style="border-top: 1px solid black;text-align:center;">{{ $saldoAwal }}</td>
                        </tr>
                        @php
                        $no=1;

                        @endphp
                        @foreach ($bukuBesar as $index => $j)
                            
                                <tr>
                                    <td>{{ $j->id_header }}</td>
                                    <td>{{ $j->trx_date }}</td>
                                    <td>{{ $j->jurnal->trx_from }}</td>
                                    <td>{{ $j->jurnal->keterangan }}</td>
                                    <td>{{ $j->debet }}</td>
                                    <td>{{ $j->kredit }}</td>
                                    @if($index === 0)
                                        
                                        @if($j->debet === 0.00)
                                            @php
                                                $initSaldo -= $j->kredit + $j->debet;
                                            @endphp

                                        @else($j->kredit === 0.00)
                                            @php
                                                $initSaldo += $j->debet - $j->kredit;
                                            @endphp
                                        
                                        @endif
                                        <td>{{ floatval($initSaldo) }}</td>
                                    @else
                                   
                                                @php
                                                     $initSaldo += floatval($j->debet) - floatval($j->kredit);
                                                @endphp

                                            <td>{{ floatval($initSaldo) }}</td>
                                    @endif
                                </tr>

                        @endforeach

                        @php
                            $lastInitSaldo = floatval($initSaldo);
                        @endphp

                        <tr>
                            <td style="border-top: 1px solid black;text-align:center;background-color:#4dff88" colspan="4"><b>Saldo Akhir</b></td>
                            <td style="border-top: 1px solid black;text-align:center;background-color:#4dff88">{{ $escapedValue + $totalDebet }}</td>
                            <td style="border-top: 1px solid black;text-align:center;background-color:#4dff88">{{ $totalKredit }}</td>
                            <td style="border-top: 1px solid black;text-align:center;background-color:#4dff88">{{ $lastInitSaldo }}</td>
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