@extends('layouts.app', ["current"=>"administrativo"])

@section('body')
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            @if(session('mensagem'))
                <div class="alert @if(session('type')=="success") alert-success @else @if(session('type')=="warning") alert-warning @else @if(session('type')=="danger") alert-danger @else alert-info @endif @endif @endif alert-dismissible fade show" role="alert">
                    {{session('mensagem')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5 class="card-title">Lista de Professores</h5>
            <a type="button" class="float-button" onclick="checksDisc(0);" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Professor(a)">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            @if(count($profs)==0)
                    <div class="alert alert-dark" role="alert">
                        @if($view=="inicial")
                        Sem professores cadastrados! Faça novo cadastro no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        @endif
                        @if($view=="filtro")
                        Sem resultados da busca!
                        <a href="/admin/prof/consulta" class="btn btn-success">Voltar</a>
                        @endif
                    </div>
            @else
            <div class="card border">
                <h5>Filtros: </h5>
                <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/prof/filtro">
                    @csrf
                    <div class="col-auto form-floating">
                        <input class="form-control" name="nome" type="text" id="nome" placeholder="Nome do Professor"/>
                        <label for="nome">Nome do Professor</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="disciplina" name="disciplina">
                            <option value="">Selecione uma disciplina</option>
                            @foreach ($discs as $disc)
                                <option @if($disc->ativo==false) style="color: red;" @endif value="{{$disc->id}}">{{$disc->nome}} (@if($disc->ensino=="fund") Fundamental @else Médio @endif)</option>
                            @endforeach
                        </select>
                        <label for="disciplina">Disciplina</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="ativo" name="ativo">
                            <option value="1">Sim</option>
                            <option value="0">Inativo</option>
                        </select>
                        <label for="ativo">Ativo</label>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                    </div>
                </form>
            </div>
            <br>
            <h5>Exibindo {{$profs->count()}} de {{$profs->total()}} de Professor(es) ({{$profs->firstItem()}} a {{$profs->lastItem()}})</h5>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>Disciplinas (clique para Turmas)</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profs as $prof)
                    <tr>
                        <td>{{$prof->id}}</td>
                        <td>{{$prof->name}}</td>
                        <td>{{$prof->email}}</td>
                        <td>
                            <ul class="list-group">
                                @foreach ($prof->disciplinas as $disciplina)
                                    @php
                                        $qtdTurmas = 0;
                                        foreach($disciplina->turmas as $turma){
                                            foreach($profDiscs as $disc){
                                                foreach($profTurmas as $profTurma){
                                                    if($disc->disciplina_id==$disciplina->id && $disc->prof_id==$prof->id && $disc->id==$profTurma->prof_disciplina_id && $profTurma->turma_id==$turma->id){
                                                        $qtdTurmas++;   
                                                    } 
                                                }
                                            }
                                        }
                                    @endphp
                                @if($disciplina->ativo==1)
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" @if($disciplina->ativo==false) style="color: red;" @endif><button type="button" class="btn btn-primary position-relative" data-placement="bottom" title="{{$qtdTurmas}} turmas vinculadas" data-bs-toggle="modal" data-bs-target="#modalTurmasProf{{$prof->id}}Disc{{$disciplina->id}}">{{$disciplina->nome}} (@if($disciplina->ensino=='fund') Fundamental @else Médio @endif)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{$qtdTurmas}}</span></button> <a href="/admin/prof/desvincularDisciplinaProf/{{$prof->id}}/{{$disciplina->id}}"><i class="material-icons red" data-toggle="tooltip" data-placement="bottom" title="Desvincular">remove_circle</i></a></li>
                                <!-- Modal Turmas-->
                                <div class="modal fade" id="modalTurmasProf{{$prof->id}}Disc{{$disciplina->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$prof->name}} - {{$disciplina->nome}} (@if($disciplina->ensino=='fund') Fundamental @else Médio @endif)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-turmasProf{{$prof->id}}Disc{{$disciplina->id}}" action="/admin/prof/turmas" method="POST" style="text-align: center;">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" name="prof" value="{{$prof->id}}">
                                                        <input type="hidden" name="disciplina" value="{{$disciplina->id}}">
                                                        <ul class="list-group">
                                                            @foreach ($disciplina->turmas as $turma)
                                                                <li class="list-group-item">
                                                                    <div class="form-group form-check">
                                                                        <input type="checkbox" class="form-check-input" id="turma{{$turma->id}}" name="turmas[]" value="{{$turma->id}}" 
                                                                        @foreach($profDiscs as $disc)
                                                                            @foreach($profTurmas as $profTurma)
                                                                                @if($disc->disciplina_id==$disciplina->id && $disc->prof_id==$prof->id && $disc->id==$profTurma->prof_disciplina_id && $profTurma->turma_id==$turma->id) checked @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                        >
                                                                        <label class="form-check-label" for="turma{{$turma->id}}">{{$turma->serie}}º{{$turma->turma}}{{$turma->turno}}</label>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" form="form-turmasProf{{$prof->id}}Disc{{$disciplina->id}}" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            @if($prof->ativo==1)
                                <b><i class="material-icons green">check_circle</i></b>
                            @else
                                <b><i class="material-icons red">highlight_off</i></b>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="badge bg-warning" onclick="checksDisc({{$prof->id}});" data-bs-toggle="modal" data-bs-target="#exampleModal{{$prof->id}}" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{$prof->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edição de Professor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <form method="POST" action="/admin/prof/editar/{{$prof->id}}">
                                                @csrf
                                                <div class="col-12 form-floating">
                                                    <input id="name" type="text" class="form-control" name="name" value="{{$prof->name}}" required autocomplete="name" autofocus>
                                                    <label for="name">Nome</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="email" type="email" class="form-control" name="email" value="{{$prof->email}}" required autocomplete="email">
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
                                                <hr/>
                                                <div>
                                                    <h3>Disciplinas</h3>
                                                    <div class="col-12">
                                                        <label for="disciplina{{$prof->id}}">Nome da Disciplina</label>
                                                        <input id="disciplina{{$prof->id}}" chave="{{$prof->id}}" class="form-control" type="text" name="fazenda" placeholder="Digite o nome">
                                                    </div>
                                                    <ul class="list-group" id="listaDisciplinasChecked{{$prof->id}}">
                                                        @foreach ($prof->disciplinas as $disc)
                                                        <li class="list-group-item" id="disciplina{{$disc->id}}"><input type="checkbox" class="form-check-input me-1" name="disciplinas[]" value="{{$disc->id}}" checked>
                                                        <label class="form-check-label" for="disciplina{{$disc->id}}">{{$disc->nome}} @if($disc->ensino=="fund") (Fundamental) @else (Médio) @endif</label></li>
                                                        @endforeach
                                                    </ul>
                                                    <hr/>
                                                    <ul class="list-group" id="listaDisciplinas{{$prof->id}}">
                                                        
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            @if($prof->ativo==1)
                                <a href="/admin/prof/apagar/{{$prof->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            @else
                                <a href="/admin/prof/apagar/{{$prof->id}}" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                {{$profs->links() }}
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
            <h5 class="modal-title" id="exampleModalLabel">Cadastro de Professor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="/admin/prof">
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
                        <hr/>
                        <div>
                            <h3>Disciplinas</h3>
                            <div class="col-12">
                                <label for="disciplina0">Nome da Disciplina</label>
                                <input id="disciplina0" chave="0" class="form-control" type="text" name="disciplina" placeholder="Digite o nome">
                            </div>
                            <ul class="list-group" id="listaDisciplinasChecked0">
                                
                            </ul>
                            <hr/>
                            <ul class="list-group" id="listaDisciplinas0">
                                
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    {!! csrf_field() !!}
@endsection
