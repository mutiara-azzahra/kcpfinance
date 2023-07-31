@extends('welcome')
 
@section('content')

<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <h2>Tambah fifo</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('fifo.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Maaf!</strong> Ada yang salah<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="padding: 30px;">
        <form action="{{ route('fifo.store') }}" method="POST">
            <!-- @csrf -->
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Keterangan</strong>
                        <input type="text" name="fifo" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Kode Gudang</strong>
                        <input type="text" name="kd_gudang" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Part No</strong>
                        <input type="text" name="part_no" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Qty</strong>
                        <input type="text" name="qty" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Debet</strong>
                        <input type="text" name="debet" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Kredit</strong>
                        <input type="text" name="kredit" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Beli Qty</strong>
                        <input type="text" name="beli_qty" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Beli Harga</strong>
                        <input type="text" name="beli_harga" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Beli Total</strong>
                        <input type="text" name="beli_total" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Hpp Qty</strong>
                        <input type="text" name="hpp_qty" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Hpp Harga</strong>
                        <input type="text" name="hpp_harga" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Hpp Total</strong>
                        <input type="text" name="hpp_total" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Perssediaan Qty</strong>
                        <input type="text" name="persediaan_qty" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Persediaan Harga</strong>
                        <input type="text" name="persediaan_harga" class="form-control" placeholder="Nama fifo">
                    </div>
                    <div class="form-group">
                        <strong>Persediaan Total</strong>
                        <input type="text" name="persediaan_total" class="form-control" placeholder="Nama fifo">
                    </div>

                </div> 
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <div class="float-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>
                    </div>
                </div>
            </div>
        
        </form>
    </div>
</div>

@endsection