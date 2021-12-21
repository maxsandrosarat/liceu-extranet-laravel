@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
        <a href="/outro" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h5 class="card-title">Painel de Lembretes</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(count($lembretes)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem lembretes cadastrados!
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/outro/lembretes" class="btn btn-sm btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/outro/lembretes/filtro">
                        @csrf
                        <div class="col-auto form-floating">
                            <input class="form-control mr-sm-2" type="text" placeholder="Título" name="titulo">
                            <label for="titulo">Título</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo {{$lembretes->count()}} de {{$lembretes->total()}} de lembretes ({{$lembretes->firstItem()}} a {{$lembretes->lastItem()}})</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                @foreach ($lembretes as $lembrete)
                @php
                    $data = date("Y-m-d H:i");
                    $dataAtivPub = date("Y-m-d H:i", strtotime($lembrete->data_publicacao));
                    $dataAtivRem = date("Y-m-d H:i", strtotime($lembrete->data_remocao));
                @endphp
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#modalDoc{{$lembrete->id}}"><div id="my-div" class="bd-callout @if($dataAtivPub<$data && $dataAtivRem>$data) bd-callout-success @else @if($dataAtivPub>$data) bd-callout-warning @else bd-callout-danger @endif @endif">
                        <h4>{{$lembrete->titulo}}</h4>
                        <p>Publicação: {{date("d/m/Y H:i", strtotime($lembrete->data_publicacao))}} - Remoção: {{date("d/m/Y H:i", strtotime($lembrete->data_remocao))}}</p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDoc{{$lembrete->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">lembrete: {{$lembrete->titulo}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Título: {{$lembrete->titulo}} <br/> <hr/>
                                Conteúdo: "{{$lembrete->conteudo}}" <br/> <hr/>
                                Data Publicação: {{date("d/m/Y H:i", strtotime($lembrete->data_publicacao))}} <br/> <hr/>
                                Data Remoção: {{date("d/m/Y H:i", strtotime($lembrete->data_remocao))}} <br/> <hr/>
                                Data Criação: {{date("d/m/Y H:i", strtotime($lembrete->created_at))}}<br/>
                                Última Alteração: {{date("d/m/Y H:i", strtotime($lembrete->updated_at))}}
                            </p>
                        </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            <div class="card-footer">
                {{ $lembretes->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
