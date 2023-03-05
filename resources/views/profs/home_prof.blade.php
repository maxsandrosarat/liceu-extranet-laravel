@extends('layouts.app', ["current"=>"home"])

@section('body')
<div class="container">
    <div class="row align-items-md-stretch">
        <div class="col">
            <div class="h-100 p-6 text-white bg-dark rounded-3">
                <h1 class="display-5 fw-bold text-center">Olá Prof(a). {{Auth::user()->name}}!</h1>
            </div>
        </div>
    </div>
@if(count($lembretes)>0)
    <h2 class="promocao h2 text-center">Lembretes</h2>
        <div class="row justify-content-center">
        @foreach ($lembretes as $lembrete)
        <div class="col-auto">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header border-light"><h4><b>{{$lembrete->titulo}}</b></h4> <h6 class="promocao h6">Lembrete</h6></div>
                <div class="card-body">
                    <p class="card-title">{{$lembrete->conteudo}}</p>
                </div>
            </div>
        </div>
        @endforeach
      </div>
@else
    {{-- <h2 class="text-center">Sem lembretes</h2> --}}
@endif
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Planejamentos</h5>
                    <p class="card-text">
                        Cadastrar e Consultar Planejamentos
                    </p>
                    <a href="/prof/planejamentos/{{date("Y")}}" class="btn btn-primary">Planejamentos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>{{--Diárias--}}
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/prof/atividadeDiaria/disciplinas/diaria" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Plataforma Iônica</h5>
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/prof/atividadeDiaria/disciplinas/ionica" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>
                    <p class="card-text">
                        Gerenciar as Atividades
                    </p>
                    <a href="/prof/atividadeComplementar/{{date("Y")}}" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>  --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ficha de Sala (Diário)</h5>
                    <p class="card-text">
                        Lançar os Conteúdos, Tarefas e Ocorrências
                    </p>
                    <a href="/prof/diario/disciplinas" class="btn btn-primary">Diário</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Provas</h5>
                    <p class="card-text">
                        Cadastrar Conteúdos e Questões
                    </p>
                    <a href="/prof/provas/{{date("Y")}}" class="btn btn-primary">Provas</a>
                </div>
            </div>
        </div>
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Notas</h5>
                    <p class="card-text">
                        Lançamento de Notas
                    </p>
                    <a href="/prof/notas/{{date("Y")}}" class="btn btn-primary">Notas</a>
                </div>
            </div>
        </div>  --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ocorrências</h5>
                    <p class="card-text">
                        Consultar as Ocorrências
                    </p>
                    <a href="/prof/ocorrencias/disciplinas" class="btn btn-primary">Ocorrências</a>
                </div>
            </div>
        </div>
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Rotinas Semanais</h5>
                    <p class="card-text">
                        Gerenciar as Lista de Atividades
                    </p>
                    <a href="/prof/listaAtividade/{{date("Y")}}" class="btn btn-primary">LAs</a>
                </div>
            </div>
        </div>  --}}
        {{-- <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>
                    <p class="card-text">
                        Gerenciar as Atividades
                    </p>
                    <a href="/prof/atividade/disciplinas" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Rotinas Semanais</h5>
                    <p class="card-text">
                        Gerenciar as Lista de Atividades
                    </p>
                    <a href="/prof/listaAtividade/{{date("Y")}}" class="btn btn-primary">LAs</a>
                </div>
            </div>
        </div>
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Conteúdos de Provas</h5>
                        <p class="card-text">
                            Anexar e baixar os conteúdos
                        </p>
                        <a href="/prof/conteudos/{{date("Y")}}" class="btn btn-primary">Conteúdos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Conteúdos de Provas</h5>
                    <p class="card-text">
                        Anexar e baixar os conteúdos
                    </p>
                    <a href="/prof/conteudosProvas/{{date("Y")}}" class="btn btn-primary">Conteúdos</a>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<div class="container">
    @if(count($documentos)>0)
        <h2 class="text-center">Documentos Importantes</h2>
            <div class="row justify-content-center">
            @foreach ($documentos as $documento)
            <div class="col-auto">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header border-light"><h6><b>{{$documento->titulo}}</b></h6></div>
                    <div class="card-body text-center">
                        <a type="button" class="badge bg-success" href="/prof/documentos/download/{{$documento->id}}"><i class="material-icons md-48">cloud_download</i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        {{-- <h2 class="text-center">Sem documentos</h2> --}}
    @endif
</div>
@endsection
