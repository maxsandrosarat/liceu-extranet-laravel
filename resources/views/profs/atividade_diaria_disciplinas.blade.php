@extends('layouts.app', ["current"=>"atividade"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            @if($tipo=='diaria')
            <h5 class="card-title">Atividades Diárias</h5>
            @elseif($tipo=='ionica')
            <h5 class="card-title">Atividades da Plataforma Iônica</h5>
            @else

            @endif
            @if(count($profDiscs)==0)
                <div class="alert alert-danger" role="alert">
                    Sem disciplinas cadastradas!
                </div>
            @else
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">Disciplinas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profDiscs as $disc)
                        <tr>
                            <td>
                                <a href="/prof/atividadeDiaria/{{$disc->disciplina_id}}/{{$tipo}}" class="btn btn-primary btn-lg btn-block">{{$disc->disciplina->nome}} (@if($disc->disciplina->ensino=='fund') Fundamental @else Médio @endif)</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @endif
        </div>
    </div>
@endsection