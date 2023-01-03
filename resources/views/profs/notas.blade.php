@extends('layouts.app', ["current"=>"notas"])

@section('body')
<div class="card border">
    <div class="card-body">
    <a href="/prof/notas/{{$ano}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    <h5 class="card-title">Painel de Notas {{$nota->descricao}} - {{$turma->serie}}º ANO {{$turma->turma}} - {{$nota->bimestre}}º Bimestre - Ano: {{$nota->ano}}</h5>
        <div class="table-responsive-xl">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="2" style="white-space: nowrap; text-align: center; vertical-align: middle;">Alunos</th>
                        <th colspan="{{count($profDiscs)}}">Disciplinas</th>
                    </tr>
                    <tr>
                        @foreach($profDiscs as $profDisc)
                        <th>{{$profDisc->disciplina->nome}}@if($profDisc->disciplina->ensino=="fund") (Fund) @else @if($profDisc->disciplina->ensino=="medio") (Médio) @endif @endif</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alunos as $aluno)
                    @php
                        $pertence = 0;
                    @endphp
                    <tr>
                        <td>{{$aluno->name}}</td>
                        @foreach($profDiscs as $profDisc)
                            @php
                                $pertence = 0;
                            @endphp
                            @foreach ($lancamentos as $lancamento)
                                @if($aluno->id == $lancamento->aluno->id && $profDisc->disciplina->id==$lancamento->disciplina->id)
                                    @php
                                        $pertence ++;
                                    @endphp
                                    @if($lancamento->nota=="")
                                        <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar{{$lancamento->id}}"><i class="material-icons md-18">cloud_upload</i></button>
                                    @else
                                        <td>@if($lancamento->nota>=7)<span class="badge rounded-pill bg-primary"><b>{{$lancamento->nota}}</b></span> @else <span class="badge rounded-pill bg-danger"><b>{{$lancamento->nota}}</b></span> @endif<br/>
                                        <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar{{$lancamento->id}}"><i class="material-icons md-18">edit</i></button> <a type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{$lancamento->id}}"><i class="material-icons md-18 white">delete</i></a></td>
                                        <!-- Modal Deletar -->
                                        <div style="text-align: center;" class="modal fade" id="exampleModalDelete{{$lancamento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Zerar Nota {{$nota->descricao}} - {{$lancamento->disciplina->nome}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>ALuno(a): {{$aluno->name}}</h4>
                                                        <h5>Tem certeza que deseja zerar essa nota?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <a href="/prof/notas/zerar/{{$lancamento->id}}" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Zerar">Zerar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <!-- Modal Anexar -->
                                    <div style="text-align: center;" class="modal fade" id="exampleModalAnexar{{$lancamento->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Lançar Nota {{$nota->descricao}} - {{$lancamento->disciplina->nome}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="/prof/notas/lancar/{{$lancamento->id}}">
                                                    <h4>Aluno(a): {{$aluno->name}}</h4>
                                                    @csrf
                                                    <div class="col-12 input-group mb-3">
                                                        <label for="nota{{$lancamento->id}}" class="input-group-text">Nota</label>
                                                        <input class="form-control" type="text" id="nota{{$lancamento->id}}" name="nota" value="{{$lancamento->nota}}" onblur="getValor('nota{{$lancamento->id}}')" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-outline-primary">Lançar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
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
