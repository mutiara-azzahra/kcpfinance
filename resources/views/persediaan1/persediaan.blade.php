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
                        <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Persediaan Awal</th>
                                <th class="text-center">Persediaan Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp
                            @foreach ($getDetailPersediaanIndex as $j)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-left"> {{ $j->bulan }} - {{ $j->tahun }}</td>
                                <td class="text-right"> {{ number_format($j->persediaan_awal, 0, ',', '.') }}</td>
                                <td class="text-right"> {{ number_format($j->persediaan_akhir, 0, ',', '.') }}</td>
                                
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