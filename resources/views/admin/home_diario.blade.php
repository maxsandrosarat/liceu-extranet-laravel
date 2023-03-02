@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col" style="text-align: left">
                        <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
                        </div>
                        <div class="col" style="text-align: right">
                            <a type="button" class="btn btn-info" href="/admin/diario/relatorio">Relátorios</a>
                        </div>
                    </div>
                    <br/>
                    <h5 class="card-title">Diário</h5>
                    @if(session('mensagem'))
                        <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                            {{session('mensagem')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form class="row g-3" method="GET" action="/admin/diario/consulta">
                        @csrf
                        <div class="col-sm form-floating">
                            <select class="form-select" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                @foreach ($turmas as $turma)
                                <option value="{{$turma->id}}">{{$turma->serie}}º{{$turma->turma}}{{$turma->turno}}</option>
                                @endforeach
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-sm form-floating">
                            <input class="form-control" type="date" name="data" value="{{date("Y-m-d")}}" required>
                            <label for="data">Selecione o Dia</label>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection