@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h4><b>Persediaan Bulan Januari 2023</b></h4>
            </div>
            <div class="float-right">
                <!-- <a class="btn btn-success" href=""><i class="fas fa-plus"></i> Tambah Persediaan Baru</a>
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

                    <div class="col-lg-12">
                        
                        <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Jumlah</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-left">Persediaan Awal Januari 2023</td>
                                <td class="text-right">{{ number_format($sumTotalPersediaan, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="text-left">Pembelian Januari 2023</td>
                                <td class="text-right">{{ number_format($finalTotalPembelian, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="text-left">Retur Pembelian AOP Januari 2023</td>
                                <td class="text-right">{{ number_format($finalTotalReturAOP, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="text-left">Penjualan Januari 2023</td>
                                <td class="text-right">{{ number_format($finalTotalPenjualan, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="text-left">Retur Penjualan Januari 2023</td>
                                <td class="text-right">{{ number_format($finalTotalRetur, 0, ',', '.') }}</td>
                            </tr>

                            <tr>
                                <td class="text-left"><b>Persediaan Akhir Januari 2023</b></td>
                                <td class="text-right"><b>{{ number_format($finalPersediaan, 0, ',', '.') }}</b></td>
                            </tr>

                        </tbody>
                    </table>
                    
                    </div>
                </div>

            </div>
        </div>
        
        <div class="card" style="padding: 20px;">
            <div class="col">
                    <div class="col-lg-12">
                        <table class="table table-hover table-bordered table-sm bg-light" id="example1"> 
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp
                            @foreach ($persediaan as $j)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td> Persediaan Awal: {{ $j->part_no }}</td>
                                <td class="text-center"> {{ $j->stock_akhir }}</td>
                                <td class="text-right"> {{ number_format($j->amt_stock_akhir, 0, ',', '.') }} </td>
                                <td class="text-center">   
                                    <a class="btn btn-info btn-sm" href="{{ route('persediaan.detail',$j->id) }}"><i class="fas fa-info"></i></a>
                                </td>

                                
                                @foreach($j->invoice as $detail)
                                    @if($detail->billingDocument_date >= '2023-01-01' && $detail->billingDocument_date <= '2023-01-31')
                                        <tr>
                                            <td></td>
                                            <td>Pembelian tanggal {{ \Carbon\Carbon::parse($detail->billingDocument_date)->format('d-m-y') }}</td>
                                            <td class="text-center">{{ $detail->qty }}</td>
                                            <td class="text-right">{{ number_format($detail->amount, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach

                                @foreach($j->retur as $detail)
                                    @if($detail->crea_date >= '2023-01-01' && $detail->crea_date <= '2023-01-31')
                                        <tr>
                                            <td></td>
                                            <td>Retur {{ $detail->crea_date}}</td>
                                            <td class="text-center">{{ $detail->qty }}</td>
                                            <td class="text-right">{{ number_format($detail->nominal_total, 0, ',', '.') }}</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
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
    </script>

@endsection