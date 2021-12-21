@extends('layouts.app', ["current"=>"administrativo"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Alunos</h5>
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    Erro(s)
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>{{ $message }}</strong>
                </div>
            @endif
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Aluno ou Alunos">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            @if(count($alunos)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem alunos cadastrados! Faça novo cadastro no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/aluno" class="btn btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="row">
                <div class="col-8">
            <div class="card border">
                <h5>Filtros: </h5>
                <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/aluno/filtro">
                    @csrf
                    <div class="col-auto form-floating">
                        <input class="form-control" type="text" placeholder="Nome do Aluno" name="nome">
                        <label for="nome">Nome do Aluno</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="turma" name="turma">
                            <option value="">Selecione</option>
                            @foreach ($turmas as $turma)
                                <option @if($turma->ativo==false) style="color: red;" @endif value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                            @endforeach
                        </select>
                        <label for="disciplina">Turma</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="ativo" name="ativo">
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                        <label for="disciplina">Ativo</label>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                    </div>
                </form>
            </div>
            </div>
                <div class="col-4" style="text-align: right;">
                    <a type="button" class="btn btn-outline-success" href="/admin/aluno/exportarExcelView">Exportar para Excel</a>
                </div>
            </div>
            <br>
            <h5>Exibindo {{$alunos->count()}} de {{$alunos->total()}} de Aluno(s) ({{$alunos->firstItem()}} a {{$alunos->lastItem()}})</h5>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Login</th>
                        <th scope="col">Turma</th>
                        <th scope="col">Ativo</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alunos as $aluno)
                    <tr>
                        <td>{{$aluno->id}}</td>
                        <td width="100"><button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalFoto{{$aluno->id}}">@if($aluno->foto!="")<img style="border-radius: 20px; margin:0px; padding:0px;" src="/storage/{{$aluno->foto}}" alt="foto_perfil" width="50%"> @else <i class="material-icons md-48">no_photography</i> @endif</button></td>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalFoto{{$aluno->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="color: black; text-align: center;">
                                @if($aluno->foto!="") <img src="/storage/{{$aluno->foto}}" alt="foto_produto" style="width: 100%"> @else <i class="material-icons md-60">no_photography</i> @endif
                                <hr/>
                                <h6 class="font-italic">
                                {{$aluno->name}} - {{$aluno->turma->serie}}º ANO {{$aluno->turma->turma}} (@if($aluno->turma->turno=='M') Matutino @else @if($aluno->turma->turno=='V') Vespertino @else Noturno @endif @endif)
                                </h6>
                                <hr/>
                            </div>
                            </div>
                        </div>
                        </div>
                        <td>{{$aluno->name}}</td>
                        <td>{{$aluno->email}}</td>
                        <td @if($aluno->turma->ativo==false) style="color: red;" @endif >{{$aluno->turma->serie}}º ANO {{$aluno->turma->turma}} (@if($aluno->turma->turno=='M') Matutino @else @if($aluno->turma->turno=='V') Vespertino @else Noturno @endif @endif)</td>
                        <td>
                            @if($aluno->ativo==1)
                                <b><i class="material-icons green">check_circle</i></b>
                            @else
                                <b><i class="material-icons red">highlight_off</i></b>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal{{$aluno->id}}" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$aluno->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edição de Aluno</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <form method="POST" action="/admin/aluno/editar/{{$aluno->id}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-12 form-floating">
                                                    <input id="name" type="text" class="form-control" name="name" value="{{$aluno->name}}" required autocomplete="name" autofocus>
                                                    <label for="name">Nome</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="email" type="email" class="form-control" name="email" value="{{$aluno->email}}" required autocomplete="email">
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
                                                <div class="col-12 form-floating">
                                                    <select class="form-select" id="turma" name="turma" required>
                                                        <option value="{{$aluno->turma->id}}">{{$aluno->turma->serie}}º ANO {{$aluno->turma->turma}} (@if($aluno->turma->turno=='M') Matutino @else @if($aluno->turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                                            @foreach ($turmas as $turma)
                                                                @if($aluno->turma->id==$turma->id || $turma->ativo==false)
                                                                @else
                                                                <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                                                @endif
                                                            @endforeach
                                                    </select>
                                                    <label for="turma">Turma</label>
                                                </div>
                                                <br/>
                                                <div class="col-12 input-group mb-3">
                                                    <label for="foto" class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Adicionar Foto"><i class="material-icons blue md-24">add_photo_alternate</i></label>
                                                    <input class="form-control" type="file" id="foto" name="foto" accept=".jpg,.png,jpeg">
                                                </div>
                                                <b style="font-size: 80%;">Aceito apenas Imagens JPG e PNG (".jpg" e ".png")</b>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @if($aluno->ativo==1)
                                <a href="/admin/aluno/apagar/{{$aluno->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            @else
                                <a href="/admin/aluno/apagar/{{$aluno->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                {{$alunos->links() }}
            </div>
            </div>
            @endif
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Importar Arquivo Excel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form-importar-excel" action="/admin/aluno/importarExcel" enctype="multipart/form-data">
                    @csrf
                    <ul>
                        <li><h5>Baixe o modelo de importação.</h5></li>
                        <a type="button" class="btn btn-info" href="/admin/templates/download/aluno">Baixar modelo</a>
                        <li><h5>Nenhum campo pode ficar sem preencher.</h5></li>
                        <li><h5>No campo login não esqueça de adicionar @liceu (senão usuário não conseguirá fazer login)</h5></li>
                        <li><h5>Após envio do Arquivo aguarde tempo de processamento!</h5></li>
                    </ul>
                    <input type="file" id="arquivo" name="arquivo" accept=".xls,.xlsx" required>
                    <br/>
                    <b style="font-size: 80%;">Aceito apenas extensões do Excel (".xls e .xlsx")</b>
                <div class="modal-footer" id="processamento">
                    <button type="submit" class="btn btn-primary" onclick="processar()">Enviar</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cadastro de Aluno <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalFile" class="close" data-dismiss="modal" aria-label="Close">
                Ou importe um arquivo do Excel
            </button></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="/admin/aluno" enctype="multipart/form-data">
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
                        <div class="col-12 form-floating">
                            <select class="form-select" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                    @foreach ($turmas as $turma)
                                        @if($turma->ativo==false)
                                        @else
                                        <option value="{{$turma->id}}">{{$turma->serie}}º ANO {{$turma->turma}} (@if($turma->turno=='M') Matutino @else @if($turma->turno=='V') Vespertino @else Noturno @endif @endif)</option>
                                        @endif
                                    @endforeach
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <br/>
                        <div class="col-12 input-group mb-3">
                            <label for="foto" class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Adicionar Foto"><i class="material-icons blue md-24">add_photo_alternate</i></label>
                            <input class="form-control" type="file" id="foto" name="foto" accept=".jpg,.png,jpeg">
                        </div>
                        <b style="font-size: 80%;">Aceito apenas Imagens JPG e PNG (".jpg" e ".png")</b>
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
