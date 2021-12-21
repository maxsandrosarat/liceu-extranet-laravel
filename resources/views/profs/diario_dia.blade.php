@extends('layouts.app', ["current"=>"diario"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    @if(session('mensagem'))
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <p>{{session('mensagem')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col" style="text-align: left">
                            <a href="/prof/diario/{{$disc->id}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
                        </div>
                        <div class="col" style="text-align: right">
                           
                        </div>
                    </div>
                    <br/>
                    <h5 class="card-title">Diário - {{$disc->nome}} - {{$turma->serie}}º ANO {{$turma->turma}}</h5>
                    <form method="GET" action="/prof/diario">
                        @csrf
                        <input type="hidden" name="disciplina" value="{{$disc->id}}">
                        <input type="hidden" name="turma" value="{{$turma->id}}">
                        <div class="col-sm-3 form-floating">
                            <input class="form-control" type="date" name="data" value="{{date("Y-m-d")}}" required>
                            <label for="data">Selecione o Dia</label>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Lançar Diário</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection