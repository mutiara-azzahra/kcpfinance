@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <h2>Data Debet Barang, Persediaan</h2>
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
        <div class="card-body">
            <form action="" method="">
                <!-- @csrf -->
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
    </div>

   

    <div class="card" style="padding: 20px;">
        <div class="col">
                <div class="col-lg-12 pb-5">  
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ route('fifo.create') }}"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>

                <div class="col-lg-12">  
                    <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode fifo</th>
                            <th>Nama fifo</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no=1;
                        @endphp
                        @foreach ($fifo as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td> {{ $p->kode_prp }}</td>
                            <td> {{ $p->fifo }}</td>
                            <td class="text-center">
                                <form action="{{ route('fifo.destroy',$p->kode_prp) }}" method="POST" id="form_delete">            
                                    <a class="btn btn-primary btn-sm" href="{{ route('fifo.edit',$p->kode_prp) }}"><i class="fas fa-edit"></i></a>
                
                                    <!-- @csrf
                                    @method('DELETE') -->
                
                                    <a class="btn btn-danger btn-sm" onclick="Hapus('{{ $p->kode_prp }}')" ><i class="fas fa-trash"></i></a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $fifo->links('pagination::bootstrap-4') !!}
                </div>


             
        
            
        </div>
    </div>

        
</div> 
@endsection

@section('script')

@endsection