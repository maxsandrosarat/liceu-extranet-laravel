@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
    <a href="/admin/provas/{{$ano}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    @if($ensino=="fund" || $ensino=="todos")
            <h5 class="card-title">Painel de Conteúdos de Prova - Ensino Fundamental - {{$prova->descricao}} - {{$prova->bimestre}}º Bimestre - Ano: {{$prova->ano}}</h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="3" style="white-space: nowrap; text-align: center; vertical-align: middle;">Disciplinas</th>
                        <th colspan="{{count($fundTurmas)}}">Turmas</th>
                    </tr>
                    <tr>
                        @foreach($fundSeries as $fundSerie)
                        @php
                            $qtdTurmas = 0;
                            foreach($fundTurmas as $fundTurma){
                                if($fundTurma->serie==$fundSerie->serie){
                                    $qtdTurmas++;
                                }
                            }
                        @endphp
                        <th colspan="{{$qtdTurmas}}">{{$fundSerie->serie}}º</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($fundTurmas as $fundTurma)
                        <th>{{$fundTurma->serie}}º{{$fundTurma->turma}}{{$fundTurma->turno}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fundDiscs as $fundDisc)
                    @php
                        $fundPertence = 0;
                    @endphp
                    <tr>
                        <td>{{$fundDisc->nome}}
                            @foreach($fundTurmas as $fundTurma)
                            @php
                                $fundPertence = 0;
                                foreach($fundDisc->turmas as $turmaFund){
                                    if($turmaFund->serie==$fundTurma->serie && $turmaFund->turma==$fundTurma->turma){
                                        $fundPertence = 1;
                                    }
                                }
                            @endphp
                            </td>
                            @foreach ($contFunds as $contFund)
                                @if($contFund->disciplina->nome == $fundDisc->nome && $contFund->turma->serie==$fundTurma->serie && $contFund->turma->turma==$fundTurma->turma)
                                        @if($fundPertence===0) <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td>
                                        @else
                                            @if($contFund->descricao=='')
                                                <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar{{$contFund->id}}"><i class="material-icons md-18">cloud_upload</i></button>
                                            @else
                                                <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar{{$contFund->id}}"><i class="material-icons md-50 green" data-toggle="tooltip" data-placement="left" title="Enviado">check_circle</i></a><br/>
                                            @endif
                                            </td>
                                            <!-- Modal Anexar -->
                                                    <div style="text-align: center;" class="modal fade" id="exampleModalAnexar{{$contFund->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Conteúdo do(a) Prova {{$prova->descricao}} - {{$contFund->disciplina->nome}} - {{$contFund->turma->serie}}º{{$contFund->turma->turma}}{{$contFund->turma->turno}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5>Conteúdo</h5>
                                                                <form method="POST" action="/admin/conteudosProvas/anexar/{{$contFund->id}}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="col-12 form-floating">
                                                                        <textarea class="form-control" name="descricao" id="descricao" rows="50" cols="40" placeholder="Escreva aqui ou copei e cole do arquivo, a descrição completa dos conteúdos que serão cobrados." @if($contFund->descricao=='') required @endif>@if($contFund->descricao!=''){{$contFund->descricao}}@endif</textarea>
                                                                        <label for="descricao">Descrição</label>
                                                                    </div>
                                                                    <div class="col-3 form-floating">
                                                                        <input class="form-control" type="date" id="dataAplicacao" name="dataAplicacao" @if($contFund->data_aplicacao==null) placeholder="Data Aplicação" required @else value="{{date("Y-m-d", strtotime($contFund->data_aplicacao))}}" @endif>
                                                                        <label for="dataAplicacao">Data Aplicação</label>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </tr>
                    @endforeach
                    <tr style="background-color: green;">
                        <td style="color: white;"><b>Gerar Arquivo (PDF)</b></td>
                        @foreach ($fundTurmas as $fundTurma)
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPdf{{$fundTurma->id}}">
                                {{$fundTurma->serie}}º{{$fundTurma->turma}}{{$fundTurma->turno}}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalPdf{{$fundTurma->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Gerar Arquivo (PDF) - {{$fundTurma->serie}}º {{$fundTurma->turma}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-conteudos{{$fundTurma->id}}" method="POST" action="/admin/conteudosProvas/pdf/{{$prova->id}}/{{$fundTurma->id}}">
                                        @csrf
                                        <h5>Selecione as disciplinas:</h5>
                                        <ul class="list-group">
                                        @foreach ($fundTurma->disciplinas as $fundDisc)
                                            @if($fundDisc->ativo==1)
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" name="disciplinas[]" value="{{$fundDisc->id}}" checked>{{$fundDisc->nome}}
                                            </li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="form-conteudos{{$fundTurma->id}}" formtarget="_blank" class="btn btn-success">Gerar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            </div>
        @endif
        @if($ensino=="medio" || $ensino=="todos")
            <h5 class="card-title">Painel de Conteúdos de Provas - Ensino Médio - {{$prova->descricao}} - {{$prova->bimestre}}º Bimestre - Ano: {{$prova->ano}}</h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-bordered table-hover" style="text-align: center;">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="3" style="white-space: nowrap; text-align: center; vertical-align: middle;">Disciplinas</th>
                        <th colspan="{{count($medioTurmas)}}">Turmas</th>
                    </tr>
                    <tr>
                        @foreach($medioSeries as $medioSerie)
                        @php
                            $qtdTurmas = 0;
                            foreach($medioTurmas as $medioTurma){
                                if($medioTurma->serie==$medioSerie->serie){
                                    $qtdTurmas++;
                                }
                            }
                        @endphp
                        <th colspan="{{$qtdTurmas}}">{{$medioSerie->serie}}º</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($medioTurmas as $medioTurma)
                        <th>{{$medioTurma->serie}}º{{$medioTurma->turma}}{{$medioTurma->turno}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medioDiscs as $medioDisc)
                    @php
                        $medioPertence = 0;
                    @endphp
                    <tr>
                        <td>{{$medioDisc->nome}}
                            @foreach($medioTurmas as $medioTurma)
                            @php
                                $medioPertence = 0;
                                foreach($medioDisc->turmas as $turmaMedio){
                                    if($turmaMedio->serie==$medioTurma->serie && $turmaMedio->turma==$medioTurma->turma){
                                        $medioPertence = 1;
                                    }
                                }
                            @endphp
                            </td>
                            @foreach ($contMedios as $contMedio)
                                @if($contMedio->disciplina->nome == $medioDisc->nome && $contMedio->turma->serie==$medioTurma->serie && $contMedio->turma->turma==$medioTurma->turma)
                                    @if($medioPertence===0) <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td> 
                                    @else
                                        @if($contMedio->descricao=='')
                                        <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar{{$contMedio->id}}"><i class="material-icons md-18">cloud_upload</i></button> 
                                    @else
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar{{$contMedio->id}}"><i class="material-icons md-50 green" data-toggle="tooltip" data-placement="left" title="Enviado">check_circle</i></a><br/>
                                    @endif
                                    </td>
                                    <!-- Modal Anexar -->
                                            <div style="text-align: center;" class="modal fade" id="exampleModalAnexar{{$contMedio->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Conteúdo do(a) {{$prova->descricao}} - {{$contMedio->disciplina->nome}} - {{$contMedio->turma->serie}}º{{$contMedio->turma->turma}}{{$contMedio->turma->turno}}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Conteúdo</h5>
                                                        <form method="POST" action="/admin/conteudosProvas/anexar/{{$contMedio->id}}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="col-12 form-floating">
                                                                <textarea class="form-control" name="descricao" id="descricao" rows="50" cols="40" placeholder="Escreva aqui ou copei e cole do arquivo, a descrição completa dos conteúdos que serão cobrados." @if($contMedio->descricao=='') required @endif>@if($contMedio->descricao!=''){{$contMedio->descricao}}@endif</textarea>
                                                                <label for="descricao">Descrição</label>
                                                            </div>
                                                            <div class="col-3 form-floating">
                                                                <input class="form-control" type="date" id="dataAplicacao" name="dataAplicacao" @if($contMedio->data_aplicacao==null) placeholder="Data Aplicação" required @else value="{{date("Y-m-d", strtotime($contMedio->data_aplicacao))}}" @endif>
                                                                <label for="dataAplicacao">Data Aplicação</label>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                            </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                @endif
                                @endif
                            @endforeach
                            @endforeach
                    </tr>
                    @endforeach
                    <tr style="background-color: green;">
                        <td style="color: white;"><b>Gerar Arquivo (PDF)</b></td>
                        @foreach ($medioTurmas as $medioTurma)
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPdf{{$medioTurma->id}}">
                                {{$medioTurma->serie}}º{{$medioTurma->turma}}{{$medioTurma->turno}}
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalPdf{{$medioTurma->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Gerar Arquivo (PDF) - {{$medioTurma->serie}}º {{$medioTurma->turma}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-conteudos{{$medioTurma->id}}" method="POST" action="/admin/conteudosProvas/pdf/{{$prova->id}}/{{$medioTurma->id}}">
                                        @csrf
                                        <h5>Selecione as disciplinas:</h5>
                                        <ul class="list-group">
                                        @foreach ($medioTurma->disciplinas as $medioDisc)
                                            @if($medioDisc->ativo==1)
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" name="disciplinas[]" value="{{$medioDisc->id}}" checked>{{$medioDisc->nome}}
                                            </li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="form-conteudos{{$medioTurma->id}}" formtarget="_blank" class="btn btn-success">Gerar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
            </div>
        @endif
    </div>
    </div>
</div>
@endsection
