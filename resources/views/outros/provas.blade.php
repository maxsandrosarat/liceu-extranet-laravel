@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
    <a href="/outro/provas/{{$ano}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    @if($ensino=="fund" || $ensino=="todos")
            <h5 class="card-title">Painel de Questões de Prova - Ensino Fundamental - {{$prova->descricao}} - {{$prova->bimestre}}º Bimestre - Ano: {{$prova->ano}}</h5>
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
                                        @if($contFund->arquivo=='')
                                        <td style="color:red; text-align: center;"> Pendente
                                    @else
                                        @if($contFund->comentario!="")
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contFund->id}}"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        @else
                                            @if($contFund->conferido==1) 
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contFund->id}}"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Conferido e Liberado">check_circle</i></a><br/>
                                            @else
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contFund->id}}"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Conferido">highlight_off</i></a><br/>
                                            @endif
                                        @endif
                                        <a type="button" class="badge bg-success" href="/outro/provas/download/{{$contFund->id}}"><i class="material-icons md-18">cloud_download</i></a>
                                        
                                    @endif
                                    </td>
                                            <!-- Modal Conferir -->
                                                <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf{{$contFund->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do {{$prova->descricao}} - {{$contFund->disciplina->nome}} - {{$contFund->turma->serie}}º{{$contFund->turma->turma}}{{$contFund->turma->turno}}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/outro/provas/conferir" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="id" value="{{$contFund->id}}">
                                                                        <h5>Comentário</h5>
                                                                        <textarea class="form-control" name="comentario" id="comentario" rows="10" cols="40" maxlength="500" @if($contFund->comentario=="") placeholder="Escreva um comentário apenas se encontrar algum problema, caso contrário não escreva." @endif>@if($contFund->comentario!=""){{$contFund->comentario}}@endif</textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
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
                </tbody>
            </table>
            </div>
        @endif
        @if($ensino=="medio" || $ensino=="todos")
            <h5 class="card-title">Painel de Questões de Provas - Ensino Médio - {{$prova->descricao}} - {{$prova->bimestre}}º Bimestre - Ano: {{$prova->ano}}</h5>
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
                                    @if($contMedio->arquivo=='')
                                    <td style="color:red; text-align: center;"> Pendente
                                @else
                                        @if($contMedio->comentario!="")
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contMedio->id}}"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        @else
                                            @if($contMedio->conferido==1) 
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contMedio->id}}"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Conferido e Liberado">check_circle</i></a><br/>
                                            @else
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contMedio->id}}"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Conferido">highlight_off</i></a><br/>
                                            @endif
                                        @endif
                                    <a type="button" class="badge bg-success" href="/outro/provas/download/{{$contMedio->id}}"><i class="material-icons md-18">cloud_download</i></a>
                                    
                                    @endif
                                </td>
                                        <!-- Modal Conferir -->
                                            <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf{{$contMedio->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do {{$prova->descricao}} - {{$contMedio->disciplina->nome}} - {{$contMedio->turma->serie}}º{{$contMedio->turma->turma}}{{$contMedio->turma->turno}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/outro/provas/conferir" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="{{$contMedio->id}}">
                                                                    <h5>Comentário</h5>
                                                                    <textarea class="form-control" name="comentario" id="comentario" rows="10" cols="40" maxlength="500" @if($contMedio->comentario=="") placeholder="Escreva um comentário apenas se encontrar algum problema, caso contrário não escreva." @endif>@if($contMedio->comentario!=""){{$contMedio->comentario}}@endif</textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
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
                </tbody>
            </table>
            </div>
        @endif
    </div>
    </div>
</div>
@endsection
