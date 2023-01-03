<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a href="/"><img src="/storage/logo_liceu.png" alt="logo_liceu" width="100" class="d-inline-block align-top" loading="lazy"></a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav mr-auto">
            <!--ADMIN-->
            <?php if(auth()->guard("admin")->check()): ?>
            <li <?php if($current=="home"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/admin">Home</a>
            </li>
            <li <?php if($current=="estoque"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/admin/estoque">Estoque</a>
            </li>
            <li <?php if($current=="administrativo"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/admin/administrativo">Administrativo</a>
            </li>
            <li <?php if($current=="pedagogico"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/admin/pedagogico">Pedagógico</a>
            </li>
            <?php endif; ?>

            <!--RESPONSAVEL-->
            <?php if(auth()->guard("responsavel")->check()): ?>
            <li <?php if($current=="home"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/responsavel">Home</a>
            </li>
            <!--<li <?php if($current=="diario"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/responsavel/diario">Diário</a>
            </li>
            <li <?php if($current=="ocorrencias"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/responsavel/ocorrencias">Ocorrências</a>
            </li>
            <li <?php if($current=="recados"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/responsavel/recados">Recados</a>
            </li>-->
            <li <?php if($current=="administrativo"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="#">Administrativo</a>
            </li>
            <li <?php if($current=="financeiro"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="#">Financeiro</a>
            </li>
            <li <?php if($current=="pedagogico"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="#">Pedagógico</a>
            </li>
            <?php endif; ?>

            <!--ALUNO-->
            <?php if(auth()->guard("aluno")->check()): ?>
            <li <?php if($current=="home"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/aluno">Home</a>
            </li>
            <li <?php if($current=="atividade"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/aluno/atividade/disciplinas">Atividades</a>
            </li>
            <li <?php if($current=="conteudo"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/aluno/conteudos/<?php echo e(date("Y")); ?>">Conteúdos</a>
            </li>
            <?php endif; ?>

            <!--PROF-->
            <?php if(auth()->guard("prof")->check()): ?>
            <li <?php if($current=="home"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/prof">Home</a>
            </li>
            <li <?php if($current=="atividade"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/prof/atividadeComplementar">Atividades</a>
            </li>
            <!--<li <?php if($current=="la"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/prof/listaAtividade/<?php echo e(date("Y")); ?>">Rotinas Semanais</a>
            </li>-->
            <li <?php if($current=="diario"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/prof/diario/disciplinas">Ficha de Sala</a>
            </li>
            <!--<li <?php if($current=="ocorrencias"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/prof/ocorrencias/disciplinas">Ocorrências</a>
            </li>-->
            <li <?php if($current=="simulados"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/prof/simulados/<?php echo e(date("Y")); ?>">Provas</a>
            </li>
            <?php endif; ?>

            <!--OUTRO-->
            <?php if(auth()->guard("outro")->check()): ?>
            <li <?php if($current=="home"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/outro">Home</a>
            </li>
            <li <?php if($current=="estoque"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/outro/estoque">Estoque</a>
            </li>
            <li <?php if($current=="diario"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/outro/diario">Diário</a>
            </li>
            <li <?php if($current=="simulados"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/outro/simulados/<?php echo e(date("Y")); ?>">Provas</a>
            </li>
            
            <?php endif; ?>

            <!--WEB
            <?php if(auth()->guard("web")->check()): ?>
            <li <?php if($current=="home"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/home">Home</a>
            </li>
            <li <?php if($current=="la"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
                <a class="nav-link" href="/listaAtividade">Lista Atividades</a>
            </li>
            <?php endif; ?>-->

            <!--DESLOGADO-->
            <?php if(auth()->guard()->guest()): ?>
            <!--<li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login(Usuário)')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('prof.login')); ?>"><?php echo e(__('Login(Prof)')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.login')); ?>"><?php echo e(__('Login(Admin)')); ?></a>
            </li>-->
            <li class="nav-item <?php if($current=="login-resp"): ?> active <?php endif; ?>">
                <a class="nav-link" href="<?php echo e(route('responsavel.login')); ?>"><?php echo e(__('Login(Responsável)')); ?></a>
            </li>
            <li class="nav-item <?php if($current=="login-aluno"): ?> active <?php endif; ?>">
                <a class="nav-link" href="<?php echo e(route('aluno.login')); ?>"><?php echo e(__('Login(Aluno)')); ?></a>
            </li>
            <li class="nav-item <?php if($current=="login-outro"): ?> active <?php endif; ?>">
                <a class="nav-link" href="<?php echo e(route('outro.login')); ?>"><?php echo e(__('Login(Colaborador)')); ?></a>
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
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
  </nav><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/components/componente_navbar.blade.php ENDPATH**/ ?>