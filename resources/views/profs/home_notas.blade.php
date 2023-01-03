@extends('layouts.app', ["current"=>"notas"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5 class="card-title">Notas - {{$ano}}</h5>
            @if(count($notas)==0)
                <div class="alert alert-danger" role="alert">
                    Sem notas cadastradas!
                </div>
            @else
            <div class="row">
                <div class="col">
                    <form class="row gy-2 gx-3 align-items-center" action="/prof/notas" method="GET">
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
                    </tr>
                </thead>
                <tbody>
                    @php
                    $data = date("Y-m-d");
                    @endphp
                    @foreach ($notas as $nota)
                    <tr @if($nota->prazo==$data) style="color:orange" @else @if($nota->prazo>$data) style="color:green" @else @if($nota->prazo<$data) style="color:red" @endif @endif @endif>
                        <td>{{date("d/m/Y", strtotime($nota->prazo))}}</td>
                        <td>{{$nota->descricao}}</td>
                        <td>{{$nota->bimestre}}° Bimestre</td>
                        <td>{{$nota->ano}}</td>
                        <td>
                            <ul>
                            @foreach ($nota->series as $serie)
                                <li>
                                    <a href="/prof/notas/painel/{{$nota->id}}/{{$serie->turma->id}}" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel">{{$serie->turma->serie}}º ANO {{$serie->turma->turma}}</a>
                                </li>
                            @endforeach
                            </ul>
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