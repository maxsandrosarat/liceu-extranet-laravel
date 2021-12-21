@extends('layouts.app', ["current"=>"administrativo"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Disciplinas</h5>
                    <p class="card-text">
                        Gerenciar as Disciplinas
                    </p>
                    <a href="/admin/disciplinas" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Turmas</h5>
                    <p class="card-text">
                        Gerenciar as Turmas
                    </p>
                    <a href="/admin/turmas" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div>
        <!-- <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Turmas&Disciplinas</h5>
                    <p class="card-text">
                        Gerenciar as Disciplinas das Turmas
                    </p>
                    <a href="/admin/turmasDiscs" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div> -->
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Tipos de Ocorrências</h5>
                    <p class="card-text">
                        Gerenciar os Tipos
                    </p>
                    <a href="/admin/tiposOcorrencias" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Professores</h5>
                    <p class="card-text">
                        Gerenciar os Professores
                    </p>
                    <a href="/admin/prof" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Alunos</h5>
                    <p class="card-text">
                        Gerenciar os Alunos
                    </p>
                    <a href="/admin/aluno" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div>
        {{--  <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Responsáveis</h5>
                    <p class="card-text">
                        Gerenciar os Responsáveis
                    </p>
                    <a href="/admin/responsavel" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div>  --}}
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Colaboradores</h5>
                    <p class="card-text">
                        Gerenciar os Colaboradores
                    </p>
                    <a href="/admin/colaborador" class="btn btn-primary">Gerenciar</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Admin</h5>
                    <p class="card-text">
                        Cadastrar Admin
                    </p>
                    <a href="/admin/novo" class="btn btn-primary">Cadastrar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection