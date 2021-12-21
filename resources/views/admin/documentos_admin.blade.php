@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
        <a href="/admin/pedagogico" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h5 class="card-title">Painel de Documentos Importantes</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Documento">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form class="row g-3" method="POST" action="/admin/documentos" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 form-floating">
                            <input class="form-control" type="text" name="titulo" placeholder="Título" id="titulo" required>
                            <label for="titulo">Título</label>
                        </div>
                        <legend>Publicação</legend>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="dataPublicacao" id="dataPublicacao" required>
                            <label for="dataPublicacao">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="time" name="horaPublicacao" id="horaPublicacao" required>
                            <label for="horaPublicacao">Hora</label>
                        </div>
                        <legend>Remoção</legend>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="dataRemocao" id="dataRemocao" required>
                            <label for="dataRemocao">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="time" name="horaRemocao" id="horaRemocao" required>
                            <label for="horaRemocao">Hora</label>
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
            @if(count($documentos)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem documentos cadastrados!
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/documentos" class="btn btn-sm btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/documentos/filtro">
                        @csrf
                        <div class="col-auto form-floating">
                            <input class="form-control mr-sm-2" type="text" placeholder="Título" name="titulo">
                            <label for="titulo">Título</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo {{$documentos->count()}} de {{$documentos->total()}} de Documentos ({{$documentos->firstItem()}} a {{$documentos->lastItem()}})</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                @foreach ($documentos as $documento)
                @php
                    $data = date("Y-m-d H:i");
                    $dataAtivPub = date("Y-m-d H:i", strtotime($documento->data_publicacao));
                    $dataAtivRem = date("Y-m-d H:i", strtotime($documento->data_remocao));
                @endphp
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#modalDoc{{$documento->id}}"><div id="my-div" class="bd-callout @if($dataAtivPub<$data && $dataAtivRem>$data) bd-callout-success @else @if($dataAtivPub>$data) bd-callout-warning @else bd-callout-danger @endif @endif">
                        <h4>{{$documento->titulo}}</h4>
                        <p>Publicação: {{date("d/m/Y H:i", strtotime($documento->data_publicacao))}} - Remoção: {{date("d/m/Y H:i", strtotime($documento->data_remocao))}}</p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDoc{{$documento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Documento: {{$documento->titulo}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Título: {{$documento->titulo}} <br/> <hr/>
                                Data Publicação: {{date("d/m/Y H:i", strtotime($documento->data_publicacao))}} <br/> <hr/>
                                Data Remoção: {{date("d/m/Y H:i", strtotime($documento->data_remocao))}} <br/> <hr/>
                                Data Criação: {{date("d/m/Y H:i", strtotime($documento->created_at))}}<br/>
                                Última Alteração: {{date("d/m/Y H:i", strtotime($documento->updated_at))}}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge bg-success" href="/admin/documentos/download/{{$documento->id}}"><i class="material-icons md-48">cloud_download</i></a> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalDocEditar{{$documento->id}}"><i class="material-icons md-48">edit</i></button> <a type="button" class="badge bg-danger" href="#" class="btn-close" data-bs-toggle="modal" data-bs-target="#modalDocDel{{$documento->id}}" data-toggle="tooltip" data-placement="bottom" title="Excluir documento"><i class="material-icons md-48">delete</i></a> <br/> <hr/>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="modalDocEditar{{$documento->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar documento: {{$documento->titulo}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" method="POST" action="/admin/documentos/editar/{{$documento->id}}" enctype="multipart/form-data">
                                            @csrf
                                                <div class="col-12 form-floating">
                                                    <input type="text" class="form-control" name="titulo" id="titulo" value="{{$documento->titulo}}" required>
                                                    <label for="descricao">Título</label>
                                                </div>
                                                <legend>Publicação</legend>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="date" name="dataPublicacao" id="dataPublicacao" value="{{date("Y-m-d", strtotime($documento->data_publicacao))}}" required>
                                                    <label for="dataPublicacao">Data</label>
                                                </div>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="time" name="horaPublicacao" id="horaPublicacao" value="{{date("H:i", strtotime($documento->data_publicacao))}}" required>
                                                    <label for="horaPublicacao">Hora</label>
                                                </div>
                                                <legend>Remoção</legend>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="date" name="dataRemocao" id="dataRemocao" value="{{date("Y-m-d", strtotime($documento->data_remocao))}}" required>
                                                    <label for="dataRemocao">Data</label>
                                                </div>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="time" name="horaRemocao" id="horaRemocao" value="{{date("H:i", strtotime($documento->data_remocao))}}" required>
                                                    <label for="horaRemocao">Hora</label>
                                                </div>
                                                <div class="col-12 input-group mb-3">
                                                    <label for="foto" class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Adicionar Arquivo"><i class="material-icons blue md-24">note_add</i></label>
                                                    <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf">
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
                            <div class="modal fade" id="modalDocDel{{$documento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Documento: {{$documento->titulo}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Tem certeza que deseja excluir esse documento?</h5>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-danger" href="/admin/documentos/apagar/{{$documento->id}}">Excluir</a>
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
                {{ $documentos->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
