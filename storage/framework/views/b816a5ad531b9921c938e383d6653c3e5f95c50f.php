

<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Administrativo</h5>
                    <p class="card-text">
                        Gerenciar Turmas, Alunos, Professores, entre outros.
                    </p>
                    <a href="/admin/administrativo" class="btn btn-primary">Administrativo</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Pedagógico</h5>
                    <p class="card-text">
                        Consultar Atividades, Provas, Diários, entre outros.
                    </p>
                    <a href="/admin/pedagogico" class="btn btn-primary">Pedagógico</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"home"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/home_admin.blade.php ENDPATH**/ ?>