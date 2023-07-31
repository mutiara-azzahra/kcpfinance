@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h5><b>Persediaan Awal</b></h5>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('persediaan.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    <div class="col-lg-12">  
                        <table class="table table-hover table-bordered table-sm bg-light" id="example1">
                        <thead>
                            <tr>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Part No</th>
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Amount</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp

                            @foreach ($persediaanAwal as $p)
                            <tr>
                                <td> Persediaan Awal</td>
                                <td>{{ $p->part_no }}</td>
                                <td></td>
                                <td class="text-right">{{ $p->stock_akhir }}</td>
                                <td class="text-right">{{ number_format($p->amt_stock_akhir, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach

                            @foreach ($detailPersediaan as $j)
                            <tr>
                                
                                <td> Pembelian {{ $j->header->billingDocument_date }}</td>
                                <td> {{ $j['part_no'] }}</td>
                                <td> {{ $j['invoice_aop'] }}</td>
                                <td class="text-right"> {{ $j['qty'] }}</td>
                                <td class="text-right"> {{  number_format($j['amount_ex_disc'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                            @foreach ($detailRetur as $r)
                            <tr>
                                <td> Retur {{ $r['crea_date'] }}</td>
                                <td> {{ $r['part_no'] }}</td>
                                <td> {{ $r['invoice_aop'] }}</td>
                                <td class="text-right"> {{ $r['qty'] }}</td>   
                                <td class="text-right"> {{  number_format($r['nominal_total'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan='3' class="text-center"><b>Total Persediaan</b></td>
                                <td class="text-right"><b>{{ number_format($sumQtyPersediaanAkhir, 0, ',', '.') }}</b></td>
                                <td class="text-right"><b>{{ number_format($sumAmountPersediaanAwal, 0, ',', '.') }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
                <div class="col-lg-6">
                    <div class="row pt-3">
                        <div class="col-lg-6 margin-tb p-3">
                            <div class="float-left">
                                <h5><b>Riwayat Penjualan HET</b></h5>
                            </div> 
                        </div>
                    </div>

                    <div class="col">
                        <div class="card" style="padding: 20px;">
                                    <div class="col-lg-12">  
                                        <table class="table table-hover table-bordered table-sm bg-light" id="example1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Tanggal</th>
                                                <th class="text-center">Invoice</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Hrg/pcs</th>
                                                <th class="text-center">Jumlah</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $no=1;

                                            @endphp

                                            @foreach ($terjual as $t)

                                            <tr>
                                                <td>{{ $t->crea_date }}</td>
                                                <td>{{ $t->noinv }}</td>
                                                <td class="text-right">{{ number_format($t->qty, 0, ',', '.') }}</td>
                                                 <td class="text-right">{{ number_format($t->hrg_pcs, 0, ',', '.') }}</td>
                                                <td class="text-right">{{ number_format($t->nominal_total, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach

                                            <tr>
                                                <td colspan='2' class="text-center"><b>Total Terjual</b></td>
                                                <td class="text-right"><b>{{ $sumQtyTerjual }}</b></td>
                                                <td class="text-right" colspan='2'><b>{{  number_format($sumTotalTerjual, 0, ',', '.')  }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="col-lg-6">
                    <div class="row pt-3">
                        <div class="col-lg-6 margin-tb p-3">
                            <div class="float-left">
                                <h5><b>Harga Penjualan FIFO</b></h5>
                            </div> 
                        </div>
                    </div>

                    <div class="col">
                        <div class="card" style="padding: 20px;">
                                    <div class="col-lg-12">  
                                        <table class="table table-hover table-bordered table-sm bg-light" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="text-center">Invoice</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Hrg/pcs</th>
                                                <th class="text-center">Jumlah</th>
                                                
                                            </tr>
                                        </thead>

                                        @if (isset($trx_fifo[1]))
                                        <tbody>
                                               
                                            @php

                                            $no = 1;
                                            
                                                $terjualAwal    = 0;
                                                $selanjutnya    = 0;
                                                $selanjutnya1   = 0;
                                                $selanjutnya2   = 0;
                                                $nextHarga      = $trx_fifo[1]['amount_ex_disc'] / $trx_fifo[1]['qty'];
                                            @endphp

                                            @foreach ($terjual as $t)
                                                    <tr>
                                                        <td class="text-center">{{ $no++ }}</td>
                                                        <td>{{ $t->noinv }}</td>
                                                        
                                                                @php
                                                                    $terjualAwal += $t->qty;
                                                                @endphp
                                                        <td class="text-right">{{ number_format($t->qty, 0, ',', '.') }}</td>
                                                        @if($terjualAwal > $persediaanAwalFifo)
                                                                @if($selanjutnya > $trx_fifo[1]['qty'])
                                                                    <td>{{ $selanjutnya1 }}</td>
                                                                @php
                                                                    $selanjutnya1 += $t->qty;
                                                                @endphp

                                                                @else
                                                                    <td>{{ $selanjutnya }}</td>
                                                                @endif
                                                                
                                                                @php
                                                                    $selanjutnya += 0;
                                                                @endphp
                                                        @else

                                                        @endif

                                                        @if($terjualAwal < $persediaanAwalFifo)
                                                            <td class="text-right">{{ number_format($trx_fifo[0]['harga_ip'], 0, ',', '.') }}</td>
                                                            <td class="text-right">{{ number_format($t->qty * $trx_fifo[0]['harga_ip'], 0, ',', '.') }}</td>
                                                        @else
                                                            @if($selanjutnya < $trx_fifo[1]['qty'])
                                                                <td class="text-right">{{ number_format($trx_fifo[1]['amount_ex_disc']/$trx_fifo[1]['qty'], 0, ',', '.') }}</td>
                                                                <td class="text-right">{{ number_format(($t->qty * $trx_fifo[1]['amount_ex_disc']/$trx_fifo[1]['qty']), 0, ',', '.') }}</td>
                                                                    @php
                                                                        $selanjutnya += $t->qty;
                                                                    @endphp

                                                                    @php
                                                                        $selanjutnya2 = 0;
                                                                    @endphp
                                                            @else
                                                                @if($selanjutnya2 < $trx_fifo[1]['qty'])
                                                                <td class="text-right">{{ number_format(($trx_fifo[2]['amount_ex_disc']/$trx_fifo[2]['qty']), 0, ',', '.') }}</td>
                                                                <td class="text-right">{{ number_format(($t->qty * $trx_fifo[2]['amount_ex_disc']/$trx_fifo[2]['qty']), 0, ',', '.') }}</td>
                                                                @endif
                                                                    @php
                                                                        $selanjutnya2 += $t->qty;
                                                                    @endphp
                                                            @endif
                                                        @endif
                                                    </tr>
                                                @php
                                                    $terjualAwal += $t->qty;
                                                @endphp
                                            @endforeach
                                        @endif

                                            <tr>
                                                <td colspan='1' class="text-center"><b>Total Terjual</b></td>
                                                 <td class="text-right"><b>{{ $sumQtyTerjual }}</b></td>
                                                 <td class="text-right"><b>{{ $sumQtyTerjual }}</b></td>
                                            </tr>
                                        </tbody>

                                        
                                    </table>
                                    </div>
                                </div>
                            </div>
                </div>
            
                <div class="col">
                    <div class="row pt-3">
                        <div class="col-lg-12 margin-tb p-3">
                            <div class="float-left">
                                <h5><b>Persediaan Akhir</b></h5>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="padding: 20px;">
                        <div class="col">
                                <div class="col-lg-12">  
                                    <table class="table table-hover table-bordered table-sm bg-light" id="myTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left">Persediaan Awal</td>
                                            <td class="text-right">{{ number_format($sumQtyPersediaanAkhir, 0, ',', '.') }}</td>
                                            <td class="text-right">{{ number_format($sumAmountPersediaanAwal, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Total Terjual Bulan Januari</td>
                                            <td class="text-right">{{ number_format($sumQtyTerjual, 0, ',', '.') }}</td>
                                            <td class="text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        
    </div>
</div>
@endsection

@section('script')

<script>
      $(function () {
        $("#example1")
          .DataTable({
            paging: true,
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
          })
          .buttons()
          .container()
          .appendTo("#example1_wrapper .col-md-6:eq(0)")
                  
        $("#example2").DataTable({
          paging: true,
          lengthChange: false,
          searching: false,
          ordering: true,
          info: true,
          autoWidth: false,
          responsive: true,
        });
      });
$(document).ready(function() {
  $('#myTable').DataTable();
});
</script>

@endsection