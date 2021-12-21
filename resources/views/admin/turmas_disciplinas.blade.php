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
        <a type="button" class="float-button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Disciplinas para as Turmas">
            <i class="material-icons blue md-60">add_circle</i>
        </a>
        @if(count($turmaDiscs)==0)
            <br/><br/>
            <div class="alert alert-danger" role="alert">
                Sem disciplinas para as turmas cadastradas!
            </div>
        @else
        <div class="table-responsive-xl">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Turma</th>
                    <th>Disciplinas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($turmaDiscs as $turmaDisc)
                <tr>
                    <td>{{$turmaDisc->serie}}º ANO {{$turmaDisc->turma}} (@if($turmaDisc->turno=='M') Matutino @else @if($turmaDisc->turno=='V') Vespertino @else Noturno @endif @endif)</td>
                    <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{{$turmaDisc->id}}">
                            Disciplinas
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$turmaDisc->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Disciplinas da Turma: {{$turmaDisc->serie}}º ANO {{$turmaDisc->turma}} (@if($turmaDisc->turno=='M') Matutino @else @if($turmaDisc->turno=='V') Vespertino @else Noturno @endif @endif)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if(count($turmaDisc->disciplinas)==0)
                                    <h5>Nenhuma disciplina vinculada!</h5>
                                    @else
                                    <ul class="list-group">
                                        @foreach ($turmaDisc->disciplinas as $disciplina)
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @if($disciplina->ativo==false) style="color: red;" @endif>{{$disciplina->nome}} <a href="/admin/turmasDiscs/apagar/{{$turmaDisc->id}}/{{$disciplina->id}}"><i class="material-icons red" data-toggle="tooltip" data-placement="bottom" title="Desvincular">remove_circle</i></a></li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        @endif
    </div>
    <br>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Disciplinas para Turmas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border">
                        <div class="card-body">
                            <form class="row g-3" action="/admin/turmasDiscs" method="POST" style="text-align: center;">
                                @csrf
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="turma" name="turma">
                                        <option value="">Selecione a turma</option>
                                        @foreach ($turmas as $turma)
                                        <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                        @endforeach
                                    </select>
                                    <label for="turma">Turma</label>
                                </div>
                                <h3>Marque Todas as Disciplinas</h3>
                                <ul class="list-group">
                                    <li class="list-group-item list-group-item-action">
                                        <input class="form-check-input" type="checkbox" id="todasFund" name="disciplina" value="todasFund">
                                        <label  class="form-check-label" for="todasFund">Todas Fundamental</label>
                                    </li>
                                    <li class="list-group-item list-group-item-action">
                                        <input class="form-check-input" type="checkbox" id="todasMedio" name="disciplina" value="todasMedio">
                                        <label class="form-check-label" for="todasMedio">Todas Médio</label>
                                    </li>
                                </ul>
                                <hr/>
                                <h3>Ou Marque as Disciplinas</h3>
                                <ul class="list-group">
                                @foreach ($discs as $disc)
                                    <li class="list-group-item list-group-item-action">
                                        <input class="form-check-input" type="checkbox" id="disciplina{{$disc->id}}" name="disciplinas[]" value="{{$disc->id}}">
                                        <label class="form-check-label" for="disciplina{{$disc->id}}">{{$disc->nome}} (@if($disc->ensino=="fund") Fundamental @else Médio @endif)</label>
                                    </li>
                                @endforeach
                                </ul>
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
    </div>
</div>
</div>
</div>
@endsection