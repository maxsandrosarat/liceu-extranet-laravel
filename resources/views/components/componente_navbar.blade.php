<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a href="/"><img src="/storage/logo_liceu.png" alt="logo_liceu" width="100" class="d-inline-block align-top" loading="lazy"></a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto">
            <!--ADMIN-->
            @auth("admin")
            <li class="nav-item">
                <a class="nav-link @if($current=="home") active @endif" href="/admin">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="estoque") active @endif" href="/admin/estoque">Estoque</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="administrativo") active @endif" href="/admin/administrativo">Administrativo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="pedagogico") active @endif" href="/admin/pedagogico">Pedagógico</a>
            </li>
            @endauth

            <!--RESPONSAVEL-->
            @auth("responsavel")
            <li class="nav-item">
                <a class="nav-link @if($current=="home") active @endif" href="/responsavel">Home</a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link @if($current=="diario") active @endif" href="/responsavel/diario">Diário</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="ocorrencias") active @endif" href="/responsavel/ocorrencias">Ocorrências</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="recados") active @endif" href="/responsavel/recados">Recados</a>
            </li>-->
            <li class="nav-item">
                <a class="nav-link @if($current=="administrativo") active @endif" href="#">Administrativo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="financeiro") active @endif" href="#">Financeiro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="pedagogico") active @endif" href="#">Pedagógico</a>
            </li>
            @endauth

            <!--ALUNO-->
            @auth("aluno")
            <li class="nav-item">
                <a class="nav-link @if($current=="home") active @endif" href="/aluno">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="atividade") active @endif" href="/aluno/atividade/disciplinas">Atividades</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="conteudo") active @endif" href="/aluno/conteudos/{{date("Y")}}">Conteúdos</a>
            </li>
            @endauth

            <!--PROF-->
            @auth("prof")
            <li class="nav-item">
                <a class="nav-link @if($current=="home") active @endif" href="/prof">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="atividade") active @endif" href="/prof/atividadeComplementar">Atividades</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link @if($current=="la") active @endif" href="/prof/listaAtividade/{{date("Y")}}">Rotinas Semanais</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="ocorrencias") active @endif" href="/prof/ocorrencias/disciplinas">Ocorrências</a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link @if($current=="diario") active @endif" href="/prof/diario/disciplinas">Ficha de Sala</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="provas") active @endif" href="/prof/provas/{{date("Y")}}">Provas</a>
            </li>
            @endauth

            <!--OUTRO-->
            @auth("outro")
            <li class="nav-item">
                <a class="nav-link @if($current=="home") active @endif" href="/outro">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="estoque") active @endif" href="/outro/estoque">Estoque</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="diario") active @endif" href="/outro/diario">Diário</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="provas") active @endif" href="/outro/provas/{{date("Y")}}">Provas</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link @if($current=="conteudos") active @endif" href="/outro/conteudosProvas/{{date("Y")}}">Conteúdos</a>
            </li> --}}
            @endauth

            <!--WEB
            @auth("web")
            <li class="nav-item">
                <a class="nav-link @if($current=="home") active @endif" href="/home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="la") active @endif" href="/listaAtividade">Lista Atividades</a>
            </li>
            @endauth-->

            <!--DESLOGADO-->
            @guest
            {{-- <li class="nav-item">
                <a class="nav-link @if($current=="login") active @endif" href="{{ route('login') }}">{{ __('Login(Usuário)') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="login-prof") active @endif" href="{{ route('prof.login') }}">{{ __('Login(Prof)') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="login-admin") active @endif" href="{{ route('admin.login') }}">{{ __('Login(Admin)') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="login-resp") active @endif" href="{{ route('responsavel.login') }}">{{ __('Login(Responsável)') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($current=="login-aluno") active @endif" href="{{ route('aluno.login') }}">{{ __('Login(Aluno)') }}</a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link @if($current=="login-outro") active @endif" href="{{ route('outro.login') }}">{{ __('Login') }}</a>
            </li>
            
            <!--@if (Route::has('register'))
            <li class="nav-item">
               <a class="nav-link" href="{{ route('register') }}">{{ __('Cadastre-se') }}</a>
           </li>
            @endif-->

            <!--LOGADO-->
            @else
            <!--LOGOUT-->
            <li class="nav-item dropdown" class="nav-item">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            <li class="nav-item dropdown" class="nav-item">
                @if(Auth::user()->foto!="")
                <img style="border-radius: 20px;" src="/storage/{{Auth::user()->foto}}" alt="foto_perfil" width="10%">
                @endif
            </li>
            @endguest
        </ul>
    </div>
  </nav>