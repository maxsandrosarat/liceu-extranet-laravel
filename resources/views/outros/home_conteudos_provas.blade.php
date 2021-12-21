@extends('layouts.app', ["current"=>"conteudos"])

@section('body')
    <div class="card border">
        <div class="card-body">
            @if(session('mensagem'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p>{{session('mensagem')}}</p>
            </div>
            @endif
            @if(count($conteudosProvas)==0)
                <div class="alert alert-danger" role="alert">
                    Sem provas cadastradas!
                </div>
            @else
            <div class="row">
                <div class="col" style="text-align: left">
                    <form action="/outro/conteudosProvas" method="GET">
                        @csrf
                        <label for="ano">Selecione o ano:
                        <select class="custom-select" id="ano" name="ano">
                            <option value="">Selecione</option>
                            @foreach ($anos as $an)
                            <option value="{{$an->ano}}">{{$an->ano}}</option>
                            @endforeach
                        </select></label>
                        <input type="submit" class="btn btn-primary" value="Selecionar">
                    </form>
                </div>
            </div>
            <h5 class="card-title">Questões para Provas - {{$ano}}</h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código Prova</th>
                        <th>Descrição</th>
                        <th>Bimestre</th>
                        <th>Ano</th>
                        <th>Série(s)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($conteudosProvas as $contProv)
                    <tr>
                        <td>{{$contProv->id}}</td>
                        <td>{{$contProv->descricao}}</td>
                        <td>{{$contProv->bimestre}}° Bimestre</td>
                        <td>{{$contProv->ano}}</td>
                        <td>
                            <ul>
                            @foreach ($contProv->series as $serie)
                                <li>{{$serie->serie}}º ANO</li>
                            @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="/outro/conteudosProvas/painel/{{$contProv->id}}" class="badge badge-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-48">attach_file</i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @endif
        </div>
    </div>
    <br><br>
    <a href="/outro/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
@endsection