

<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <?php if(session('mensagem')): ?>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <p><?php echo e(session('mensagem')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <h5 class="card-title">Diário - <?php echo e($disc->nome); ?> - <?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?></h5>
                    <form method="GET" action="/prof/diario">
                        <?php echo csrf_field(); ?>
                    <input type="hidden" name="disciplina" value="<?php echo e($disc->id); ?>">
                    <input type="hidden" name="turma" value="<?php echo e($turma->id); ?>">
                    <label for="data">Selecione o Dia
                    <input class="form-control" type="date" name="data" value="<?php echo e(date("Y-m-d")); ?>" required></label>
                    <button type="submit" class="btn btn-primary">Lançar Diário</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<a href="/prof/diario/<?php echo e($disc->id); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"diario"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/profs/diario_dia.blade.php ENDPATH**/ ?>