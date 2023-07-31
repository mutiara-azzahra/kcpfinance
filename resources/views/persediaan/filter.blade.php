@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 margin-tb p-3">
             <div class="float-left">
                <h4><b>Proses Persediaan</b></h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('persediaan.view') }}"><i class="fas fa-eye"></i> Lihat Nilai Persediaan</a>
            </div>
        </div>
    </div>
        <div class="card" style="padding: 10px;">
            <div class="card-body">
                <strong>Tata Cara Proses Nilai Persediaan</strong><br>
                <ul>
                    <li>Dilakukan pada tanggal 31 sebanyak <strong>1 x</strong> dalam 1 bulan</li>
                    <li>Apabila sudah diproses untuk dua area, dapat dilihat hasilnya pada tombol Lihat Nilai Persediaan</li>
                </ul>
            </div>
        </div>
        <div class="card" style="padding: 20px;">
                <div class="col">
                    <div class="card-body">
                        <form action="{{ route('persediaan.process') }}"  method="GET">
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
                                <button class="btn btn-warning" type="submit"><i class="fas fa-check"></i> Proses</button>
                            </div>
                        </div>
                </div>
            </form>
        </div>

</div>
@endsection

@section('script')


@endsection