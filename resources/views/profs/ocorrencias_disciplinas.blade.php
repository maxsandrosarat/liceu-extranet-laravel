@extends('layouts.app', ["current"=>"ocorrencias"])

@section('body')
    <div class="card border">
        <div class="card-body">
        <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
            <h5 class="card-title">Ocorrências - Disciplinas</h5>
            @if(count($profDiscs)==0)
                <div class="alert alert-danger" role="alert">
                    Sem disciplinas cadastradas!
                </div>
            @else
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">Disciplina(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profDiscs as $disc)
                        <tr>
                            <td>
                                <a href="/prof/ocorrencias/{{$disc->disciplina_id}}" class="btn btn-primary btn-lg btn-block">{{$disc->disciplina->nome}} (@if($disc->disciplina->ensino=='fund') Fundamental @else Médio @endif)</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
@endsection