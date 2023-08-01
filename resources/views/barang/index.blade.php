@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h4><b>Master Barang</b></h4>
            </div>
            <div class="float-right">
                <a class="btn btn-warning" href="{{ route('barang.viewUpload')}}"><i class="fas fa-upload"></i> Import DBP Barang</a>
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
                    <div class="col-lg-12">
                        <table class="table table-hover table-bordered table-sm bg-light" id="example1"> 
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Part No</th>
                                <th class="text-center">Level4</th>
                                <th class="text-center">Supplier</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no=1;

                            @endphp
                            @foreach ($barang as $j)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $j->part_no }}</td>
                                <td>{{ $j->level->level4 }}</td>
                                <td>{{ $j->part->kode }}</td>
                               
                                <td class="text-center">
                                    <a class="btn btn-primary btn-sm" href="{{ Route('barang.detail',$j->id) }}"><i class="fas fa-info"></i></a>
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