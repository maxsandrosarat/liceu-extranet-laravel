@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
    <div class="card border">
        <div class="card-body">
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a href="/outro/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/>
            <div class="row">
                <div class="col">
                    <form action="/outro/planejamentos" method="GET">
                        @csrf
                        <label for="ano">Selecione o ano:
                        <select class="form-select" id="ano" name="ano">
                            <option value="">Selecione</option>
                            @foreach ($anos as $an)
                            <option value="{{$an->ano}}">{{$an->ano}}</option>
                            @endforeach
                          </select></label>
                        <input type="submit" class="btn btn-primary" value="Selecionar">
                    </form>
                </div>
                <div class="col" style="text-align: right;">
                </div>
            </div>
            @if(count($planejamentos)==0)
                <div class="alert alert-danger" role="alert">
                    Sem planejamentos cadastrados para o ano {{$ano}}! Tente consultar outros anos!
                </div>
            @else
            <h5 class="card-title">Planejamentos - {{$ano}}</h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Ano</th>
                        <th>Série(s)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($planejamentos as $plan)
                    <tr>
                        <td>{{$plan->id}}</td>
                        <td>{{$plan->descricao}}</td>
                        <td>{{$plan->ano}}</td>
                        <td>
                            <ul>
                            @foreach ($plan->series as $serie)
                                <li>{{$serie->serie}}º ANO</li>
                            @endforeach
                            </ul>
                        </td>
                        <td>
                            <a href="/outro/planejamentos/painel/{{$plan->id}}" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-48">attach_file</i></a>
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