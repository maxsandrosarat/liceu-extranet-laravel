@extends('layouts.app', ["current"=>"administrativo"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Disciplinas</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(count($discs)==0)
                <div class="alert alert-danger" role="alert">
                    Sem disciplinas cadastradas!
                </div>
            @else
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Ensino</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discs as $disc)
                    <tr>
                        <td>{{$disc->id}}</td>
                        <td>{{$disc->nome}}</td>
                        <td>@if($disc->ensino=='fund') Fundamental @else Médio @endif</td>
                        <td>
                            @if($disc->ativo==1)
                                <b><i class="material-icons green">check_circle</i></b>
                            @else
                                <b><i class="material-icons red">highlight_off</i></b>
                            @endif
                        </td>
                        <td>
                            @if($disc->ativo==1)
                                <a href="/admin/disciplinas/apagar/{{$disc->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            @else
                                <a href="/admin/disciplinas/apagar/{{$disc->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Disciplina">
        <i class="material-icons blue md-60">add_circle</i>
    </a>
  
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Disciplinas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border">
                        <div class="card-body">
                            <form class="row g-3" action="/admin/disciplinas" method="POST">
                                @csrf
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="nome" type="text" id="nome" placeholder="Nome da Disciplina" required/>
                                    <label for="nome">Nome da Disciplina</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="ensino" name="ensino" required>
                                        <option value="">Selecione</option>
                                        <option value="fund">Fundamental</option>
                                        <option value="medio">Médio</option>
                                    </select>
                                    <label for="ensino">Ensino</label>
                                </div> 
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>    
                </div> 
            </div>
            </div>
        </div>
@endsection