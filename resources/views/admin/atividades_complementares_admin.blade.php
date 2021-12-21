@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
        <a href="/admin/pedagogico" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h5 class="card-title">Painel de Atividades Complementares</h5>
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
                    <form class="row g-3" method="POST" action="/admin/atividadeComplementar" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 form-floating">
                            <select class="form-select" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                @foreach ($turmas as $turma)
                                <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                @endforeach
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-12 form-floating">
                            <select class="form-select" id="prof" name="prof" required>
                                <option value="">Selecione</option>
                                @foreach ($profs as $prof)
                                <option value="{{$prof->id}}">{{$prof->name}}</option>
                                @endforeach
                            </select>
                            <label for="prof">Professor(a)</label>
                        </div>
                        <div class="col-12 form-floating">
                            <select class="form-select" id="disciplina" name="disciplina" required>
                                <option value="">Selecione</option>
                                @foreach ($discs as $disciplina)
                                <option value="{{$disciplina->id}}">{{$disciplina->nome}} (@if($disciplina->ensino=='fund') Fundamental @else Médio @endif)</option>
                                @endforeach
                            </select>
                            <label for="disciplina">Disciplina</label>
                        </div>
                        <div class="col-12 form-floating">
                            <input class="form-control" type="date" name="data" id="data" required>
                            <label for="data">Data Utilização</label>
                        </div>
                        <div class="col-12 form-floating">
                            <input class="form-control" type="text" name="descricao" placeholder="Descrição" id="descricao" required>
                            <label for="descricao">Descrição</label>
                        </div>
                        <div class="col-12 input-group mb-3">
                            <label for="foto" class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Adicionar Arquivo"><i class="material-icons blue md-24">note_add</i></label>
                            <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                        </div>
                        <b style="font-size: 80%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
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
                        <a href="/admin/atividade" class="btn btn-sm btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/atividadeComplementar/filtro">
                        @csrf
                        <div class="col-auto form-floating">
                            <select class="form-select" id="turma" name="turma">
                                <option value="">Selecione</option>
                                @foreach ($turmas as $turma)
                                <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                @endforeach
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="disciplina" name="disciplina">
                                <option value="">Selecione</option>
                                @foreach ($discs as $disciplina)
                                <option value="{{$disciplina->id}}">{{$disciplina->nome}}@if($disciplina->ensino=='fund') (Fundamental) @else @if($disciplina->ensino=='medio') (Médio) @endif @endif</option>
                                @endforeach
                            </select>
                            <label for="disciplina">Disciplina</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control mr-sm-2" type="text" placeholder="Digite a descrição" name="descricao">
                            <label for="descricao">Descrição Atividade</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo {{$atividades->count()}} de {{$atividades->total()}} de Atividades ({{$atividades->firstItem()}} a {{$atividades->lastItem()}})</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                @foreach ($atividades as $atividade)
                @php
                    $data = date("Y-m-d");
                    $dataAtiv = date("Y-m-d", strtotime($atividade->data));
                @endphp
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#exampleModal{{$atividade->id}}"><div id="my-div" class="bd-callout @if($atividade->impresso==true) bd-callout-success @else @if($dataAtiv==$data) bd-callout-warning @else @if($atividade->data>$data) bd-callout-info @else @if($atividade->data<$data) bd-callout-danger @endif @endif @endif @endif">
                        <h4>{{$atividade->turma->serie}}º ANO {{$atividade->turma->turma}} - {{$atividade->disciplina->nome}} - {{$atividade->descricao}}</h4>
                        <p>Utilização: {{date("d/m/Y", strtotime($atividade->data))}}</p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{$atividade->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atividade: {{$atividade->descricao}} @if($atividade->impresso==false)<a type="button" href="/admin/atividadeComplementar/impresso/{{$atividade->id}}" class="badge bg-success" data-toggle="tooltip" data-placement="bottom" title="Impresso"><i class="material-icons">print</i></a>@else <a type="button" href="/admin/atividadeComplementar/impresso/{{$atividade->id}}" class="badge bg-warning" data-toggle="tooltip" data-placement="bottom" title="Não Impresso"><i class="material-icons">print</i></a> @endif</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Professor(a): {{$atividade->prof->name}} - Disciplina: {{$atividade->disciplina->nome}} <br/> <hr/>
                                Turma: {{$atividade->turma->serie}}º ANO {{$atividade->turma->turma}} <br/> <hr/>
                                Descrição: {{$atividade->descricao}} <br/> <hr/>
                                Data Utilização: {{date("d/m/Y", strtotime($atividade->data))}} <br/> <hr/>
                                Data da Criação: {{date("d/m/Y H:i", strtotime($atividade->created_at))}}<br/>
                                Última Alteração: {{date("d/m/Y H:i", strtotime($atividade->updated_at))}}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge bg-success" href="/admin/atividadeComplementar/download/{{$atividade->id}}"><i class="material-icons md-48">cloud_download</i></a> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalEditar{{$atividade->id}}"><i class="material-icons md-48">edit</i></button> <a type="button" class="badge bg-danger" href="#" class="btn-close" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{$atividade->id}}" data-toggle="tooltip" data-placement="bottom" title="Excluir Atividade"><i class="material-icons md-48">delete</i></a> <br/> <hr/>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="modalEditar{{$atividade->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar Atividade: {{$atividade->descricao}} - {{$atividade->turma->serie}}º ANO {{$atividade->turma->turma}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" method="POST" action="/admin/atividadeComplementar/editar/{{$atividade->id}}" enctype="multipart/form-data">
                                            @csrf
                                                <div class="col-12 form-floating">
                                                    <select id="turma" class="form-control" name="turma" required>
                                                        <option value="{{$atividade->turma->id}}">{{$atividade->turma->serie}}º ANO {{$atividade->turma->turma}} (@if($atividade->turma->turno=='M') Matutino @else @if($atividade->turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                                        @foreach ($turmas as $turma)
                                                        @if($turma->id!=$atividade->turma->id)
                                                        <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <label for="turma">Turma</label>
                                                </div>
                                                <div class="col-12 form-floating">
                                                    <input type="date" class="form-control" name="data" id="data" value="{{date("Y-m-d", strtotime($atividade->data))}}" required>
                                                    <label for="data" class="col-md-4 col-form-label text-md-right">Data Utilização</label>
                                                </div>
                                                <div class="col-12 form-floating">
                                                    <input type="text" class="form-control" name="descricao" id="descricao" value="{{$atividade->descricao}}" required>
                                                    <label for="descricao">Descrição</label>
                                                </div>
                                                <br/>
                                                <div class="col-12 input-group mb-3">
                                                    <label for="foto" class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Adicionar Arquivo"><i class="material-icons blue md-24">note_add</i></label>
                                                    <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                                                </div>
                                                <b style="font-size: 80%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <a type="button" class="btn btn-danger" href="/admin/atividadeComplementar/apagar/{{$atividade->id}}">Excluir</a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
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
@endsection
