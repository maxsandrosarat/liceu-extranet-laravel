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
                                        
                                        <h4><a href="<?php echo e(route('outro.login')); ?>" type="button" class="btn btn-outline-dark"><b>COLABORADOR</b></a></h4>
                                        
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
<?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/welcome.blade.php ENDPATH**/ ?>