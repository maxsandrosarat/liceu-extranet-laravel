<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row align-items-md-stretch">
        <div class="col">
            <div class="h-100 p-6 text-white bg-dark rounded-3">
                <h1 class="display-5 fw-bold text-center">Olá Prof(a). <?php echo e(Auth::user()->name); ?>!</h1>
            </div>
        </div>
    </div>
<?php if(count($lembretes)>0): ?>
    <h2 class="promocao h2 text-center">Lembretes</h2>
        <div class="row justify-content-center">
        <?php $__currentLoopData = $lembretes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lembrete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-auto">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header border-light"><h4><b><?php echo e($lembrete->titulo); ?></b></h4> <h6 class="promocao h6">Lembrete</h6></div>
                <div class="card-body">
                    <p class="card-title"><?php echo e($lembrete->conteudo); ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
<?php else: ?>
    
<?php endif; ?>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Planejamentos</h5>
                    <p class="card-text">
                        Cadastrar e Consultar Planejamentos
                    </p>
                    <a href="/prof/planejamentos/<?php echo e(date("Y")); ?>" class="btn btn-primary">Planejamentos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/prof/atividadeDiaria/disciplinas" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ficha de Sala (Diário)</h5>
                    <p class="card-text">
                        Lançar os Conteúdos, Tarefas e Ocorrências
                    </p>
                    <a href="/prof/diario/disciplinas" class="btn btn-primary">Diário</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Provas</h5>
                    <p class="card-text">
                        Cadastrar Conteúdos e Questões
                    </p>
                    <a href="/prof/provas/<?php echo e(date("Y")); ?>" class="btn btn-primary">Provas</a>
                </div>
            </div>
        </div>
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ocorrências</h5>
                    <p class="card-text">
                        Consultar as Ocorrências
                    </p>
                    <a href="/prof/ocorrencias/disciplinas" class="btn btn-primary">Ocorrências</a>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
<div class="container">
    <?php if(count($documentos)>0): ?>
        <h2 class="text-center">Documentos Importantes</h2>
            <div class="row justify-content-center">
            <?php $__currentLoopData = $documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-auto">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header border-light"><h6><b><?php echo e($documento->titulo); ?></b></h6></div>
                    <div class="card-body text-center">
                        <a type="button" class="badge bg-success" href="/prof/documentos/download/<?php echo e($documento->id); ?>"><i class="material-icons md-48">cloud_download</i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"home"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/home_prof.blade.php ENDPATH**/ ?>