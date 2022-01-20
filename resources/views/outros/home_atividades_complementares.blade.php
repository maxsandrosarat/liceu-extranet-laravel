@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/outro" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5 class="card-title">Atividades Complementares - {{$ano}}</h5>
            @if(count($atividades)==0)
                <div class="alert alert-danger" role="alert">
                    Sem Atividades Complementares cadastradas!
                </div>
            @else
            <div class="row">
                <div class="col">
                    <form class="row gy-2 gx-3 align-items-center" action="/outro/atividadeComplementar" method="GET">
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
                    <h5>Baixe o modelo da Máscara</h5>
                    <a type="button" class="btn btn-info" href="/outro/templates/download/mascara">Baixar Máscara</a>
                </div>
            </div>
            <br/>
            <div class="table-responsive-xl">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Data Inicio</th>
                        <th>Data Fim</th>
                        <th>Descrição</th>
                        <th>Bimestre</th>
                        <th>Ano</th>
                        <th>Anexo(s)</th>
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
                        <td>{{$atividade->bimestre}}° Bimestre</td>
                        <td>{{$atividade->ano}}</td>
                        <td>
                            <a href="/outro/atividadeComplementar/painel/{{$atividade->id}}" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                        </td>
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