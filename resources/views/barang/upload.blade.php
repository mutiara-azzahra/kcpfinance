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

    <div class="card" style="padding: 30px;">
        <form action="" method="POST">
        
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Tambahkan File</strong>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="file" id="myFile" name="filename">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <div class="float-left">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan Data</button>
                    </div>
                </div>
            </div>
        
        </form>
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