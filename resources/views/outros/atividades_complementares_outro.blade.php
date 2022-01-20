@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
    <a href="/outro/atividadeComplementar/{{$ano}}" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    @if($ensino=="fund" || $ensino=="todos")
            <h5 class="card-title">Painel de Atividades Complementares - Ensino Fundamental - {{$atividade->descricao}} - {{$atividade->bimestre}}º Bimestre - Ano: {{$atividade->ano}}</h5>
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
                        <th colspan="{{$qtdTurmas}}">{{$fundSerie->serie}}º ANO</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($fundTurmas as $fundTurma)
                        <th>{{$fundTurma->serie}}º {{$fundTurma->turma}}</th>
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
                                        <td style="color:red; text-align: center;"> Pendente <br/>
                                    @else
                                        @if($contFund->comentario!="")
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contFund->id}}"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        @else
                                            @if($contFund->impresso==1) 
                                            <td style="text-align: center;"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Impresso e Liberado">check_circle</i><br/>
                                            @else
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contFund->id}}"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Impresso">highlight_off</i></a><br/>
                                            @endif
                                        @endif
                                        <p><b>{{date("d/m/Y", strtotime($contFund->data_utilizacao))}}</b></p>
                                        <a type="button" class="badge bg-success" href="/outro/atividadeComplementar/download/{{$contFund->id}}"><i class="material-icons md-18">cloud_download</i></a>
                                    @endif
                                    </td>
                                            <!-- Modal Conferir -->
                                                <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf{{$contFund->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Marcar como Impresso Atividade Complementar {{$atividade->descricao}} - {{$contFund->disciplina->nome}} - {{$contFund->turma->serie}}º ANO {{$contFund->turma->turma}}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5>Tem certeza que deseja marcar como impresso essa atividade?</h5>
                                                                <p>Não será possivel reverter esta ação.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <a href="/outro/atividadeComplementar/impresso/{{$contFund->id}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="right" title="Inativar">Marcar como Impresso</a>
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
            <h5 class="card-title">Painel de Atividades Complementares - Ensino Médio - {{$atividade->descricao}} - {{$atividade->bimestre}}º Bimestre - Ano: {{$atividade->ano}}</h5>
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
                        <th colspan="{{$qtdTurmas}}">{{$medioSerie->serie}}º ANO</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($medioTurmas as $medioTurma)
                        <th>{{$medioTurma->serie}}º {{$medioTurma->turma}}</th>
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
                                    <td style="color:red; text-align: center;"> Pendente <br/> 
                                @else
                                        @if($contMedio->comentario!="")
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contMedio->id}}"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        @else
                                            @if($contMedio->impresso==1) 
                                            <td style="text-align: center;"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Impresso e Liberado">check_circle</i><br/>
                                            @else
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf{{$contMedio->id}}"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Impresso">highlight_off</i></a><br/>
                                            @endif
                                        @endif
                                    <p><b>{{date("d/m/Y", strtotime($contMedio->data_utilizacao))}}</b></p>
                                    <a type="button" class="badge bg-success" href="/outro/atividadeComplementar/download/{{$contMedio->id}}"><i class="material-icons md-18">cloud_download</i></a>
                                    @endif
                                </td>
                                        <!-- Modal Conferir -->
                                            <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf{{$contMedio->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Marcar como Impresso Atividade Complementar {{$atividade->descricao}} - {{$contMedio->disciplina->nome}} - {{$contMedio->turma->serie}}º ANO {{$contMedio->turma->turma}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>Tem certeza que deseja marcar como impresso essa atividade?</h5>
                                                            <p>Não será possivel reverter esta ação.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <a href="/outro/atividadeComplementar/impresso/{{$contMedio->id}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="right" title="Inativar">Marcar como Impresso</a>
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