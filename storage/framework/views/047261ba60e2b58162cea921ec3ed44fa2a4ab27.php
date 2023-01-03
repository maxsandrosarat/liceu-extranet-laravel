<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #cccccc; 
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

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(auth()->guard("web")->check()): ?>
                        <a href="<?php echo e(url('/home')); ?>">Home</a>
                    <?php else: ?>
                        <?php if(auth()->guard("admin")->check()): ?>
                            <a href="<?php echo e(url('/admin')); ?>">Home</a>
                        <?php else: ?>
                            <?php if(auth()->guard("aluno")->check()): ?>
                                <a href="<?php echo e(url('/aluno')); ?>">Home</a>
                            <?php else: ?>
                                <?php if(auth()->guard("prof")->check()): ?>
                                    <a href="<?php echo e(url('/prof')); ?>">Home</a>
                                <?php else: ?>
                                    <!--<?php if(Route::has('register')): ?>
                                        <a href="<?php echo e(route('register')); ?>">Cadastre-se</a>
                                    <?php endif; ?>-->
                                        <b><h4>FAÇA LOGIN COMO</h4></b>
                                        <h4><a href="<?php echo e(route('responsavel.login')); ?>" class="badge badge-dark">RESPONSÁVEL</a>
                                        <a href="<?php echo e(route('aluno.login')); ?>" class="badge badge-dark">ALUNO</a>
                                        <a href="<?php echo e(route('outro.login')); ?>" class="badge badge-dark">COLABORADOR</a>
                                        <!--<a href="<?php echo e(route('prof.login')); ?>" class="badge badge-dark">PROFESSOR</a></h4>
                                        <a href="<?php echo e(route('login')); ?>" class="badge badge-dark">USUÁRIO</a>
                                        <a href="<?php echo e(route('admin.login')); ?>" class="badge badge-dark">ADMIN</a>-->
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content">
                <b><h2>Seja Bem-vindo!</h2></b>
                <div class="title m-b-md">
                    <img class="img-fluid" src="/storage/liceu.png" alt="logo_liceu">
                </div>
                <?php if(auth()->guard("web")->check()): ?>
                    <b> <h3>Você está logado como  <?php echo e(Auth::user()->name); ?>  !</h3></b>
                <?php else: ?>
                    <?php if(auth()->guard("admin")->check()): ?>
                        <b> <h3>Você está logado como  <?php echo e(Auth::guard('admin')->user()->name); ?>  !</h3></b>
                    <?php else: ?>
                        <?php if(auth()->guard("aluno")->check()): ?>
                            <b> <h3>Você está logado como  <?php echo e(Auth::guard('aluno')->user()->name); ?>  !</h3></b>
                        <?php else: ?>
                            <?php if(auth()->guard("prof")->check()): ?>
                                <b> <h3>Você está logado como  <?php echo e(Auth::guard('prof')->user()->name); ?>  !</h3></b>
                            <?php else: ?>
                                <?php if(auth()->guard("responsavel")->check()): ?>
                                <b> <h3>Você está logado como  <?php echo e(Auth::guard('responsavel')->user()->name); ?>  !</h3></b>
                                <?php else: ?>
                                    <b> <h3>Você não está logado! Por gentileza faça login.</h3></b>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
<?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/welcome.blade.php ENDPATH**/ ?>