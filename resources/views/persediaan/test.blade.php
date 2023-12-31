@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 margin-tb p-3">
             <div class="float-left">
                <h4><b>Data Persediaan</b></h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('persediaan.filter') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>

        <div class="card" style="padding: 20px;">
            <div class="col">
                    <div class="col-lg-12">  
                        <table class="table table-hover table-bordered table-sm bg-light table-striped" id="example1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Area</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Persediaan Awal</th>
                                <th class="text-center">Pembelian AOP</th>
                                <th class="text-center">Pejualan</th>
                                <th class="text-center">Retur Terjual</th>
                                <th class="text-center">Persediaan Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp
                            @foreach ($tablePersediaan as $j)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $j->area_inv }}</td>
                                <td class="text-left"> {{ $j->bulan }} - {{ $j->tahun }}</td>
                                <td class="text-right"> {{ number_format($j->persediaan_awal, 0, ',', '.') }}</td>
                                <td class="text-right"> {{ number_format($j->pembelian, 0, ',', '.') }}</td>
                                <td class="text-right"> {{ number_format($j->modal_terjual, 0, ',', '.') }}</td>
                                <td class="text-right"> {{ number_format($j->retur_modal_terjual, 0, ',', '.') }}</td>
                                <td class="text-right"> {{ number_format($j->persediaan_akhir, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
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