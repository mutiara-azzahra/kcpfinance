@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h3><b>Buku Besar</b></h3>
            </div>
            <div class="float-right">
                <!-- <a class="btn btn-success" href=""><i class="fas fa-plus"></i> Tambah Buku Besar Baru</a>
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
                    <div class="float-left p-3 col-md-12">
                        <h4>Filter</h4>
                    </div>

                    <div class="card-body">
                        <form action=""  method="GET">
                            <!-- @csrf -->
                            <div class="col">


                                <div class="form-group">
                                    <label>Minimal</label>
                                    <select class="form-control select2" style="width: 100%">
                                        <option selected="selected">Alabama</option>
                                        <option>Alaska</option>
                                        <option>California</option>
                                        <option>Delaware</option>
                                        <option>Tennessee</option>
                                        <option>Texas</option>
                                        <option>Washington</option>
                                    </select>
                                </div>
                                

                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="">Tanggal Awal</label>
                                        <input type="date" name="tanggal_awal" id="" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="">Tanggal Akhir</label>
                                        <input type="date" name="tanggal_akhir" id="" class="form-control" placeholder="">
                                    </div>
                                </div>

                                
                            </div>
                    </div>
                    <div class="float-right p-3">
                            <button class="btn btn-warning" type="submit"><i class="fa-solid fa-arrows-rotate"></i> Proses</button>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection

@section('script')

@endsection