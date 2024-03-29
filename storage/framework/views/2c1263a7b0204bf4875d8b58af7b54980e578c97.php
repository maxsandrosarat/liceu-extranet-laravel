<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
        <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
            <h5 class="card-title">Ocorrências - Disciplinas</h5>
            <?php if(count($profDiscs)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem disciplinas cadastradas!
                </div>
            <?php else: ?>
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
                                <a href="/prof/ocorrencias/<?php echo e($disc->disciplina_id); ?>" class="btn btn-primary btn-lg btn-block"><?php echo e($disc->disciplina->nome); ?> (<?php if($disc->disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"ocorrencias"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/profs/ocorrencias_disciplinas.blade.php ENDPATH**/ ?>