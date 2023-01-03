@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
    <a href="/outro/notas/{{$ano}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    <h5 class="card-title">Painel de Notas {{$nota->descricao}} - {{$turma->serie}}º ANO {{$turma->turma}} - {{$nota->bimestre}}º Bimestre - Ano: {{$nota->ano}}</h5>
        <div class="table-responsive-xl">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Alunos</th>
                        <th>Disciplinas</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                @php
                    $qtdDiscs = count($disciplinas);
                @endphp
                <tbody>
                    @foreach ($alunos as $aluno)
                    @php
                        $pertence = 0;
                    @endphp
                    <tr>
                        <td rowspan="{{$qtdDiscs+1}}">{{$aluno->name}}</td>
                    </tr>
                        @foreach($disciplinas as $disciplina)
                        <tr>
                            <td>{{$disciplina->nome}}</td>
                            @php
                                $pertence = 0;
                            @endphp
                            @foreach ($lancamentos as $lancamento)
                                @if($aluno->id == $lancamento->aluno->id && $disciplina->id==$lancamento->disciplina->id)
                                    @php
                                        $pertence ++;
                                    @endphp
                                    @if($lancamento->nota=="")
                                        <td style="color:red; text-align: center;"> Pendente
                                    @else
                                        <td>@if($lancamento->nota>=7)<span class="badge rounded-pill bg-primary"><b>{{$lancamento->nota}}</b></span> @else <span class="badge rounded-pill bg-danger"><b>{{$lancamento->nota}}</b></span> @endif
                                        
                                    @endif
                                @endif
                            @endforeach
                            @if($pertence==0)
                            <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td>
                            @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function getValor(campo){
        var valor = id(campo).value.replace(',','.');
        var length = valor.length;
        if(length>0){
            id(campo).value = parseFloat(valor);
        } else {
            $('#'+ campo +'').val("");
        }
    }
</script>
@endsection
