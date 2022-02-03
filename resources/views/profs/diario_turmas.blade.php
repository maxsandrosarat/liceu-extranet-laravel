@extends('layouts.app', ["current"=>"diario"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/prof/diario/disciplinas" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Diário</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(count($profTurmas)==0)
                <div class="alert alert-danger" role="alert">
                    Sem turmas cadastradas!
                </div>
            @else
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">Disciplinas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profTurmas as $turmaDisc)
                        @if($turmaDisc->turma->ativo==true)
                        <tr>
                            <td>
                                <a href="/prof/diario/{{$discId}}/{{$turmaDisc->turma->id}}" class="btn btn-primary btn-lg btn-block">{{$turmaDisc->turma->serie}}º ANO {{$turmaDisc->turma->turma}} (@if($turmaDisc->turma->turno=='M') Matutino @else @if($turmaDisc->turma->turno=='V') Vespertino @else Noturno @endif @endif)</a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection