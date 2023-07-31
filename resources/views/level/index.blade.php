@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h4><b>Master Level</b></h4>
            </div>
            <div class="float-right">
                <a class="btn btn-success" href="{{ route('level.create') }}"><i class="fas fa-plus"></i> Tambah Level Baru</a>
            </div>
        </div>
    </div>
 
    @if($message = Session::get('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="row">
            <div>
                <p>{{ $message }}</p>
            </div>
            <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>     
    </div>
    @endif

    <div class="col">        
        <div class="card" style="padding: 20px;">
            <div class="col">
                    <div class="col-lg-12">
                        <table class="table table-hover table-bordered table-sm bg-light" id="example1"> 
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Kode Level 4</th>
                                <th class="text-center">Diskon + Add Discount %</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp
                            @foreach ($level as $j)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $j->level4 }}</td>
                                <td class="text-center">{{ $j->diskon }}</td>                               
                                <td class="text-center">
                                    <form action="{{ route('level.destroy',$j->id) }}" method="DELETE">

                                        <a class="btn btn-primary btn-sm" href="{{ route('level.edit',$j->id) }}"><i class="fas fa-edit"></i></a>
                                        <a class="btn btn-warning btn-sm" href=""><i class="fas fa-eye"></i></a>

                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <a class="btn btn-danger btn-sm" href="{{ route('level.destroy',$j->id) }}"><i class="fas fa-trash"></i></a>
                                    </form>
                                </td>
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

