@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Cantidad de Personas: {{$reservationsUser->count()}}
                </div>
                <div class="card-body">
                    Butacas:
                </div>
                <div class="container">
                    @for($row =1; $row <= 5; $row++)
                        <div class="row">
                            @for($col = 1; $col <= 10; $col++)
                                @if($reservationsUser->where('col', $col)->where('row', $row)->where('user_id',Auth::user()->id)->count() > 0)
                                    <div id="butaca{{$row}}{{$col}}" onclick="preButaca({{ $row }},{{ $col }})" data-target="#ModalAgregar" data-toggle="modal" data-target=".bd-example-modal-lg" align="center" class="col-sm card alert-warning">
                                        <i class="material-icons">&#xe637;</i>
                                        {{ $row }}-{{ $col }}
                                    </div>
                                @elseif($reservationsAll->where('col', $col)->where('row', $row)->count() > 0)
                                    <div id="butaca{{$row}}{{$col}}" onclick="notificar({{ $row }},{{ $col }})" data-target="#ModalButacaAjena" data-toggle="modal" data-target=".bd-example-modal-lg" align="center" class="col-sm card alert-danger">
                                        <i class="material-icons">&#xe637;</i>
                                        {{ $row }}-{{ $col }}
                                    </div>
                                @else
                                    <div id="butaca{{$row}}{{$col}}" onclick="preButaca({{ $row }},{{ $col }})" data-target="#ModalAgregar" data-toggle="modal" data-target=".bd-example-modal-lg" align="center" class="col-sm card alert-success">
                                        <i class="material-icons">&#xe637;</i>
                                        {{ $row }}-{{ $col }}
                                    </div>
                                @endif
                            @endfor
                        </div>
                    @endfor
                </div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalReservar">Reservar</button>
            </div>
        </div>
    </div>

    <!-- Modal Agregar -->
    <div class="modal fade" id="ModalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Butaca:</label>
                        <input type="text" class="form-control" id="butaca">
                        <input type="hidden" class="form-control" id="row">
                        <input type="hidden" class="form-control" id="col">
                    </div>
                </div>

                <div class="modal-footer">
                    <h5 class="modal-title" id="exampleModalLabel">Desea agregar esta Butaca para Reservar?</h5>
                    <button onclick="deleteButacas()" type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button onclick="setButacas()" type="button" class="btn btn-primary">Si</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Agregar -->

    <!-- Modal Reservar -->
    <div class="modal fade" id="ModalReservar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="{{ route('reservations') }}">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Butacas a Reservar:</label>
                                <select readonly="true" class="form-control" multiple="multiple" name="butacas[]" id="butacas">
                                    @foreach($reservationsUser as $reservationUser)
                                        <option selected value="{{$reservationUser->row .'-'.$reservationUser->col }}">{{'Butaca: '.$reservationUser->row .' - '.$reservationUser->col }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <h5 class="modal-title" id="exampleModalLabel">Desea Reservar?</h5>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Si') }}
                                </button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- Modal Reservar -->

    <!-- Modal Butaca Ajena -->
    <div class="modal fade" id="ModalButacaAjena" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Esta butaca esta reservada a otro Usuario</label>
                        <input type="text" class="form-control" id="butacaajena">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Butaca Ajena -->
</div>

@endsection
<script>

function notificar(row,col){
    $('#butacaajena').val('Fila: ' + row + ' Columna: ' + col);
}
function preButaca(row,col){
    $('#butaca').val('Fila: ' + row + ' Columna: ' + col);
    $('#row').val(row);
    $('#col').val(col);
}

function setButacas(){

    var row = $('#row').val();
    var col = $('#col').val();

    var nombreOption = row+'-'+col;
    $("#butacas option[value="+nombreOption+"]").remove();

    $('#butacas').append('<option value="'+ row +'-'+ col+'">' + 'Butaca: '+row+' - '+col+'</option>');
    $('#butaca'+row+col).removeClass( "col-sm card alert-success" ).addClass( "col-sm card alert-warning" );
    $('#butacas option' ).attr('selected', 'selected');
    $('#ModalAgregar').modal('hide');
}

function deleteButacas(){

    var row = $('#row').val();
    var col = $('#col').val();
    var nombreOption = row+'-'+col;
    $("#butacas option[value="+nombreOption+"]").remove();
    $('#butaca'+row+col).removeClass( "col-sm card alert-warning" ).addClass( "col-sm card alert-success" );

}

</script>
