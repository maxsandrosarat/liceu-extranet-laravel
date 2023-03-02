@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Painel de Ocorrências</h5>
            @if($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>{{ $message }}</strong>
                </div>
            @endif
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(count($ocorrencias)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem ocorrências cadastradas!
                        @else @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/ocorrencias" class="btn btn-success">Voltar</a>
                        @endif
                        @endif
                    </div>
            @else
            <div class="card">
                <div class="card border">
                    <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/ocorrencias/filtro">
                        @csrf
                        <div class="col-auto form-floating">
                            <select class="form-select" id="tipo" name="tipo" style="width:170px;">
                                <option value="">Selecione o tipo</option>
                                @foreach ($tipos as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->codigo}} - {{$tipo->descricao}} - @if($tipo->tipo=="despontuacao") Despontuar: @else Elogio: @endif{{$tipo->pontuacao}}</option>
                                @endforeach
                            </select>
                            <label for="tipo">Tipo</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="aluno" name="aluno" style="width:170px;">
                                <option value="">Selecione o aluno</option>
                                @foreach ($alunos as $aluno)
                                <option value="{{$aluno->id}}">{{$aluno->name}}</option>
                                @endforeach
                            </select>
                            <label for="aluno">Aluno</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="dataInicio">
                            <label for="dataInicio">Data Início</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="dataFim">
                            <label for="dataFim">Data Fim</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <br/>
            <div class="table-responsive-xl">
            <b><h5 class="font-italic">Exibindo {{$ocorrencias->count()}} de {{$ocorrencias->total()}} de Ocorrências ({{$ocorrencias->firstItem()}} a {{$ocorrencias->lastItem()}})</u></h5></b>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tipo</th>
                        <th>Aluno</th>
                        <th>Turma</th>
                        <th>Disciplina</th>
                        <th>Data</th>
                        <th>Observação</th>
                        <th>Ações</th>
                        <th>Aprovação</th>
                        <th>Resp. Ciente</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ocorrencias as $ocorrencia)
                    <tr>
                        <td data-toggle="tooltip" data-placement="bottom" title="{{$ocorrencia->tipo_ocorrencia->descricao}}">{{$ocorrencia->tipo_ocorrencia->codigo}}</td>
                        <td data-toggle="tooltip" data-placement="bottom" title="Código: {{$ocorrencia->id}}">{{$ocorrencia->aluno->name}}</td>
                        <td>{{$ocorrencia->turma->serie}}º{{$ocorrencia->turma->turma}}{{$ocorrencia->turma->turno}}</td>
                        <td>{{$ocorrencia->disciplina->nome}}</td>
                        <td>{{date("d/m/Y", strtotime($ocorrencia->data))}}</td>
                        <td>
                            @if($ocorrencia->observacao=="")
                            @else
                            <button type="button" class="badge bg-info" data-bs-toggle="modal" data-bs-target="#exampleModalOb{{$ocorrencia->id}}">
                                <i class="material-icons white">visibility</i>
                            </button>
                            @endif
                            <div class="modal fade" id="exampleModalOb{{$ocorrencia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Observação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{$ocorrencia->observacao}}</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($ocorrencia->aprovado==1) 
                            @else
                                @if($ocorrencia->aprovado!==NULL)
                                @else
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalOcorrencia{{$ocorrencia->id}}" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <div class="modal fade" id="exampleModalOcorrencia{{$ocorrencia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Ocorrência</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/admin/ocorrencias/editar/{{$ocorrencia->id}}" method="POST">
                                            @csrf
                                            <h6><b>Aluno: {{$ocorrencia->aluno->name}}</b></h6>
                                            <h6><b>Tipo de Ocorrência: {{$ocorrencia->tipo_ocorrencia->codigo}} - {{$ocorrencia->tipo_ocorrencia->descricao}}</b></h6>
                                            <h6><b>Disciplina: {{$ocorrencia->disciplina->nome}}</b></h6>
                                            <br/>
                                            <label for="observacao">Observação</label>
                                            <textarea class="form-control" name="observacao" id="observacao" rows="10" cols="40" maxlength="500">{{$ocorrencia->observacao}}</textarea> 
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="badge bg-primary">Editar</button>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>

                            
                            @endif
                            @endif
                            <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{$ocorrencia->id}}" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="material-icons md-18">delete</i></button></td>
                                        <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg" id="exampleModalDelete{{$ocorrencia->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Ocorrência: {{$ocorrencia->tipo_ocorrencia->codigo}} - {{$ocorrencia->tipo_ocorrencia->descricao}} - {{$ocorrencia->aluno->name}} - {{$ocorrencia->disciplina->nome}} - {{date("d/m/Y", strtotime($ocorrencia->data))}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Tem certeza que deseja excluir essa ocorrência?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                        <a href="/admin/ocorrencias/apagar/{{$ocorrencia->id}}" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        </td>
                        <td>
                            @if($ocorrencia->aprovado==1)
                                <b><p style="color: green; font-size: 50%;"><i class="material-icons green">check_circle</i> APROVADO</p></b>
                            @else
                                @if($ocorrencia->aprovado!==NULL)
                                    <b><p style="color: red; font-size: 50%;"><i class="material-icons red">highlight_off</i>REPROVADO</p></b>
                                @else
                                    <a href="/admin/ocorrencias/aprovar/{{$ocorrencia->id}}" class="badge bg-success"><i class="material-icons white">thumb_up</i></a>
                                    <a href="/admin/ocorrencias/reprovar/{{$ocorrencia->id}}" class="badge bg-danger"><i class="material-icons white">thumb_down</i></a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($ocorrencia->responsavel_ciente==1) <i class="material-icons green">thumb_up</i> @else <i class="material-icons red">thumb_down</i> @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                {{$ocorrencias->links() }}
            </div>
            </div>
            @endif
        </div> 
    </div>
@endsection