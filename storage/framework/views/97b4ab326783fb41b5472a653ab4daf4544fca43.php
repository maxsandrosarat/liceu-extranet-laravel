

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <?php if($tipo=='diaria'): ?>
            <h5 class="card-title">Atividades Diárias</h5>
            <?php elseif($tipo=='ionica'): ?>
            <h5 class="card-title">Atividades da Plataforma Iônica</h5>
            <?php else: ?>

            <?php endif; ?>
            <?php if(count($profDiscs)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem disciplinas cadastradas!
                </div>
            <?php else: ?>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th style="text-align: center;">Disciplinas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $profDiscs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="/prof/atividadeDiaria/<?php echo e($disc->disciplina_id); ?>/<?php echo e($tipo); ?>" class="btn btn-primary btn-lg btn-block"><?php echo e($disc->disciplina->nome); ?> (<?php if($disc->disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"atividade"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/atividade_diaria_disciplinas.blade.php ENDPATH**/ ?>