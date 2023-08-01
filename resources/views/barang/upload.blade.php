@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h4><b>Upload Harga DBP</b></h4>
            </div>
             <div class="float-right">
                <a class="btn btn-success" href="{{ Route('barang.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                        <div class="row">
                            <div class="col-md-12">
                                <form action="">
                                    <div class="row">
                                        <input type="file" id="myFile" name="filename">
                                        <input type="submit">
                                    </div>
                                </form>
                            </div>
                        </div>
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