<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/prof/ocorrencias/disciplinas" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Ocorrências - Disciplina: <?php echo e($disciplina->nome); ?> (<?php if($disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</h5>
            <?php if(count($turmaDiscs)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem turmas cadastradas!
                </div>
            <?php else: ?>
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">Turma(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $turmaDiscs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turmaDisc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="/prof/ocorrencias/<?php echo e($disciplina->id); ?>/<?php echo e($turmaDisc->turma->id); ?>" class="btn btn-primary btn-lg btn-block"><?php echo e($turmaDisc->turma->serie); ?>º<?php echo e($turmaDisc->turma->turma); ?><?php echo e($turmaDisc->turma->turno); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"home"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/ocorrencias_turmas.blade.php ENDPATH**/ ?>