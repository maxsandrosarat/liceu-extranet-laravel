@extends('layouts.app', ["current"=>"administrativo"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Responsaveis</h5>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Professor(a)">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            @if(count($resps)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem responsaveis cadastrados! Faça novo cadastro no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/responsavel/consulta" class="btn btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5>Filtros: </h5>
            <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/responsavel/filtro">
                @csrf
                <div class="col-auto form-floating">
                    <input class="form-control" type="text" placeholder="Nome do Responsável" name="nome">
                    <label for="nome">Nome do Responsável</label>
                </div>
                <div class="col-auto form-floating">
                    <select class="form-select" id="aluno" name="aluno">
                        <option value="">Selecione um aluno</option>
                        @foreach ($alunos as $aluno)
                            <option value="{{$aluno->id}}">{{$aluno->name}}</option>
                        @endforeach
                    </select>
                    <label for="aluno">Aluno</label>
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                </div>
            </form>
            </div>
            <br>
            <h5>Exibindo {{$resps->count()}} de {{$resps->total()}} de Responsaveis ({{$resps->firstItem()}} a {{$resps->lastItem()}})</h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>Aluno(s)</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resps as $resp)
                    <tr>
                        <td>{{$resp->id}}</td>
                        <td>{{$resp->name}}</td>
                        <td>{{$resp->email}}</td>
                        <td>
                            @if(count($resp->alunos)==0)
                            @else
                            <ul>
                                @foreach ($resp->alunos as $aluno)
                                <li @if($aluno->ativo==false) style="color: red;" @endif>{{$aluno->name}} <a href="/admin/responsavel/desvincular/{{$resp->id}}/{{$aluno->id}}" class="btn btn-sm btn-danger">Desvincular</a></li>
                                @endforeach
                            </ul>
                            @endif
                            <!-- Modal -->
                                <div class="modal fade" id="exampleModalVinc{{$resp->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Vincular Aluno</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="/admin/responsavel/vincular/{{$resp->id}}">
                                        @csrf
                                            <div class="col-12 form-floating">
                                                <select class="form-select" id="aluno" name="aluno" required>
                                                    <option value="">Selecione um aluno</option>
                                                        @foreach ($alunos as $aluno)
                                                            @if($aluno->ativo==true)
                                                            <option value="{{$aluno->id}}">{{$aluno->name}}</option>
                                                            @endif
                                                        @endforeach
                                                </select>
                                                <label for="aluno">Aluno</label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                        </td>
                        <td>
                            @if($resp->ativo==1)
                                <b><i class="material-icons green">check_circle</i></b>
                            @else
                                <b><i class="material-icons red">highlight_off</i></b>
                            @endif
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalVinc{{$resp->id}}">
                                Vincular Aluno
                            </button>
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$resp->id}}" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$resp->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edição de Responsável</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <form method="POST" action="/admin/responsavel/editar/{{$resp->id}}">
                                                @csrf
                                                <div class="col-12 form-floating">
                                                    <input id="name" type="text" class="form-control" name="name" value="{{$resp->name}}" required autocomplete="name" autofocus>
                                                    <label for="name">Nome</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="email" type="email" class="form-control" name="email" value="{{$resp->email}}" required autocomplete="email">
                                                    <label for="email">E-Mail</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                                                    <label for="password">Senha</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                                    <label for="password-confirm">Confirmação Senha</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @if($resp->ativo==1)
                                <a href="/admin/responsavel/apagar/{{$resp->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            @else
                                <a href="/admin/responsavel/apagar/{{$resp->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                {{$resps->links() }}
            </div>
            </div>
            @endif
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Responsável</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="/admin/responsavel">
                        @csrf
                        <div class="col-12 form-floating">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nome">
                            <label for="name">Nome</label>
                        </div>
                        <div class="col-12 form-floating">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="E-Mail">
                            <label for="email">E-Mail</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 form-floating">
                            <input id="senhaForca" onkeyup="validarSenhaForca()" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Senha">
                            <label for="password">Senha</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <p class="fs-6 fst-italic">(Mínimo de 8 caracteres)</p>
                        </div>
                        <div class="col-12">
                            <div name="erroSenhaForca" id="erroSenhaForca"></div>
                            <label for="erroSenhaForca">Força Senha</label>
                        </div>
                        <div class="col-12 form-floating">
                            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmação Senha">
                            <label for="password-confirm">Confirmação Senha</label>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
