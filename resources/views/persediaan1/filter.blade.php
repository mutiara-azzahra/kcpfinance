@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 margin-tb p-3">
             <div class="float-left">
                <h4><b>Proses Persediaan</b></h4>
            </div>
            <!-- <div class="float-right">
                <a class="btn btn-success" href="{{ route('persediaan.filter') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div> -->
        </div>
    </div>
        <div class="card" style="padding: 20px;">
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('persediaan.index') }}"  method="GET">
                            <!-- @csrf -->
                            <div class="row">
                                <div class="form-group col-4">
                                    <label for="">Pilih Area</label>
                                    <select name="area_inv" class="form-control mr-2">
                                        <option value="">-- Pilih Area --</option>
                                            <option value="KS">Kal-Sel</option>
                                            <option value="KT">Kal-Teng</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Tanggal Awal</label>
                                    <input type="date" name="tanggal_awal" id="" class="form-control" placeholder="">
                                </div>
                                <div class="form-group col-4">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" id="" class="form-control" placeholder="">
                                </div>
                            </div>

                            <div class="float-right pt-2">
                                <button class="btn btn-success" type="submit"><i class="fas fa-check"></i> Proses</button>
                            </div>
                        </div>
                </div>
            </form>
        </div>

        <div class="card" style="padding: 20px;">
            <div class="col">
                    <div class="col-lg-12 margin-tb p-3">
                        <div class="float-left">
                            <h4>Data Persediaan</h4>
                        </div>
                    </div>

                    <div class="col-lg-12">  
                        <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Area</th>
                                <th class="text-center">Persediaan Awal</th>
                                <th class="text-center">Persediaan Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp
                            @foreach ($getDetailsPersediaan as $j)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-left"> {{ $j->bulan }} - {{ $j->tahun }}</td>
                                <td class="text-left"> {{ $j->area_inv }}</td>
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