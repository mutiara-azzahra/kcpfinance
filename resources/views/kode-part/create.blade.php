@extends('welcome')

@section('content')
<div class="container" style="padding: 20px; padding-bottom: 30px;">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h4><b>Tambah Data Kode Part</b></h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('kode-part.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
    
    @if ($errors->any())
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
        <form action="{{ route('kode-part.store') }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="POST">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Kode Part</strong>
                        <input type="text" name="kode" class="form-control" placeholder="Masukkan Nama Kode">
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