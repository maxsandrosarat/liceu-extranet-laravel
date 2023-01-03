@extends('layouts.app', ["current"=>"home"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Estoque</h5>
                    <p class="card-text">
                        Gerenciar o Estoque
                    </p>
                    <a href="/outro/estoque" class="btn btn-primary">Estoque</a>
                </div>
            </div>
        </div> --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Pedagógico</h5>
                    <p class="card-text">
                        Consultar o Pedagógico
                    </p>
                    <a href="/outro/pedagogico" class="btn btn-primary">Pedagógico</a>
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
