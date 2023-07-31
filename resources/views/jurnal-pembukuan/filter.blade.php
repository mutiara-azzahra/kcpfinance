@extends('welcome')
 
@section('content')
<div class="container" style="padding: 10px;">
    <div class="row mt-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Cetak Rekap Transaksi Pembayaran</h2>
                <h4>Pilih Tanggal</h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('jurnal.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
    <!-- <div class="card" style="padding: 20px;">
        <div class="card-body">
            <form action="" method="">
                @csrf
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="date" name="" id="" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" name="" id="" class="form-control" placeholder="">
                </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-warning" href=""><i class="fas fa-print"></i> Cetak Data</button>
        </div>
            </form>
    </div> -->
</div>
@endsection

@section('script')

@endsection