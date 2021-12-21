@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="card border">
    <div class="card-body">
        <a href="/outro" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h5 class="card-title">Painel de Documentos Importantes</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(count($documentos)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem documentos cadastrados!
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/outro/documentos" class="btn btn-sm btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/outro/documentos/filtro">
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
            <b><h5 class="font-italic">Exibindo {{$documentos->count()}} de {{$documentos->total()}} de Documentos ({{$documentos->firstItem()}} a {{$documentos->lastItem()}})</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                @foreach ($documentos as $documento)
                @php
                    $data = date("Y-m-d H:i");
                    $dataAtivPub = date("Y-m-d H:i", strtotime($documento->data_publicacao));
                    $dataAtivRem = date("Y-m-d H:i", strtotime($documento->data_remocao));
                @endphp
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#modalDoc{{$documento->id}}"><div id="my-div" class="bd-callout @if($dataAtivPub<$data && $dataAtivRem>$data) bd-callout-success @else @if($dataAtivPub>$data) bd-callout-warning @else bd-callout-danger @endif @endif">
                        <h4>{{$documento->titulo}}</h4>
                        <p>Publicação: {{date("d/m/Y H:i", strtotime($documento->data_publicacao))}} - Remoção: {{date("d/m/Y H:i", strtotime($documento->data_remocao))}}</p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDoc{{$documento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Documento: {{$documento->titulo}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Título: {{$documento->titulo}} <br/> <hr/>
                                Data Publicação: {{date("d/m/Y H:i", strtotime($documento->data_publicacao))}} <br/> <hr/>
                                Data Remoção: {{date("d/m/Y H:i", strtotime($documento->data_remocao))}} <br/> <hr/>
                                Data Criação: {{date("d/m/Y H:i", strtotime($documento->created_at))}}<br/>
                                Última Alteração: {{date("d/m/Y H:i", strtotime($documento->updated_at))}}
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge bg-success" href="/outro/documentos/download/{{$documento->id}}"><i class="material-icons md-48">cloud_download</i></a>
                        </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            <div class="card-footer">
                {{ $documentos->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
