

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/prof/diario/disciplinas" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Diário</h5>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(count($profTurmas)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem turmas cadastradas!
                </div>
            <?php else: ?>
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">Disciplinas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $profTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turmaDisc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($turmaDisc->turma->ativo==true): ?>
                        <tr>
                            <td>
                                <a href="/prof/diario/<?php echo e($discId); ?>/<?php echo e($turmaDisc->turma->id); ?>" class="btn btn-primary btn-lg btn-block"><?php echo e($turmaDisc->turma->serie); ?>º ANO <?php echo e($turmaDisc->turma->turma); ?> (<?php if($turmaDisc->turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turmaDisc->turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"diario"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/diario_turmas.blade.php ENDPATH**/ ?>