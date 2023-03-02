

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(count($planejamentos)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem planejamentos cadastrados!
                </div>
            <?php else: ?>
            <div class="row">
                <div class="col">
                    <form action="/prof/planejamentos" method="GET">
                        <?php echo csrf_field(); ?>
                        <label for="ano">Selecione o ano:
                        <select class="form-select" id="ano" name="ano">
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $anos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $an): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($an->ano); ?>"><?php echo e($an->ano); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select></label>
                        <input type="submit" class="btn btn-primary" value="Selecionar">
                    </form>
                </div>
                <div class="col" style="text-align: right;">
                    <h5>Baixe o modelo da Máscara</h5>
                    <a type="button" class="btn btn-info" href="/prof/templates/download/mascara-planejamento">Baixar Máscara</a>
                </div>
            </div>
            <h5 class="card-title">Planejamentos - <?php echo e($ano); ?></h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Ano</th>
                        <th>Série(s)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $planejamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($plan->id); ?></td>
                        <td><?php echo e($plan->descricao); ?></td>
                        <td><?php echo e($plan->ano); ?></td>
                        <td>
                            <ul>
                            <?php $__currentLoopData = $plan->series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($serie->serie); ?>º</li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                        <td>
                            <a href="/prof/planejamentos/painel/<?php echo e($plan->id); ?>" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-48">attach_file</i></a>
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
<?php echo $__env->make('layouts.app', ["current"=>"home"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/home_planejamentos.blade.php ENDPATH**/ ?>