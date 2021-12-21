@extends('layouts.app', ["current"=>"provas"])

@section('body')
<div class="card border">
    <div class="card-body">
        <a href="/outro/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        @if(session('mensagem'))
            <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                {{session('mensagem')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h5 class="card-title">Provas - {{$ano}}</h5>
        @if(count($provas)==0)
            <div class="alert alert-danger" role="alert">
                Sem provas cadastradas!
            </div>
        @else
        <div class="row">
            <div class="col">
                <form class="row gy-2 gx-3 align-items-center" action="/outro/provas" method="GET">
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
                    <th>Prazo Entrega</th>
                    <th>Descrição</th>
                    <th>Bimestre</th>
                    <th>Ano</th>
                    <th>Série(s)</th>
                    <th>Conteúdos</th>
                    <th>Questões</th>
                </tr>
            </thead>
            <tbody>
                @php
                $data = date("Y-m-d");
                @endphp
                @foreach ($provas as $prova)
                <tr @if($prova->prazo==$data) style="color:orange" @else @if($prova->prazo>$data) style="color:green" @else @if($prova->prazo<$data) style="color:red" @endif @endif @endif>
                    <td>{{date("d/m/Y", strtotime($prova->prazo))}}</td>
                    <td>{{$prova->descricao}}</td>
                    <td>{{$prova->bimestre}}° Bimestre</td>
                    <td>{{$prova->ano}}</td>
                    <td>
                        <ul>
                        @foreach ($prova->series as $serie)
                            <li>{{$serie->turma->serie}}º ANO {{$serie->turma->turma}}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="/outro/conteudosProvas/painel/{{$prova->id}}" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                    </td>
                    <td> 
                        <a href="/outro/provas/painel/{{$prova->id}}" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
</div>
@endsection