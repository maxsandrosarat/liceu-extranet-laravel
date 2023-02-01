@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
        <div class="row">
            <div class="col-9" style="text-align: left">
                <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            </div>
            <div class="col-3" style="text-align: right">
                <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModalDeleteAll" data-toggle="tooltip" data-placement="bottom" title="Excluir Todas as Atividades">
                    <i class="material-icons red md-50">delete_forever</i>
                </a>
            </div>
        </div>
        <h5 class="card-title">Painel de Atividades Diárias - {{date("d/m/Y H:i")}}</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Atividade">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Atividade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="nova-atividade" method="POST" action="/admin/atividadeDiaria" enctype="multipart/form-data">
                        @csrf
                        <div class="col-auto form-floating">
                            <select class="form-select" id="prof" name="prof" required>
                                <option value="">Selecione</option>
                                @foreach ($profs as $prof)
                                <option value="{{$prof->id}}">{{$prof->name}}</option>
                                @endforeach
                            </select>
                            <label for="prof">Professor(a)</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="disciplina" name="disciplina" required>
                                <option value="">Selecione</option>
                                @foreach ($discs as $disciplina)
                                <option value="{{$disciplina->id}}">{{$disciplina->nome}} (@if($disciplina->ensino=='fund') Fundamental @else Médio @endif)</option>
                                @endforeach
                            </select>
                            <label for="disciplina">Disciplina</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                @foreach ($turmas as $turma)
                                <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                @endforeach
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="data" id="data" required>
                            <label for="data">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="text" name="descricao" id="descricao" required>
                            <label for="descricao">Descrição</label>
                        </div>
                        <div class="col-auto form-floating">
                            <ul id="arquivos" class="list-group">
                                <li class="list-group-item"><input class="form-control" type="file" id="arquivo0" name="arquivo0" required></li>
                            </ul>
                            <input type="hidden" id="qtdArq" name="qtdArq" value="0">
                            <div class="modal-footer">
                                <a href="#" onclick="addArquivo();" class="badge bg-info" data-toggle="tooltip" data-placement="bottom" title="Adicionar Mais Arquivos"><i class="material-icons white md-24">add</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a onclick="enviar();" class="btn btn-sm btn-primary">Enviar</a>
                    </div>
                </form>
                </div>
            </div>
            </div>
            @if(count($atividades)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem atividades cadastradas!
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/atividadeDiaria" class="btn btn-sm btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/atividadeDiaria/filtro">
                        @csrf
                        <div class="col-auto form-floating">
                            <select class="form-select" name="prof">
                                <option value="">Selecione</option>
                                @foreach ($profs as $prof)
                                <option value="{{$prof->id}}">{{$prof->name}}</option>
                                @endforeach
                            </select>
                            <label for="prof">Professor(a)</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" name="disciplina">
                                <option value="">Selecione</option>
                                @foreach ($discs as $disciplina)
                                <option value="{{$disciplina->id}}">{{$disciplina->nome}}@if($disciplina->ensino=='fund') (Fundamental) @else @if($disciplina->ensino=='medio') (Médio) @endif @endif</option>
                                @endforeach
                            </select>
                            <label for="disciplina">Disciplina</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" name="turma">
                                <option value="">Selecione</option>
                                @foreach ($turmas as $turma)
                                <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                @endforeach
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="data">
                            <label for="data">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control mr-sm-2" type="text" placeholder="Digite a descrição" name="descricao">
                            <label for="descricao">Descrição Atividade</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo {{$atividades->count()}} de {{$atividades->total()}} de Atividades ({{$atividades->firstItem()}} a {{$atividades->lastItem()}})</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                @foreach ($atividades as $atividade)
                @php
                    $dataAtual = date("Y-m-d");
                @endphp
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#exampleModal{{$atividade->id}}"><div id="my-div" class="bd-callout @if($atividade->impresso==1) bd-callout-success @else @if($atividade->data==$dataAtual && $atividade->impresso==0) bd-callout-warning @else @if($atividade->data>$dataAtual && $atividade->impresso==0) bd-callout-info @else @if($atividade->data<$dataAtual && $atividade->impresso==0) bd-callout-danger @endif @endif @endif @endif">
                        <h4>{{$atividade->prof->name}} - {{$atividade->disciplina->nome}} - {{$atividade->turma->serie}}º ANO {{$atividade->turma->turma}} - {{$atividade->descricao}}</h4>
                        <p>Data: {{date("d/m/Y", strtotime($atividade->data))}}</p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$atividade->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atividade: {{$atividade->descricao}} <a href="/admin/atividadeDiaria/impresso/{{$atividade->id}}"> @if($atividade->impresso==0) <button type="button" class="badge bg-warning" data-toggle="tooltip" data-placement="bottom" title="Não Impresso (Marcar como Impresso)"><i class="material-icons">print_disabled</i></button> @else <button type="button" class="badge bg-success" data-toggle="tooltip" data-placement="bottom" title="Impresso (Marcar como Não Impresso)"><i class="material-icons">print</i></button> @endif</a></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Professor(a): {{$atividade->prof->name}} <br/> <hr/>
                                Disciplina: {{$atividade->disciplina->nome}} <br/> <hr/>
                                Turma: {{$atividade->turma->serie}}º ANO {{$atividade->turma->turma}} <br/> <hr/>
                                Descrição: {{$atividade->descricao}} <br/> <hr/>
                                Data: {{date("d/m/Y", strtotime($atividade->data))}} <br/> <hr/>
                                <ol class="list-group list-group-numbered">
                                @foreach ($atividade->anexos as $anexo)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                      <div class="fw-bold">{{$anexo->descricao}}</div>
                                    </div>
                                    <a type="button" class="badge bg-success rounded-pill" href="/admin/atividadeDiaria/download/{{$anexo->id}}"><i class="material-icons md-48">cloud_download</i></a>
                                </li>
                                @endforeach
                                </ol>
                                <hr/>
                                Criado por: {{$atividade->usuario}}<br/>
                                Data da Criação: {{date("d/m/Y H:i", strtotime($atividade->created_at))}}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge bg-danger" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{$atividade->id}}" data-bs-toggle="tooltip" data-placement="bottom" title="Excluir Atividade"><i class="material-icons md-48">delete</i></a> <br/> <hr/>
                            <!-- Modal Deletar -->
                            <div class="modal fade" id="exampleModalDelete{{$atividade->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Atividade: {{$atividade->descricao}} - {{$atividade->turma->serie}}º ANO {{$atividade->turma->turma}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Tem certeza que deseja excluir essa atividade?</h5>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-danger" href="/admin/atividadeDiaria/apagar/{{$atividade->id}}">Excluir</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            <div class="card-footer">
                {{ $atividades->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Modal Deletar Todos -->
<div class="modal fade" id="exampleModalDeleteAll" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Todas as Atividades</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Tem certeza que deseja excluir todas as atividades?</h5>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-danger" href="/admin/atividadeDiaria/apagar/-1">Excluir</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection
