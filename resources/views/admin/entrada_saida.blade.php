@extends('layouts.app', ["current"=>"estoque"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/estoque" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lançamentos de Entradas/Saídas</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- Button trigger modal -->
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Lançar Entrada e Saída">
                <i class="material-icons blue md-60">add_circle</i>
            </a>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lançamento de Entrada e Saída</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" action="/admin/entradaSaida" method="POST">
                                @csrf
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" type="radio" id="entrada" name="tipo" value="entrada" required>
                                    <label class="form-check-label" for="entrada">
                                        Entrada
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" type="radio" id="saida" name="tipo" value="saida" required>
                                    <label class="form-check-label" for="entrada">
                                        Saída
                                    </label>
                                </div>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="data" type="date" id="data" value="{{date("Y-m-d")}}" required/>
                                    <label for="data">Selecione a Data</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="produtos" name="produto" required>
                                        <option value="">Selecione</option>
                                        @foreach ($prods as $prod)
                                            @if($prod->ativo==true)
                                            <option value="{{$prod->id}}">{{$prod->nome}} - Estoque: {{$prod->estoque}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="produtos">Produto</label>
                                </div>  
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="qtd" type="number" id="qtd" placeholder="Quantidade"/>
                                    <label for="qtd">Quantidade</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="req" type="text" id="req" placeholder="Requisitante"/>
                                    <label for="req">Requisitante</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                                </div>
                            </form>
                        </div> 
                    </div> 
                </div>
            </div>
            @if(count($rels)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem movimentos cadastrados! Faça novo movimento no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        @else @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/entradaSaida" class="btn btn-success">Voltar</a>
                        @endif
                        @endif
                    </div>
            @else
            <div class="card border">
            <h5>Filtros: </h5>
            <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/entradaSaida/filtro">
                @csrf
                <div class="col-auto form-floating">
                    <select class="form-select" id="tipo" name="tipo">
                        <option value="">Selecione o tipo</option>
                        <option value="entrada">Entrada</option>
                        <option value="saida">Saída</option>
                    </select>
                    <label for="tipo">Tipo</label>
                </div>
                <div class="col-auto form-floating">
                    <select class="form-select" id="produto" name="produto">
                        <option value="">Selecione</option>
                        @foreach ($prods as $prod)
                        <option @if($prod->ativo==false) style="color: red;" @endif value="{{$prod->id}}">{{$prod->nome}}</option>
                        @endforeach
                    </select>
                    <label for="produto">Produto</label>
                </div>
                <div class="col-auto form-floating">
                    <input class="form-control" name="dataInicio" type="date" id="dataInicio"/>
                    <label for="dataInicio">Data Início</label>
                </div>
                <div class="col-auto form-floating">
                    <input class="form-control" name="dataFim" type="date" id="dataFim"/>
                    <label for="dataFim">Data Fim</label>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                </div>
            </form>
            </div>
            <div class="table-responsive-xl">
            <table id="yesprint" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Requisitante</th>
                        <th>Usuário</th>
                        <th>Data</th>
                        <th>Lançamento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rels as $rel)
                    @if($rel->tipo=='entrada') <tr style="color:blue;"> @else <tr style="color:red;"> @endif
                        <td>{{$rel->id}}</td>
                        <td>@if($rel->tipo=='entrada') Entrada @else Saída @endif</td>
                        <td>{{$rel->produto_nome}}</td>
                        <td>{{$rel->quantidade}}</td>
                        <td>{{$rel->requisitante}}</td>
                        <td>{{$rel->usuario}}</td>
                        <td>{{date("d/m/Y", strtotime($rel->data))}}</td>
                        <td>{{date("d/m/Y H:i", strtotime($rel->created_at))}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
			<div class="card-footer">
            {{ $rels->links() }}
			</div>
            @endif
        </div>
    </div>
</div>
@endsection