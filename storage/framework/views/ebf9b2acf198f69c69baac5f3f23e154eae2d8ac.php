<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a href="/"><img src="/storage/logo_liceu.png" alt="logo_liceu" width="100" class="d-inline-block align-top" loading="lazy"></a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto">
            <!--ADMIN-->
            <?php if(auth()->guard("admin")->check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="home"): ?> active <?php endif; ?>" href="/admin">Home</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php if($current=="administrativo"): ?> active <?php endif; ?>" href="/admin/administrativo">Administrativo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="pedagogico"): ?> active <?php endif; ?>" href="/admin/pedagogico">Pedagógico</a>
            </li>
            <?php endif; ?>

            <!--RESPONSAVEL-->
            <?php if(auth()->guard("responsavel")->check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="home"): ?> active <?php endif; ?>" href="/responsavel">Home</a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link <?php if($current=="diario"): ?> active <?php endif; ?>" href="/responsavel/diario">Diário</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="ocorrencias"): ?> active <?php endif; ?>" href="/responsavel/ocorrencias">Ocorrências</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="recados"): ?> active <?php endif; ?>" href="/responsavel/recados">Recados</a>
            </li>-->
            <li class="nav-item">
                <a class="nav-link <?php if($current=="administrativo"): ?> active <?php endif; ?>" href="#">Administrativo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="financeiro"): ?> active <?php endif; ?>" href="#">Financeiro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="pedagogico"): ?> active <?php endif; ?>" href="#">Pedagógico</a>
            </li>
            <?php endif; ?>

            <!--ALUNO-->
            <?php if(auth()->guard("aluno")->check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="home"): ?> active <?php endif; ?>" href="/aluno">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="atividade"): ?> active <?php endif; ?>" href="/aluno/atividade/disciplinas">Atividades</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="conteudo"): ?> active <?php endif; ?>" href="/aluno/conteudos/<?php echo e(date("Y")); ?>">Conteúdos</a>
            </li>
            <?php endif; ?>

            <!--PROF-->
            <?php if(auth()->guard("prof")->check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="home"): ?> active <?php endif; ?>" href="/prof">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="atividade"): ?> active <?php endif; ?>" href="/prof/atividadeDiaria/disciplinas">Atividades</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php if($current=="diario"): ?> active <?php endif; ?>" href="/prof/diario/disciplinas">Ficha de Sala</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="provas"): ?> active <?php endif; ?>" href="/prof/provas/<?php echo e(date("Y")); ?>">Provas</a>
            </li>
            
            <?php endif; ?>

            <!--OUTRO-->
            <?php if(auth()->guard("outro")->check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="home"): ?> active <?php endif; ?>" href="/outro">Home</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php if($current=="pedagogico"): ?> active <?php endif; ?>" href="/outro/pedagogico">Pedagógico</a>
            </li>
            <?php endif; ?>

            <!--WEB
            <?php if(auth()->guard("web")->check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="home"): ?> active <?php endif; ?>" href="/home">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($current=="la"): ?> active <?php endif; ?>" href="/listaAtividade">Lista Atividades</a>
            </li>
            <?php endif; ?>-->

            <!--DESLOGADO-->
            <?php if(auth()->guard()->guest()): ?>
            
            <li class="nav-item">
                <a class="nav-link <?php if($current=="login-outro"): ?> active <?php endif; ?>" href="<?php echo e(route('outro.login')); ?>"><?php echo e(__('Login')); ?></a>
            </li>
            
            <!--<?php if(Route::has('register')): ?>
            <li class="nav-item">
               <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Cadastre-se')); ?></a>
           </li>
            <?php endif; ?>-->

            <!--LOGADO-->
            <?php else: ?>
            <!--LOGOUT-->
            <li class="nav-item dropdown" class="nav-item">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <?php echo e(Auth::user()->name); ?> <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <?php echo e(__('Logout')); ?>

                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </li>
            <li class="nav-item dropdown" class="nav-item">
                <?php if(Auth::user()->foto!=""): ?>
                <img style="border-radius: 20px;" src="/storage/<?php echo e(Auth::user()->foto); ?>" alt="foto_perfil" width="10%">
                <?php endif; ?>
            </li>
            <?php endif; ?>
        </ul>
    </div>
  </nav><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/components/componente_navbar.blade.php ENDPATH**/ ?>