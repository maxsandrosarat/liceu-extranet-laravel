@extends('layouts.app', ["current"=>"home"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/outro/atividadeComplementar/{{date("Y")}}" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Estoque</h5>
                    <p class="card-text">
                        Gerenciar o Estoque
                    </p>
                    <a href="/outro/estoque" class="btn btn-primary">Estoque</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ficha de Sala (Diário)</h5>
                    <p class="card-text">
                        Lançamentos de Diário
                    </p>
                    <a href="/outro/diario" class="btn btn-primary">Diário</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Provas</h5>
                    <p class="card-text">
                        Conteúdos e Questões
                    </p>
                    <a href="/outro/provas/{{date("Y")}}" class="btn btn-primary">Provas</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Documentos</h5>
                    <p class="card-text">
                        Consultar Documentos
                    </p>
                    <a href="/outro/documentos" class="btn btn-primary">Documentos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Lembretes</h5>
                    <p class="card-text">
                        Consultar Lembretes
                    </p>
                    <a href="/outro/lembretes" class="btn btn-primary">Lembretes</a>
                </div>
            </div>
        </div>
    </div>
</div>

            {{-- <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Questões de Provas</h5>
                        <p class="card-text">
                            Cadastrar e Consultar Questões
                        </p>
                        <a href="/outro/simulados/{{date("Y")}}" class="btn btn-primary">Questões</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Conteúdos de Provas</h5>
                        <p class="card-text">
                            Gerar Campos e Consultar
                        </p>
                        <a href="/outro/conteudosProvas/{{date("Y")}}" class="btn btn-primary">Conteúdos</a>
                    </div>
                </div>
            </div> --}}

@endsection
