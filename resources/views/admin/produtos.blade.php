@extends('layouts.app', ["current"=>"estoque"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/estoque" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Produtos</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Produto">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border">
                            <div class="card-body">
                                <form class="row g-3" action="/admin/produtos" method="POST">
                                    @csrf
                                    <div class="col-12 form-floating">
                                        <input class="form-control" name="nomeProduto" type="text" id="nomeProduto" placeholder="Nome do Produto" required/>
                                        <label for="nomeProduto">Nome do Produto</label>
                                    </div>
                                    <div class="col-12 form-floating">
                                        <input class="form-control" name="estoqueProduto" type="number" id="estoqueProduto" placeholder="Estoque do Produto" required/>
                                        <label for="estoqueProduto">Estoque do Produto</label>
                                    </div>
                                    <div class="form-floating">
                                        <select class="form-select" id="categoriaProduto" name="categoriaProduto" required>
                                            <option value="">Selecione</option>
                                            @foreach ($cats as $cat)
                                                <option value="{{$cat->id}}">{{$cat->nome}}</option>
                                            @endforeach
                                        </select>
                                        <label for="categoriaProduto">Categoria</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sn">Cadastrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            @if(count($prods)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem produtos cadastrados! Faça novo cadastro no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/produtos" class="btn btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5>Filtros: </h5>
                <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/produtos/filtro">
                    @csrf
                    <div class="col-auto form-floating">
                        <input class="form-control" name="nomeProduto" type="text" id="nomeProduto" placeholder="Nome do Produto"/>
                        <label for="nomeProduto">Nome do Produto</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="categoria" name="categoria">
                            <option value="">Selecione</option>
                            @foreach ($cats as $cat)
                                <option value="{{$cat->id}}">{{$cat->nome}}</option>
                            @endforeach
                        </select>
                        <label for="categoria">Categoria</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="ativo" name="ativo" required>
                            <option value="1">Ativo: Sim</option>
                            <option value="0">Ativo: Não</option>
                        </select>
                        <label for="ativo">Ativo</label>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                    </div> 
                </form>
                </div>
            <h5>Exibindo {{$prods->count()}} de {{$prods->total()}} de Produtos ({{$prods->firstItem()}} a {{$prods->lastItem()}})</h5>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Estoque</th>
                        <th>Categoria</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prods as $prod)
                    <tr>
                        <td>{{$prod->id}}</td>
                        <td>{{$prod->nome}}</td>
                        <td>{{$prod->estoque}}</td>
                        <td>{{$prod->categoria->nome}}</td>
                        <td>
                            @if($prod->ativo==1)
                                <b><i class="material-icons green">check_circle</i></b>
                            @else
                                <b><i class="material-icons red">highlight_off</i></b>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$prod->id}}" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$prod->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Produto</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card border">
                                            <div class="card-body">
                                                <form class="row g-3" action="/admin/produtos/editar/{{$prod->id}}" method="POST">
                                                    @csrf
                                                    <div class="col-12 form-floating">
                                                        <input class="form-control" name="nomeProduto" type="text" id="nomeProduto" value="{{$prod->nome}}" required/>
                                                        <label for="nomeProduto">Nome do Produto</label>
                                                    </div>
                                                    <div class="form-floating">
                                                        <select class="form-select" id="categoriaProduto" name="categoriaProduto" required>
                                                            <option value="{{$prod->categoria->id}}">{{$prod->categoria->nome}}</option>
                                                            @foreach ($cats as $cat)
                                                                @if($cat->id==$prod->categoria->id || $cat->ativo==false)
                                                                @else
                                                                <option value="{{$cat->id}}">{{$cat->nome}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <label for="categoriaProduto">Categoria</label>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @if($prod->ativo==1)
                                <a href="/admin/produtos/apagar/{{$prod->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            @else
                                <a href="/admin/produtos/apagar/{{$prod->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                {{ $prods->links() }}
            </div>
        </div>
        @endif
        </div>
    </div>
@endsection
