@extends('layouts.app', ["current"=>"administrativo"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Turmas</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(count($turmas)==0)
                <br/><br/>
                <div class="alert alert-danger" role="alert">
                    Sem turmas cadastradas!
                </div>
            @else
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Série</th>
                        <th>Turma</th>
                        <th>Turno</th>
                        <th>Ensino</th>
                        <th>Disciplinas</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($turmas as $turma)
                    <tr>
                        <td>{{$turma->id}}</td>
                        <td>{{$turma->serie}}º ANO</td>
                        <td>{{$turma->turma}}</td>
                        <td>@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif</td>
                        <td>@if($turma->ensino=='fund') Fundamental @else Médio @endif</td>
                        <td>
                            @php
                                $qtdDiscs = 0;
                                foreach($turma->disciplinas as $disc){
                                    $qtdDiscs++;
                                }
                            @endphp
                            
                                
                                <button type="button" class="btn btn-primary position-relative" data-placement="bottom" title="{{$qtdDiscs}} disciplinas vinculadas" data-bs-toggle="modal" data-bs-target="#modalDiscsTurma{{$turma->id}}">Disciplinas<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{$qtdDiscs}}</span></button>
                                <!-- Modal Turmas-->
                                <div class="modal fade" id="modalDiscsTurma{{$turma->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-discsTurma{{$turma->id}}" action="/admin/turmas/disciplinas" method="POST" style="text-align: center;">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" name="turma" value="{{$turma->id}}">
                                                        <ul class="list-group">
                                                            @php
                                                                $ensino = '';
                                                                $ensino = $turma->ensino;
                                                            @endphp
                                                            @foreach ($discs as $disciplina)
                                                                @if($disciplina->ensino==$ensino)
                                                                <li class="list-group-item" @if($disciplina->ativo==false) style="color: red;" @endif>
                                                                    <div class="form-group form-check">
                                                                        <input type="checkbox" class="form-check-input" id="turma{{$turma->id}}" name="disciplinas[]" value="{{$disciplina->id}}" 
                                                                        @if(count($turma->disciplinas)>0)
                                                                        @foreach($turma->disciplinas as $disc)
                                                                                @if($disc->id==$disciplina->id) checked @endif
                                                                        @endforeach
                                                                        @endif
                                                                        >
                                                                        <label class="form-check-label" for="turma{{$turma->id}}">{{$disciplina->nome}} (@if($disciplina->ensino=='fund') Fundamental @else Médio @endif)</label>
                                                                    </div>
                                                                </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" form="form-discsTurma{{$turma->id}}" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </td>
                        <td>
                            @if($turma->ativo==1)
                                <b><i class="material-icons green">check_circle</i></b>
                            @else
                                <b><i class="material-icons red">highlight_off</i></b>
                            @endif
                        </td>
                        <td>
                        @if($turma->ativo==1)
                            <a href="/admin/turmas/apagar/{{$turma->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                        @else
                            <a href="/admin/turmas/apagar/{{$turma->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
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
    <a type="button" class="float-button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Turma">
        <i class="material-icons blue md-60">add_circle</i>
    </a>
  
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Turma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border">
                        <div class="card-body">
                            <form class="row g-3" action="/admin/turmas" method="POST">
                                @csrf
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="serie" type="number" id="serie" placeholder="Série da Turma" required/>
                                    <label for="serie">Série da Turma</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="turma" type="text" id="turma" placeholder="Turma" required/>
                                    <label for="turma">Turma</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="turno" name="turno">
                                        <option value="">Selecione</option>
                                        <option value="M">Matutino</option>
                                        <option value="V">Vespertino</option>
                                        <option value="N">Noturno</option>
                                    </select>
                                    <label for="turno">Turno</label>
                                </div>  
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="ensino" name="ensino">
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