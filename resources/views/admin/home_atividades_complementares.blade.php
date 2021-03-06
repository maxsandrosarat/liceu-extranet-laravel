@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5 class="card-title">Atividades Complementares - {{$ano}}</h5>
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="habilitarSubmit();" data-toggle="tooltip" data-placement="bottom" title="Criar atividade">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            @if(count($atividades)==0)
                <div class="alert alert-danger" role="alert">
                    Sem Atividades Complementares cadastradas!
                </div>
            @else
            <div class="row">
                <div class="col">
                    <form class="row gy-2 gx-3 align-items-center" action="/admin/atividadeComplementar" method="GET">
                        @csrf
                        <div class="col-auto form-floating">
                            <select class="form-select" id="ano" name="ano">
                                <option value="">Selecione</option>
                                @foreach ($anos as $an)
                                <option value="{{$an->ano}}">{{$an->ano}}</option>
                                @endforeach
                            </select>
                            <label for="ano">Ano:</label>
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="btn btn-primary" value="Selecionar">
                        </div> 
                    </form>
                </div>
                <div class="col" style="text-align: right;">
                    <h5>Baixe o modelo da M??scara</h5>
                    <a type="button" class="btn btn-info" href="/admin/templates/download/mascara">Baixar M??scara</a>
                </div>
            </div>
            <br/>
            <div class="table-responsive-xl">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Data Inicio</th>
                        <th>Data Fim</th>
                        <th>Descri????o</th>
                        <th>Bimestre</th>
                        <th>Ano</th>
                        <th>Anexo(s)</th>
                        <th>A????es</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $data = date("Y-m-d");
                    @endphp
                    @foreach ($atividades as $atividade)
                    <tr @if($atividade->data_fim==$data) style="color:orange" @else @if($atividade->data_fim>$data) style="color:green" @else @if($atividade->data_fim<$data) style="color:red" @endif @endif @endif>
                        <td>{{date("d/m/Y", strtotime($atividade->data_inicio))}}</td>
                        <td>{{date("d/m/Y", strtotime($atividade->data_fim))}}</td>
                        <td>{{$atividade->descricao}}</td>
                        <td>{{$atividade->bimestre}}?? Bimestre</td>
                        <td>{{$atividade->ano}}</td>
                        <td>
                            <a href="/admin/atividadeComplementar/painel/{{$atividade->id}}" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                        </td>
                        <td> 
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalEdit{{$atividade->id}}" data-toggle="tooltip" data-placement="left" title="Editar"><i class="material-icons md-18">edit</i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalEdit{{$atividade->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar atividade - {{$atividade->descricao}} - {{$atividade->bimestre}}?? Bimestre ({{$atividade->ano}})</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/admin/atividadeComplementar/editar/{{$atividade->id}}" method="POST">
                                            @csrf
                                            <div class="col-12 form-floating">
                                                <input type="text" class="form-control" name="descricao" id="descricao" value="{{$atividade->descricao}}" required>
                                                <label for="descricao">Descri????o</label>
                                            </div>
                                            <div class="col-12 form-floating">
                                                <input type="date" class="form-control" name="dataInicio" id="dataInicio" value="{{date("Y-m-d", strtotime($atividade->data_inicio))}}" required>
                                                <label for="dataInicio">Data Inicio</label>
                                            </div>
                                            <div class="col-12 form-floating">
                                                <input type="date" class="form-control" name="dataFim" id="dataFim" value="{{date("Y-m-d", strtotime($atividade->data_fim))}}" required>
                                                <label for="dataFim">Data Fim</label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{$atividade->id}}"><i class="material-icons md-18">delete</i></button></td>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="exampleModalDelete{{$atividade->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Excluir atividade: {{$atividade->descricao}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Tem certeza que deseja excluir essa atividade?</h5>
                                            <p>N??o ser?? possivel reverter esta a????o.</p>
                                            <a href="/admin/atividadeComplementar/apagar/{{$atividade->id}}" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @endif
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Criar atividade</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <form action="/admin/atividadeComplementar" method="POST">
                    @csrf
                    <div class="col-12 form-floating">
                        <input class="form-control" type="date" name="dataInicio" id="dataInicio" required>
                        <label for="dataInicio">Data Inicio</label>
                    </div>
                    <div class="col-12 form-floating">
                        <input class="form-control" type="date" name="dataFim" id="dataFim" required>
                        <label for="dataFim">Data Fim</label>
                    </div>
                    <div class="col-12 form-floating">
                        <input class="form-control" type="text"  name="descricao" id="descricao" placeholder="Descri????o da atividade" required>
                        <label for="descricao">Descri????o da Atividade</label>
                    </div>  
                    <div class="col-12 form-floating">
                        <select class="form-select" id="bimestre" name="bimestre" required>
                            <option value="">Selecione</option>
                            <option value="1">1??</option>
                            <option value="2">2??</option>
                            <option value="3">3??</option>
                            <option value="4">4??</option>
                        </select>
                        <label for="bimestre">Bimestre</label>
                    </div>
                    <div class="col-12 form-floating">
                        <input class="form-control" type="number" name="ano" id="ano" placeholder="Ano" required>
                        <label for="ano">Ano</label>
                    </div>
                <hr/>
                <div class="modal-footer">
                <button type="submit" id="processamento" class="btn btn-primary">Gerar</button>
                </div>
                </form>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection