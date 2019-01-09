@extends('layouts.app')
@section('content')
    <br>
    <br>
    <br>
    <div class="container">
        <div align="center" class="row">
            <div align="center" class="col-sm">
                <a href="users/add/" class="">
                    <i class="material-icons">note_add</i>
                    Nuevo Usuario
                </a>
                <table id="views" class="table" >
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->lname}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <div align="center">
                                    <a href="users/edit/{{ $user->id }}" class="">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <a href="users/delete/{{ $user->id }}" class="">
                                        <i class="material-icons">delete</i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

