@extends('layouts.app', ["current"=>"diario"])

@section('body')
    <div class="card border">
        <div class="card-body bg-light">
            <a href="/prof/diario/{{$disciplina->id}}/{{$turma->id}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h3 class="card-title" style="text-align: center;">Diário de Turma</h3>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @foreach ($diarios as $diario)
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h5>Disciplina: {{$diario->disciplina->nome}}</h5>
                        <h5>Turma: {{$diario->turma->serie}}º ANO {{$diario->turma->turma}}</h5>
                        @php
                        $diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
                        $diasemana_numero = date('w', strtotime($diario->dia)); 
                        @endphp
                        <h5>Dia: {{date("d/m/Y", strtotime($diario->dia))}} ({{$diasemana[$diasemana_numero]}})</h5>
                        <div class="row">
                            <div class="col" style="text-align: left">
                                <a type="button" @if($diario->conferido===0) class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Aguardando conferência dos lançamentos pela Coordenação" @else class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Conferência concluída pela Coordenação" @endif>
                                    <b>@if($diario->conferido===0)<i class="material-icons md-18 red">highlight_off</i> NÃO CONFERIDO @else <i class="material-icons md-18 green">check_circle</i> CONFERIDO @endif</b>
                                </a>
                            </div>
                            <div class="col" style="text-align: right">
                                <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDeleteDia{{$diario->id}}" data-toggle="tooltip" data-placement="left" title="Excluir"><i class="material-icons md-18">delete</i></button></td>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="exampleModalDeleteDia{{$diario->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Diário Nº {{$diario->id}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Tem certeza que deseja excluir esse diário?</h5>
                                            <p>Não será possivel reverter esta ação.</p>
                                            <form action="/prof/diario/apagar" method="POST">
                                                @csrf
                                                <input type="hidden" name="ocorrencia" value="{{$diario->id}}" required>
                                                <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Excluir Diário">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <form id="form-diario" class="row g-3" method="POST" action="/prof/diario">
                            @csrf
                            <input type="hidden" name="diario" value="{{$diario->id}}">
                            <b>
                            <div class="col-auto form-floating">
                                <select class="form-select" id="tempo" name="tempo" required>
                                    @if($diario->tempo=="")
                                    <option value="">Selecione o tempo</option>
                                    <option value="1">1º Tempo</option>
                                    <option value="2">2º Tempo</option>
                                    <option value="3">3º Tempo</option>
                                    <option value="4">4º Tempo</option>
                                    <option value="5">5º Tempo</option>
                                    @if($disciplina->ensino=="medio")
                                    <option value="6">6º Tempo</option>
                                    @endif
                                    @else
                                    <option value="{{$diario->tempo}}">{{$diario->tempo}}º Tempo</option>
                                    @if($diario->tempo==1)
                                        <option value="2">2º Tempo</option>
                                        <option value="3">3º Tempo</option>
                                        <option value="4">4º Tempo</option>
                                        <option value="5">5º Tempo</option>
                                        @if($disciplina->ensino=="medio")
                                        <option value="6">6º Tempo</option>
                                        @endif
                                    @else
                                        @if($diario->tempo==2)
                                            <option value="1">1º Tempo</option>
                                            <option value="3">3º Tempo</option>
                                            <option value="4">4º Tempo</option>
                                            <option value="5">5º Tempo</option>
                                            @if($disciplina->ensino=="medio")
                                            <option value="6">6º Tempo</option>
                                            @endif
                                        @else
                                            @if($diario->tempo==3)
                                                <option value="1">1º Tempo</option>
                                                <option value="2">2º Tempo</option>
                                                <option value="4">4º Tempo</option>
                                                <option value="5">5º Tempo</option>
                                                @if($disciplina->ensino=="medio")
                                                <option value="6">6º Tempo</option>
                                                @endif
                                            @else
                                                @if($diario->tempo==4)
                                                    <option value="1">1º Tempo</option>
                                                    <option value="2">2º Tempo</option>
                                                    <option value="3">3º Tempo</option>
                                                    <option value="5">5º Tempo</option>
                                                    @if($disciplina->ensino=="medio")
                                                    <option value="6">6º Tempo</option>
                                                    @endif
                                                @else
                                                    @if($diario->tempo==5)
                                                        <option value="1">1º Tempo</option>
                                                        <option value="2">2º Tempo</option>
                                                        <option value="3">3º Tempo</option>
                                                        <option value="4">4º Tempo</option>
                                                        @if($disciplina->ensino=="medio")
                                                        <option value="6">6º Tempo</option>
                                                        @endif
                                                    @else
                                                        @if($diario->tempo==6)
                                                            <option value="1">1º Tempo</option>
                                                            <option value="2">2º Tempo</option>
                                                            <option value="3">3º Tempo</option>
                                                            <option value="4">4º Tempo</option>
                                                            <option value="5">5º Tempo</option>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                    @endif
                                </select>
                                <label for="tempo">Tempo</label>
                            </div>
                                <input type="hidden" id="valorPrevio" value="{{$diario->segundo_tempo}}"/>
                                <div id="selects">
                                    <div id="div_select1">
                                        <div class="col-auto form-floating">
                                            <select class="form-select" id="select1" name="segundoTempo" required>
                                                @if($diario->segundo_tempo=="0")
                                                <option id="select1_nao" value="0">NÃO</option>
                                                <option id="select1_sim" value="1">SIM</option>
                                                @else
                                                    @if($diario->segundo_tempo=="1")
                                                    <option id="select1_sim" value="1">SIM</option>
                                                    <option id="select1_nao" value="0">NÃO</option>
                                                    @endif
                                                @endif
                                            </select>
                                            <label for="segundoTempo">Duplicar lançamento para outro tempo?</label>
                                        </div>
                                    </div>
                                    <div id="div_select2">
                                        <div class="col-auto form-floating">
                                            <select class="form-select" id="select2" name="outroTempo">
                                                @if($diario->outro_tempo=="")
                                                <option value="">Selecione o tempo</option>
                                                <option value="1">1º Tempo</option>
                                                <option value="2">2º Tempo</option>
                                                <option value="3">3º Tempo</option>
                                                <option value="4">4º Tempo</option>
                                                <option value="5">5º Tempo</option>
                                                @if($disciplina->ensino=="medio")
                                                <option value="6">6º Tempo</option>
                                                @endif
                                                @else
                                                <option value="{{$diario->outro_tempo}}">{{$diario->outro_tempo}}º Tempo</option>
                                                @if($diario->outro_tempo==1)
                                                    <option value="2">2º Tempo</option>
                                                    <option value="3">3º Tempo</option>
                                                    <option value="4">4º Tempo</option>
                                                    <option value="5">5º Tempo</option>
                                                    @if($disciplina->ensino=="medio")
                                                    <option value="6">6º Tempo</option>
                                                    @endif
                                                @else
                                                    @if($diario->outro_tempo==2)
                                                        <option value="1">1º Tempo</option>
                                                        <option value="3">3º Tempo</option>
                                                        <option value="4">4º Tempo</option>
                                                        <option value="5">5º Tempo</option>
                                                        @if($disciplina->ensino=="medio")
                                                        <option value="6">6º Tempo</option>
                                                        @endif
                                                    @else
                                                        @if($diario->outro_tempo==3)
                                                            <option value="1">1º Tempo</option>
                                                            <option value="2">2º Tempo</option>
                                                            <option value="4">4º Tempo</option>
                                                            <option value="5">5º Tempo</option>
                                                            @if($disciplina->ensino=="medio")
                                                            <option value="6">6º Tempo</option>
                                                            @endif
                                                        @else
                                                            @if($diario->outro_tempo==4)
                                                                <option value="1">1º Tempo</option>
                                                                <option value="2">2º Tempo</option>
                                                                <option value="3">3º Tempo</option>
                                                                <option value="5">5º Tempo</option>
                                                                @if($disciplina->ensino=="medio")
                                                                <option value="6">6º Tempo</option>
                                                                @endif
                                                            @else
                                                                @if($diario->outro_tempo==5)
                                                                    <option value="1">1º Tempo</option>
                                                                    <option value="2">2º Tempo</option>
                                                                    <option value="3">3º Tempo</option>
                                                                    <option value="4">4º Tempo</option>
                                                                    @if($disciplina->ensino=="medio")
                                                                    <option value="6">6º Tempo</option>
                                                                    @endif
                                                                @else
                                                                    @if($diario->outro_tempo==6)
                                                                        <option value="1">1º Tempo</option>
                                                                        <option value="2">2º Tempo</option>
                                                                        <option value="3">3º Tempo</option>
                                                                        <option value="4">4º Tempo</option>
                                                                        <option value="5">5º Tempo</option>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                                @endif
                                            </select>
                                            <label for="outroTempo">Outro Tempo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="col-auto form-floating">
                                <input class="form-control" type="text" form="form-diario" name="tema" id="tema" @if($diario->tema!="") value="{{$diario->tema}}" @else placeholder="Tema da Aula" @endif required>
                                <label for="tema">Tema da Aula</label>
                            </div>
                            <div class="col-auto form-floating">
                                <textarea class="form-control" form="form-diario" name="conteudo" id="conteudo" rows="5" cols="40" maxlength="245" placeholder="Conteúdo" required>@if($diario->conteudo!=""){{$diario->conteudo}}@endif</textarea>
                                <label for="conteudo">Conteúdo</label>
                            </div>
                            <div class="col-auto form-floating">
                                <input class="form-control" type="text" form="form-diario" name="referencias" id="referencias" @if($diario->referencias!="") value="{{$diario->referencias}}" @else placeholder="Referências" @endif required>
                                <label for="referencias">Referências</label>
                            </div>
                            <div class="col-auto form-floating">
                                <select class="form-select" form="form-diario" id="tipoTarefa" name="tipoTarefa" required>
                                    @if($diario->tipo_tarefa=="")
                                    <option value="">Selecione tipo de tarefa</option>
                                    <option value="AULA"> VISTADA EM AULA </option>
                                    <option value="SCULES"> ENVIADA NO SCULES </option>
                                    @else
                                        <option value="{{$diario->tipo_tarefa}}">@if($diario->tipo_tarefa=="AULA") VISTADA EM AULA @else ENVIADA NO SCULES @endif</option>
                                        @if($diario->tipo_tarefa=="AULA")
                                        <option value="SCULES"> ENVIADA NO SCULES </option>
                                        @else
                                        <option value="AULA"> VISTADA EM AULA </option>
                                        @endif
                                    @endif
                                </select>
                                <label for="tempo">Tipo de Tarefa</label>
                            </div>
                            <div class="col-auto form-floating">
                                <textarea class="form-control" form="form-diario" name="tarefa" id="tarefa" rows="5" cols="40" maxlength="245" placeholder="Tarefa" required>@if($diario->tarefa!=""){{$diario->tarefa}}@endif</textarea>
                                <label for="tarefa">Tarefa</label>
                            </div>
                            <div class="col-auto form-floating">
                                <input class="form-control" type="date" form="form-diario" name="entregaTarefa" @if($diario->entrega_tarefa!="") value="{{date("Y-m-d", strtotime($diario->entrega_tarefa))}}" @endif required>
                                <label for="data">Data da Entrega da Tarefa</label>
                            </div></b>
                            <div class="modal-footer">
                                <button type="submit" form="form-diario" class="btn btn-outline-primary">Salvar Diário</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            @endforeach
                        <hr/>
                        <b><h3 class="card-title" style="text-align: center;">Ocorrências do Dia</h3></b>
                        <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Lançar Ocorrências">
                            <i class="material-icons blue md-60">add_circle</i>
                        </a>
                        <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Lançamento de Ocorrência</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 style="color: red;"><u>Clique sobre o nome do aluno para ver a foto, e clique em qualquer área fora da foto para sair da visualização da foto.</u></h5>
                                    <div class="table-responsive-xl">
                                    <table class="table table-striped table-sm">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Marcar</th>
                                                <th style="text-align: center;">Aluno</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <form method="POST" action="/prof/ocorrencias">
                                                    @csrf
                                                    @foreach ($alunos as $aluno)
                                                <tr>
                                                    <td><input type="checkbox" name="alunos[]" value="{{$aluno->id}}"></td>
                                                    <td><button type="button" class="badge bg-secondary" data-bs-toggle="modal" data-bs-target="#exampleModalFoto{{$aluno->id}}">{{$aluno->name}}</button></td>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModalFoto{{$aluno->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-body" style="color: black; text-align: center;">
                                                                @if($aluno->foto!="") <img src="/storage/{{$aluno->foto}}" alt="foto_aluno" style="width: 100%"> @else <i class="material-icons md-60">no_photography</i> @endif
                                                                <hr/>
                                                                <h6 class="font-italic">
                                                                {{$aluno->name}} - {{$aluno->turma->serie}}º ANO {{$aluno->turma->turma}} (@if($aluno->turma->turno=='M') Matutino @else @if($aluno->turma->turno=='V') Vespertino @else Noturno @endif @endif)
                                                                </h6>
                                                                <hr/>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                    </table>
                                    </div>
                                    <br/>
                                    <div class="col-auto form-floating">
                                        <select class="form-select" id="tipo" name="tipo" required style="width:300px;">
                                            <option value="">Selecione o tipo</option>
                                            @foreach ($tipos as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->codigo}} - {{$tipo->descricao}} - @if($tipo->tipo=="despontuacao") Despontuar: @else Elogio: @endif{{$tipo->pontuacao}}</option>
                                            @endforeach
                                        </select>
                                        <label for="tipo">Tipo de Ocorrência</label>
                                    </div>
                                    <br/><br/>
                                    <input type="hidden" name="disciplina" value="{{$disciplina->id}}">
                                    <input type="hidden" name="data" value="{{$dia}}" required>
                                    <label for="observacao">Observação</label>
                                    <textarea class="form-control" name="observacao" id="observacao" rows="10" cols="40" maxlength="500" placeholder="Atenção!!! Caso marque vários alunos e faça uma observação neste momento, a mesma será para todos marcados. Caso deseje apenas para alunos especificos lance sem observação e edite o lançamento para inserir a observação."></textarea> 
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                        @if(count($ocorrencias)==0)
                                <div class="alert alert-dark" role="alert">
                                    Sem ocorrências lançadas! Faça novo lançamento no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                                </div>
                        @else
                        <div class="table-responsive-xl">
                        <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                            <thead class="table-dark">
                                <tr>
                                    <th>Ocorrência</th>
                                    <th>Aluno</th>
                                    <th>Observação</th>
                                    <th colspan="2">Ações</th>
                                    <th>Aprovação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ocorrencias as $ocorrencia)
                                @if($ocorrencia->aluno->turma_id==$turma->id)
                                <tr>
                                    <td>{{$ocorrencia->tipo_ocorrencia->codigo}} - {{$ocorrencia->tipo_ocorrencia->descricao}}</td>
                                    <td>{{$ocorrencia->aluno->name}}</td>
                                    <td>
                                        @if($ocorrencia->observacao=="")
                                        @else
                                        <button type="button" class="badge bg-info" data-bs-toggle="modal" data-bs-target="#exampleModalOb{{$ocorrencia->id}}">
                                            <i class="material-icons white">visibility</i>
                                        </button>
                                        @endif
                                        <div class="modal fade" id="exampleModalOb{{$ocorrencia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Observação</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>{{$ocorrencia->observacao}}</p>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td @if($ocorrencia->aprovado===0 || $ocorrencia->aprovado===1)colspan="2" @endif>
                                        @if($ocorrencia->aprovado==1) 
                                        @else
                                            @if($ocorrencia->aprovado!==NULL)
                                            @else
                                        <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$ocorrencia->id}}" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="material-icons md-18">edit</i>
                                        </button>
                                        
                                        <div class="modal fade" id="exampleModal{{$ocorrencia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editar Ocorrência</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/prof/ocorrencias/editar/{{$ocorrencia->id}}" method="POST">
                                                        @csrf
                                                        <h6><b>Aluno: {{$ocorrencia->aluno->name}}</b></h6>
                                                        <label for="tipo">Tipo</label>
                                                        <select class="custom-select" id="tipo" name="tipo" required style="width:300px;">
                                                            <option value="{{$ocorrencia->tipo_ocorrencia->id}}">{{$ocorrencia->tipo_ocorrencia->codigo}} - {{$ocorrencia->tipo_ocorrencia->descricao}} - @if($ocorrencia->tipo_ocorrencia->tipo=="despontuacao") Despontuar: @else Elogio: @endif{{$ocorrencia->tipo_ocorrencia->pontuacao}}</option>
                                                            @foreach ($tipos as $tipo)
                                                            @if($tipo->id==$ocorrencia->tipo_ocorrencia_id)
                                                            @else
                                                            <option value="{{$tipo->id}}">{{$tipo->codigo}} - {{$tipo->descricao}} - @if($tipo->tipo=="despontuacao") Despontuar: @else Elogio: @endif{{$tipo->pontuacao}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="data" value="{{$dia}}" required>
                                                        <br/>
                                                        <label for="observacao">Observação</label>
                                                        <textarea class="form-control" name="observacao" id="observacao" rows="10" cols="40" maxlength="500">{{$ocorrencia->observacao}}</textarea> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-sm">Editar</button>
                                                </div>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{$ocorrencia->id}}" data-toggle="tooltip" data-placement="left" title="Excluir"><i class="material-icons md-18">delete</i></button></td>
                                        <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg" id="exampleModalDelete{{$ocorrencia->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Ocorrência Nº {{$ocorrencia->id}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Tem certeza que deseja excluir essa ocorrência?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                        <form action="/prof/ocorrencias/apagar/{{$ocorrencia->id}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="ocorrencia" value="{{$ocorrencia->id}}" required>
                                                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                    </td>
                                    <td max-width="100px">
                                        @if($ocorrencia->aprovado==1)
                                            <b><p style="color: green;"><i class="material-icons green">check_circle</i> APROVADO</p></b> 
                                        @else
                                            @if($ocorrencia->aprovado!==NULL)
                                            <b><p style="color: red;"><i class="material-icons red">highlight_off</i> REPROVADO</p></b>
                                            @else
                                                <p><i class="material-icons">update</i> Aguardando Análise</p>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        @endif

        </div>
    </div>
    <script type="text/javascript">
        window.addEventListener("load", start);

        let teste = document.querySelector("#valorPrevio").value;
        let sim = document.querySelector("#select1_sim");
        let nao = document.querySelector("#select1_nao");

        function start() {
        definirSegundoTempo();
        render();
        }

        function definirSegundoTempo() {
        teste === "1" ? (sim.selected = true) : (nao.selected = true);
        addEventListener("change", render);
        render();
        }

        function render() {
        let segundoTempo = document.querySelector("#div_select2");
        nao.selected === true
            ? (segundoTempo.style.display = "none")
            : (segundoTempo.style.display = "block");
        }
    </script>
@endsection