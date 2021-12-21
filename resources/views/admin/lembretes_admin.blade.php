@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
        <a href="/admin/pedagogico" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h5 class="card-title">Painel de Lembretes</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Lembrete">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Lembrete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form class="row g-3" method="POST" action="/admin/lembretes" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 form-floating">
                            <input class="form-control" type="text" name="titulo" placeholder="Título" id="titulo" required>
                            <label for="titulo">Título</label>
                        </div>
                        <div class="col-12 form-floating">
                            <textarea class="form-control" name="conteudo" id="conteudo" rows="10" cols="40" placeholder="Conteúdo"></textarea>
                            <label for="conteudo">Conteúdo</label>
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
            @if(count($lembretes)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem lembretes cadastrados!
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/lembretes" class="btn btn-sm btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/lembretes/filtro">
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
            <b><h5 class="font-italic">Exibindo {{$lembretes->count()}} de {{$lembretes->total()}} de lembretes ({{$lembretes->firstItem()}} a {{$lembretes->lastItem()}})</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                @foreach ($lembretes as $lembrete)
                @php
                    $data = date("Y-m-d H:i");
                    $dataAtivPub = date("Y-m-d H:i", strtotime($lembrete->data_publicacao));
                    $dataAtivRem = date("Y-m-d H:i", strtotime($lembrete->data_remocao));
                @endphp
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#modalDoc{{$lembrete->id}}"><div id="my-div" class="bd-callout @if($dataAtivPub<$data && $dataAtivRem>$data) bd-callout-success @else @if($dataAtivPub>$data) bd-callout-warning @else bd-callout-danger @endif @endif">
                        <h4>{{$lembrete->titulo}}</h4>
                        <p>Publicação: {{date("d/m/Y H:i", strtotime($lembrete->data_publicacao))}} - Remoção: {{date("d/m/Y H:i", strtotime($lembrete->data_remocao))}}</p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDoc{{$lembrete->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">lembrete: {{$lembrete->titulo}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Título: {{$lembrete->titulo}} <br/> <hr/>
                                Conteúdo: "{{$lembrete->conteudo}}" <br/> <hr/>
                                Data Publicação: {{date("d/m/Y H:i", strtotime($lembrete->data_publicacao))}} <br/> <hr/>
                                Data Remoção: {{date("d/m/Y H:i", strtotime($lembrete->data_remocao))}} <br/> <hr/>
                                Data Criação: {{date("d/m/Y H:i", strtotime($lembrete->created_at))}}<br/>
                                Última Alteração: {{date("d/m/Y H:i", strtotime($lembrete->updated_at))}}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalDocEditar{{$lembrete->id}}"><i class="material-icons md-48">edit</i></button> <a type="button" class="badge bg-danger" href="#" class="btn-close" data-bs-toggle="modal" data-bs-target="#modalDocDel{{$lembrete->id}}" data-toggle="tooltip" data-placement="bottom" title="Excluir lembrete"><i class="material-icons md-48">delete</i></a> <br/> <hr/>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="modalDocEditar{{$lembrete->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar Lembrete: {{$lembrete->titulo}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" method="POST" action="/admin/lembretes/editar/{{$lembrete->id}}" enctype="multipart/form-data">
                                            @csrf
                                                <div class="col-12 form-floating">
                                                    <input type="text" class="form-control" name="titulo" id="titulo" value="{{$lembrete->titulo}}" required>
                                                    <label for="descricao">Título</label>
                                                </div>
                                                <div class="col-12 form-floating">
                                                    <textarea class="form-control" name="conteudo" id="conteudo" rows="10" cols="40" placeholder="Conteúdo">{{$lembrete->conteudo}}</textarea>
                                                    <label for="conteudo">Conteúdo</label>
                                                </div>
                                                <legend>Publicação</legend>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="date" name="dataPublicacao" id="dataPublicacao" value="{{date("Y-m-d", strtotime($lembrete->data_publicacao))}}" required>
                                                    <label for="dataPublicacao">Data</label>
                                                </div>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="time" name="horaPublicacao" id="horaPublicacao" value="{{date("H:i", strtotime($lembrete->data_publicacao))}}" required>
                                                    <label for="horaPublicacao">Hora</label>
                                                </div>
                                                <legend>Remoção</legend>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="date" name="dataRemocao" id="dataRemocao" value="{{date("Y-m-d", strtotime($lembrete->data_remocao))}}" required>
                                                    <label for="dataRemocao">Data</label>
                                                </div>
                                                <div class="col-auto form-floating">
                                                    <input class="form-control" type="time" name="horaRemocao" id="horaRemocao" value="{{date("H:i", strtotime($lembrete->data_remocao))}}" required>
                                                    <label for="horaRemocao">Hora</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Deletar -->
                            <div class="modal fade" id="modalDocDel{{$lembrete->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Lembrete: {{$lembrete->titulo}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Tem certeza que deseja excluir esse lembrete?</h5>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-danger" href="/admin/lembretes/apagar/{{$lembrete->id}}">Excluir</a>
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
                {{ $lembretes->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
