<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Extranet - Colégio Liceu II</title>
        <link rel="shortcut icon" href="/storage/favicon.png"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#00008B">
        <meta name="apple-mobile-web-app-status-bar-style" content="#00008B">
        <meta name="msapplication-navbutton-color" content="#00008B">
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: 	#E0FFFF; 
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 900;
                margin: 0;
            }
			h2, h3, h4{
				font-weight: 900;
			}

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth("web")
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        @auth("admin")
                            <a href="{{ url('/admin') }}">Home</a>
                        @else
                            @auth("aluno")
                                <a href="{{ url('/aluno') }}">Home</a>
                            @else
                                @auth("prof")
                                    <a href="{{ url('/prof') }}">Home</a>
                                @else
                                    <!--@if (Route::has('register'))
                                        <a href="{{ route('register') }}">Cadastre-se</a>
                                    @endif-->
                                        <b><h4>FAÇA LOGIN COMO</h4></b>
                                        {{-- <a href="{{ route('responsavel.login') }}" type="button" class="btn btn-outline-dark"><b>RESPONSÁVEL</b></a>
                                        <a href="{{ route('aluno.login') }}" type="button" class="btn btn-outline-dark"><b>ALUNO</b></a> --}}
                                        <h4><a href="{{ route('outro.login') }}" type="button" class="btn btn-outline-dark"><b>COLABORADOR</b></a></h4>
                                        {{-- <a href="{{ route('prof.login') }}" type="button" class="btn btn-outline-dark"><b>PROFESSOR</b></a>
                                        <a href="{{ route('login') }}" type="button" class="btn btn-outline-dark"><b>USUÁRIO</b></a>
                                        <a href="{{ route('admin.login') }}" type="button" class="btn btn-outline-dark"><b>ADMIN</b></a> --}}
                                @endauth
                            @endauth
                        @endauth
                    @endauth
                </div>
            @endif

            <div class="content">
                <b><h2>Seja Bem-vindo!</h2></b>
                <div class="title m-b-md">
                    <img class="img-fluid" src="/storage/liceu.png" alt="logo_liceu">
                </div>
                @auth("web")
                    <b> <h3>Você está logado como  {{Auth::user()->name}}  !</h3></b>
                @else
                    @auth("admin")
                        <b> <h3>Você está logado como  {{Auth::guard('admin')->user()->name}}  !</h3></b>
                    @else
                        @auth("aluno")
                            <b> <h3>Você está logado como  {{Auth::guard('aluno')->user()->name}}  !</h3></b>
                        @else
                            @auth("prof")
                                <b> <h3>Você está logado como  {{Auth::guard('prof')->user()->name}}  !</h3></b>
                            @else
                                @auth("responsavel")
                                <b> <h3>Você está logado como  {{Auth::guard('responsavel')->user()->name}}  !</h3></b>
                                @else
                                    <b> <h3>Você não está logado! Por gentileza faça login.</h3></b>
                                @endauth
                            @endauth
                        @endauth
                    @endauth
                @endauth
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
