@extends('layouts.app', ["current"=>"home"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Estoque</h5>
                    <p class="card-text">
                        Gerenciar Produtos, Categorias, entre outros.
                    </p>
                    <a href="/admin/estoque" class="btn btn-primary">Estoque</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Administrativo</h5>
                    <p class="card-text">
                        Gerenciar Turmas, Alunos, Professores, entre outros.
                    </p>
                    <a href="/admin/administrativo" class="btn btn-primary">Administrativo</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Pedagógico</h5>
                    <p class="card-text">
                        Consultar Atividades, Provas, Diários, entre outros.
                    </p>
                    <a href="/admin/pedagogico" class="btn btn-primary">Pedagógico</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
