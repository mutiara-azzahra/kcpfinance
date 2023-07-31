@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-3">
            <div class="float-left">
                <h4><b>Master Barang</b></h4>
            </div>
            <div class="float-right">
                <!-- <a class="btn btn-success" href=""><i class="fas fa-plus"></i> Tambah Persediaan Baru</a>
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
      <!-- <div class="card" style="padding: 20px;">
        <div class="col"> -->
            <!-- <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Bulan</label>
                      <select class="form-control select2" style="width: 100%">
                        <option selected="selected">-- Pilih Bulan --</option>
                        <option>Januari</option>
                        <option>Februari</option>
                      </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Tahun</label>
                      <select class="form-control select2" style="width: 100%">
                        <option selected="selected">-- Pilih Tahun --</option>
                        <option>2023</option>
                      </select>
                    </div>
                </div>
          </div> -->

          <!-- <div class="float-right pt-2">
            <button class="btn btn-warning" type="submit"><i class="fas fa-eye"></i> Tampil</button>
          </div> -->
        <!-- </div>   
      </div> -->
        
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
                                    <a class="btn btn-warning btn-sm" href="{{ Route('barang.detail',$j->id) }}"><i class="fas fa-eye"></i></a>
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