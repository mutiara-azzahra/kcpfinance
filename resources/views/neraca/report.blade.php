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
                <a class="btn btn-success" href="{{ route('neraca.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                        <!-- <tr>
                        
                            <th class="text-center">Perkiraan</th>
                            <th class="text-center" colspan="2"><b>AKTIVA</b></th>
                        </tr> -->
                    </thead>
                    <tbody>

                        <!-- KAS DAN BANK -->
                        <tr>
                            <td colspan="3"><b>AKTIVA LANCAR</b></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>KAS DAN BANK</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                                $kodePerkiraan = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanKB = ['1.1101', '1.1102', '1.1103', '1.1104', '1.1105', '1.1106', '1.1107', '1.1108', '1.1110', '1.1111', '1.1112'];
                            @endphp

                            @if (in_array($kodePerkiraan, $kodePerkiraanKB))
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirKB, 0, ',', '.') }}</b></td>
                            </tr>


                        <!-- DEPOSITO -->
                            
                        <tr>
                            <td colspan="3"><b>DEPOSITO</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodeD             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanD    = [ '1.1109','1.1201', '1.1202', '1.1203'];
                            @endphp

                            @if (in_array($kodeD, $kodePerkiraanD)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirD, 0, ',', '.') }}</b></td>
                            </tr>

                        
                        <!-- PIUTANG USAHA -->
                            
                        <tr>
                            <td colspan="3"><b>PIUTANG USAHA</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodePU             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanPU    = ['1.1301', '1.1302'];
                            @endphp

                            @if (in_array($kodePU, $kodePerkiraanPU)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirPU, 0, ',', '.') }}</b></td>
                            </tr>


                        <!-- PIUTANG LAINNYA -->
                            
                        <tr>
                            <td colspan="3"><b>PIUTANG LAINNYA</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodePL             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanPL    = ['1.1401', '1.1402', '1.1403', '1.1404', '1.1405', '1.1406', '1.1407', '1.1408', '1.1409'];
                            @endphp

                            @if (in_array($kodePL, $kodePerkiraanPL)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirPL, 0, ',', '.') }}</b></td>
                            </tr>

                        

                        <!-- PERSEDIAAN -->
                            
                        <tr>
                            <td colspan="3"><b>PERSEDIAAN</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodePersediaan             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanPersediaan    = ['1.1501', '1.1502','1.1503','1.1504','1.1505','1.1506'];
                            @endphp

                            @if (in_array($kodePersediaan, $kodePerkiraanPersediaan)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirPersediaan, 0, ',', '.') }}</b></td>
                            </tr>

                        <!-- Pajak Bayar Dimuka : Pajak -->
                            
                        <tr>
                            <td colspan="3"><b>PAJAK</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodePajak             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanPajak    = ['1.1601', '1.1602','1.1603'];
                            @endphp

                            @if (in_array($kodePajak, $kodePerkiraanPajak)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirPajak, 0, ',', '.') }}</b></td>
                            </tr>

                    <!-- AT - Peralatan Kantor -->
                        
                        <tr>
                            <td colspan="3"><b>AKTIVA TETAP</b></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>AT - PERALATAN KANTOR</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodePK             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanPK    = ['1.2110','1.2120'];
                            @endphp

                            @if (in_array($kodePK, $kodePerkiraanPK)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirPK, 0, ',', '.') }}</b></td>
                            </tr>

                    <!-- AT - KENDARAAN -->

                        <tr>
                            <td colspan="3"><b>AT - KENDARAAN</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodeK             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanK    = ['1.2210','1.2220'];
                            @endphp

                            @if (in_array($kodeK, $kodePerkiraanK)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirK, 0, ',', '.') }}</b></td>
                            </tr>


                            <!-- AT LAINNYA -->
                        <tr>
                            <td colspan="3"><b>AT LAINNYA</b></td>
                        </tr>
                        @foreach ($neracaList as $s)
                            @php
                            $kodeL             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                            $kodePerkiraanL    = ['1.2410', '1.2320'];
                            @endphp

                            @if (in_array($kodeL, $kodePerkiraanL)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirL, 0, ',', '.') }}</b></td>
                            </tr>


                            <tr class="text-right">
                                <td></td>
                                <td><b>TOTAL AKTIVA</b></td>
                                <td><b>{{ number_format($sumFinalAktiva, 0, ',', '.') }}</b></td>
                            </tr>

                    <!-- Kewajiban Lancar -->

                        <tr>
                            <td colspan="3"><b>KEWAJIBAN LANCAR</b></td>
                        </tr>

                        @foreach ($neracaList as $s)
                            @php
                                $kodeKewajiban             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanKewajiban    = ['2.1001','2.1002','2.1003','2.1200', '2.1300', '2.1400', '2.1500','2.1600','2.1702','2.1703','2.1705','2.1706'];
                            @endphp

                            @if (in_array($kodeKewajiban, $kodePerkiraanKewajiban)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirKewajiban, 0, ',', '.') }}</b></td>
                            </tr>

                        <!-- Hutang Support Program -->

                        <tr>
                            <td colspan="3"><b>HUTANG SUPPORT PROGRAM</b></td>
                        </tr>

                        @foreach ($neracaList as $s)
                            @php
                                $kodeHSP             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanHSP    = ['2.1851'];
                            @endphp

                            @if (in_array($kodeHSP, $kodePerkiraanHSP)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirHSP, 0, ',', '.') }}</b></td>
                            </tr>


                        <!-- Hutang Pajak -->

                        <tr>
                            <td colspan="3"><b>HUTANG PAJAK</b></td>
                        </tr>

                        @foreach ($neracaList as $s)
                            @php
                                $kodeP             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanP    = ['2.1900','2.1901','2.1902','2.1903','2.1904','2.1905'];
                            @endphp

                            @if (in_array($kodeP, $kodePerkiraanP)) 
                                <tr>
                                    <td>{{ $s['perkiraan'] }}.{{ $s['sub_perkiraan'] }} {{ $s['nama_perkiraan'] }}</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                            
                        @endforeach

                            <tr class="text-right">
                                <td></td>
                                <td><b>>></b></td>
                                <td><b>{{ number_format($finalSumSaldoAkhirP, 0, ',', '.') }}</b></td>
                            </tr>
                            <tr class="text-right">
                                <td colspan="2"><b>TOTAL KEWAJIBAN</b></td>
                                <td><b>{{ number_format($sumFinalKewajiban, 0, ',', '.') }}</b></td>
                            </tr>

                            
                            <tr class="text-center">
                                <td colspan="3"><b>EKUITAS</b></td>

                            </tr>

                            @foreach ($neracaList as $s)
                            @php
                                $kodeSetoranModal             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanSetoranModal    = ['3.1000'];
                            @endphp

                            @if (in_array($kodeSetoranModal, $kodePerkiraanSetoranModal)) 
                                <tr>
                                    <td>Setoran Modal</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                                
                            @endforeach

                            @foreach ($neracaList as $s)
                            @php
                                $kodeDitahan             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanDitahan    = ['3.2000'];
                            @endphp

                            @if (in_array($kodeDitahan, $kodePerkiraanDitahan)) 
                                <tr>
                                    <td>Laba (Rugi) Ditahan</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                                
                            @endforeach


                            @foreach ($neracaList as $s)
                            @php
                                $kodeSebelumnya             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanSebelumnya    = ['3.3000'];
                            @endphp

                            @if (in_array($kodeSebelumnya, $kodePerkiraanSebelumnya)) 
                                <tr>
                                    <td>Laba (Rugi) Periode Sebelumnya</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                                
                            @endforeach

                            @foreach ($neracaList as $s)
                            @php
                                $kodeBerjalan             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
                                $kodePerkiraanBerjalan    = ['3.4000'];
                            @endphp

                            @if (in_array($kodeBerjalan, $kodePerkiraanBerjalan)) 
                                <tr>
                                    <td>Laba (Rugi) Periode Berjalan</td>
                                    <td class="text-right">{{ number_format($s['saldoAwal'], 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @endif

                                
                            @endforeach


                            <tr class="text-right">
                                <td colspan="2"><b>TOTAL EKUITAS</b></td>
                                <td><b>{{ number_format($sumFinalEkuitas, 0, ',', '.') }}</b></td>
                            </tr>

                            <tr class="text-right">
                                <td colspan="2"><b>TOTAL KEWAJIBAN  DAN EKUITAS</b></td>
                                <td><b>{{ number_format($sumKewajibanEkuitas, 0, ',', '.') }}</b></td>
                            </tr>

                            <tr class="text-right">
                                <td colspan="2"><b>BALANCED</b></td>
                                <td><b>{{ number_format($sumBalanced, 0, ',', '.') }}</b></td>
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