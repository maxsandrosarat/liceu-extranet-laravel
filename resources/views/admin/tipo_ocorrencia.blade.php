@extends('layouts.app', ["current"=>"administrativo"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Tipos de Ocorrências</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Tipo de Ocorrência">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastro de Tipos Ocorrências</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" action="/admin/tiposOcorrencias" method="POST">
                                @csrf
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="codigo" type="text" id="codigo" placeholder="Código" required/>
                                    <label for="codigo">Código</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="descricao" type="text" id="descricao" placeholder="Descrição" required/>
                                    <label for="descricao">Descrição</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="despontuacao">Despontuação</option>
                                        <option value="elogio">Elogio</option>
                                    </select>
                                    <label for="tipo">Tipo</label>
                                </div> 
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="pontuacao" type="text" id="pontuacao" placeholder="Pontuação" required/>
                                    <label for="pontuacao">Pontuação</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($tipos)==0)
                <div class="alert alert-danger" role="alert">
                    Sem tipos cadastrados!
                </div>
            @else
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Pontuação</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipos as $tipo)
                    <tr>
                        <td>{{$tipo->codigo}}</td>
                        <td>{{$tipo->descricao}}</td>
                        <td>@if($tipo->tipo=='despontuacao') Despontuação @else Elogio @endif</td>
                        <td>{{$tipo->pontuacao}}</td>
                        <td>
                            @if($tipo->ativo==1)
                                <b><i class="material-icons green">check_circle</i></b>
                            @else
                                <b><i class="material-icons red">highlight_off</i></b>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$tipo->id}}" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <div class="modal fade" id="exampleModal{{$tipo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Tipo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" action="/admin/tiposOcorrencias/editar/{{$tipo->id}}" method="POST">
                                                @csrf
                                                <div class="col-12 form-floating">
                                                    <input class="form-control" name="codigo" type="text" id="codigo" value="{{$tipo->codigo}}" required/>
                                                    <label for="codigo">Código</label>
                                                </div>
                                                <div class="col-12 form-floating">
                                                    <input class="form-control" name="descricao" type="text" id="descricao" value="{{$tipo->descricao}}" required/>
                                                    <label for="descricao">Descrição</label>
                                                </div>
                                                <div class="col-12 form-floating">
                                                    <select class="form-select" id="tipo" name="tipo" required>
                                                        <option value="{{$tipo->tipo}}">@if($tipo->tipo=="despontuacao") Despontuação @else Elogio @endif</option>
                                                            @if($tipo->tipo=="elogio")    
                                                            <option value="despontuacao">Despontuação</option>
                                                            @else
                                                            <option value="elogio">Elogio</option>
                                                            @endif
                                                    </select>
                                                    <label for="tipo">Tipo</label>
                                                </div> 
                                                <div class="col-12 form-floating">
                                                    <input class="form-control" name="pontuacao" type="text" id="pontuacao" value="{{$tipo->pontuacao}}" required/>
                                                    <label for="pontuacao">Pontuação</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($tipo->ativo==1)
                                <a href="/admin/tiposOcorrencias/apagar/{{$tipo->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            @else
                                <a href="/admin/tiposOcorrencias/apagar/{{$tipo->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            @endif
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