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

                    You are logged in!
                </div>

                <div class="container">
                    @for($row =1; $row <= 5; $row++)
                        <div class="row">
                            @for($col = 1; $col <= 10; $col++)
                                <div align="center" class="col-sm card alert-success">
                                    <i class="material-icons">&#xe637;</i>
                                    {{ $row }}-{{ $col }}
                                </div>
                            @endfor
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
