

<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col" style="text-align: left">
                        <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
                        </div>
                        <div class="col" style="text-align: right">
                            <a type="button" class="btn btn-info" href="/admin/diario/relatorio">Relátorios</a>
                        </div>
                    </div>
                    <br/>
                    <h5 class="card-title">Diário</h5>
                    <?php if(session('mensagem')): ?>
                        <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                            <?php echo e(session('mensagem')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form class="row g-3" method="GET" action="/admin/diario/consulta">
                        <?php echo csrf_field(); ?>
                        <div class="col-sm form-floating">
                            <select class="form-select" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º<?php echo e($turma->turma); ?><?php echo e($turma->turno); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-sm form-floating">
                            <input class="form-control" type="date" name="data" value="<?php echo e(date("Y-m-d")); ?>" required>
                            <label for="data">Selecione o Dia</label>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/home_diario.blade.php ENDPATH**/ ?>