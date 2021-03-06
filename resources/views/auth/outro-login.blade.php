@extends('layouts.app', ["current"=>"login-outro"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="form-floating">
                <select class="form-select" name="tipoLogin" id="tipoLogin">
                    <option value="">Selecione</option>
                    <option value="admin">ADMINISTRADOR</option>
                    <option value="outro">COLABORADOR</option>
                    <option value="prof">PROFESSOR</option>
                </select>
                <label for="tipoLogin">Tipo de Usuário</label>
            <div class="form-floating">

            <div id="principal">

                <div class="card" id="outro">
                    <div class="card-header">LOGIN COMO COLABORADOR</div>

                    <div class="card-body text-center">
                        <main class="form-signin">
                            <form method="POST" action="{{route('outro.login.submit')}}">
                                @csrf
                                <img class="mb-4" src="/storage/liceu.png" alt="logo_liceu" width="50%">
                                <h1 class="h3 mb-3 fw-normal">Olá, Colaborador(a)</h1>
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Email</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                                    <label for="floatingPassword">Senha</label>
                                    <button id="botao-senha" class="badge bg-success rounded-pill" type="button" data-toggle="tooltip" data-placement="bottom" title="Exibir Senha" onclick="mostrarSenha()"><i id="icone-senha"class="material-icons white">visibility</i></button>
                                </div>
                                <br/>
                                <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                            </form>
                        </main>
                    </div>
                </div>

                    <div class="card" id="prof">
                        <div class="card-header">LOGIN COMO PROFESSOR</div>
        
                        <div class="card-body text-center">
                            <main class="form-signin">
                                <form method="POST" action="{{route('prof.login.submit')}}">
                                    @csrf
                                    <img class="mb-4" src="/storage/liceu.png" alt="logo_liceu" width="50%">
                                    <h1 class="h3 mb-3 fw-normal">Olá, Professor(a)</h1>
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Email</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" name="password" id="floatingPasswordProf" placeholder="Password">
                                        <label for="floatingPasswordProf">Senha</label>
                                        <button id="botao-senha-prof" class="badge bg-success rounded-pill" type="button" data-toggle="tooltip" data-placement="bottom" title="Exibir Senha" onclick="mostrarSenhaProf()"><i id="icone-senha-prof"class="material-icons white">visibility</i></button>
                                    </div>
                                    <br/>
                                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                                </form>
                            </main>
                        </div>
                    </div>

                    <div class="card" id="admin">
                        <div class="card-header">LOGIN COMO ADMINISTRADOR</div>
        
                        <div class="card-body text-center">
                            <main class="form-signin">
                                <form method="POST" action="{{route('admin.login.submit')}}">
                                    @csrf
                                    <img class="mb-4" src="/storage/liceu.png" alt="logo_liceu" width="50%">
                                    <h1 class="h3 mb-3 fw-normal">Olá, Administrador(a)</h1>
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                                        <label for="floatingInput">Email</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" name="password" id="floatingPasswordAdmin" placeholder="Password">
                                        <label for="floatingPasswordAdmin">Senha</label>
                                        <button id="botao-senha-admin" class="badge bg-success rounded-pill" type="button" data-toggle="tooltip" data-placement="bottom" title="Exibir Senha" onclick="mostrarSenhaAdmin()"><i id="icone-senha-admin"class="material-icons white">visibility</i></button>
                                    </div>
                                    <br/>
                                    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                                </form>
                            </main>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
