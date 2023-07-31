@extends('welcome')
 
@section('content')
<div class="container">
    <div class="row pt-3">
        <div class="col-lg-12 margin-tb p-2">
            <div class="float-left">
                <div class="col">
                    <h2>Closing Account</h2>
                    <h4>Periode {{ $periode }}</h4>
                </div>
            </div>

            <div class="float-right">
                <a class="btn btn-success" href="{{ route('closing-account.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>
            
        </div>
    </div>
 
    @if($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <div class="card p-1">
        <div class="col">
                <div class="table-responsive">  
                    <table class="table table-hover table-bordered table-sm bg-light" id="dataTable">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">No</th> -->
                            <th class="text-center">Reff</th>
                            <th class="text-center">Perkiraan</th>
                            <th class="text-center">1</th>
                            <th class="text-center">2</th>
                            <th class="text-center">3</th>
                            <th class="text-center">4</th>
                            <th class="text-center">5</th>
                            <th class="text-center">6</th>
                            <th class="text-center">7</th>
                            <th class="text-center">8</th>
                            <th class="text-center">9</th>
                            <th class="text-center">10</th>
                            <th class="text-center">11</th>
                            <th class="text-center">12</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                        @php
                        $no=1;

                        @endphp
                        @foreach ($getClosingBulanan as $j)
                            
                                <tr>
                                    <td>{{ $j->perkiraan }}.{{ $j->sub_perkiraan }}</td>
                                    <td>{{ $j->nm_perkiraan }}</td>
                                    <td>{{ $j->saldo_bln01 }}</td>
                                    <td>{{ $j->saldo_bln02 }}</td>
                                    <td>{{ $j->saldo_bln03 }}</td>
                                    <td>{{ $j->saldo_bln04 }}</td>
                                    <td>{{ $j->saldo_bln05 }}</td>
                                    <td>{{ $j->saldo_bln06 }}</td>
                                    <td>{{ $j->saldo_bln07 }}</td>
                                    <td>{{ $j->saldo_bln08 }}</td>
                                    <td>{{ $j->saldo_bln09 }}</td>
                                    <td>{{ $j->saldo_bln10 }}</td>
                                    <td>{{ $j->saldo_bln11 }}</td>
                                    <td>{{ $j->saldo_bln12 }}</td>
                                </tr>

                        @endforeach
                    </tbody>

              
                </table>
                {!! $getClosingBulanan->appends(['periode' => $periode])->links('pagination::bootstrap-4') !!}

                </div>
        </div>
    </div>

        
</div> 
@endsection

@section('script')

@endsection