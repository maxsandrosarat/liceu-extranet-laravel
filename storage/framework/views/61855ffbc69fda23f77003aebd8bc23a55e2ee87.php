

<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <?php if(session('mensagem')): ?>
                        <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                            <?php echo e(session('mensagem')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col" style="text-align: left">
                            <a href="/prof/diario/<?php echo e($disc->id); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
                        </div>
                        <div class="col" style="text-align: right">
                           
                        </div>
                    </div>
                    <br/>
                    <h5 class="card-title">Diário - <?php echo e($disc->nome); ?> - <?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?></h5>
                    <form method="GET" action="/prof/diario">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="disciplina" value="<?php echo e($disc->id); ?>">
                        <input type="hidden" name="turma" value="<?php echo e($turma->id); ?>">
                        <div class="col-sm-3 form-floating">
                            <input class="form-control" type="date" name="data" value="<?php echo e(date("Y-m-d")); ?>" required>
                            <label for="data">Selecione o Dia</label>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Lançar Diário</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"diario"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/diario_dia.blade.php ENDPATH**/ ?>