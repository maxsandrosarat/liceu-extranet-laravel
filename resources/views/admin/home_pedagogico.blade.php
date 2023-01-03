@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/admin/atividadeComplementar/{{date("Y")}}" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>  --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>{{-- Diárias --}}
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/admin/atividadeDiaria" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades</h5>
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/admin/atividade" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>  --}}
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Listas Atividades</h5>
                    <p class="card-text">
                        Consultar as Listas Atividades
                    </p>
                    <a href="/admin/listaAtividade/{{date("Y")}}" class="btn btn-primary">Listas Atividades</a>
                </div>
            </div>
        </div>  --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ficha de Sala (Diário)</h5>
                    <p class="card-text">
                        Lançamentos de Ficha de Sala (Diário)
                    </p>
                    <a href="/admin/diario" class="btn btn-primary">Diário</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ocorrências</h5>
                    <p class="card-text">
                        Consultar e Analisar as Ocorrências
                    </p>
                    <a href="/admin/ocorrencias" class="btn btn-primary">Ocorrências</a>
                </div>
            </div>
        </div>
        {{-- <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Conteúdos de Provas</h5>
                    <p class="card-text">
                        Gerar Campos e Consultar
                    </p>
                    <a href="/admin/conteudosProvas/{{date("Y")}}" class="btn btn-primary">Conteúdos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Conteúdos</h5>
                    <p class="card-text">
                        Gerar Campos e Consultar
                    </p>
                    <a href="/admin/conteudos/{{date("Y")}}" class="btn btn-primary">Conteúdos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Recados</h5>
                    <p class="card-text">
                        Cadastrar e Consultar Recados
                    </p>
                    <a href="/admin/recados" class="btn btn-primary">Recados</a>
                </div>
            </div>
        </div> --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Provas</h5>
                    <p class="card-text">
                        Consultar Conteúdos e Questões
                    </p>
                    <a href="/admin/provas/{{date("Y")}}" class="btn btn-primary">Provas</a>
                </div>
            </div>
        </div>
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Notas</h5>
                    <p class="card-text">
                        Consultar Notas
                    </p>
                    <a href="/admin/notas/{{date("Y")}}" class="btn btn-primary">Notas</a>
                </div>
            </div>
        </div>  --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Documentos</h5>
                    <p class="card-text">
                        Gerenciar Documentos Importantes
                    </p>
                    <a href="/admin/documentos" class="btn btn-primary">Documentos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Lembretes</h5>
                    <p class="card-text">
                        Gerenciar Lembretes
                    </p>
                    <a href="/admin/lembretes" class="btn btn-primary">Lembretes</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Planejamentos</h5>
                    <p class="card-text">
                        Cadastrar e Consultar Planejamentos
                    </p>
                    <a href="/admin/planejamentos/{{date("Y")}}" class="btn btn-primary">Planejamentos</a>
                </div>
            </div>
        </div>
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Extras</h5>
                    <p class="card-text">
                        Consultar e cadastrar Atividades Extras
                    </p>
                    <a href="/atividadeExtra" class="btn btn-primary">Atividades Extras</a>
                </div>
            </div>
        </div>  --}}
    </div>
</div>
@endsection