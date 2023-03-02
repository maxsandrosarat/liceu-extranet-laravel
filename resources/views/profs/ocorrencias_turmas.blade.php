@extends('layouts.app', ["current"=>"home"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/prof/ocorrencias/disciplinas" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Ocorrências - Disciplina: {{$disciplina->nome}} (@if($disciplina->ensino=='fund') Fundamental @else Médio @endif)</h5>
            @if(count($turmaDiscs)==0)
                <div class="alert alert-danger" role="alert">
                    Sem turmas cadastradas!
                </div>
            @else
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">Turma(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($turmaDiscs as $turmaDisc)
                        <tr>
                            <td>
                                <a href="/prof/ocorrencias/{{$disciplina->id}}/{{$turmaDisc->turma->id}}" class="btn btn-primary btn-lg btn-block">{{$turmaDisc->turma->serie}}º{{$turmaDisc->turma->turma}}{{$turmaDisc->turma->turno}}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection