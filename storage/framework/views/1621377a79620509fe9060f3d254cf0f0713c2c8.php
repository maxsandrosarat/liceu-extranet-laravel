<?php $__env->startSection('body'); ?>
<div class="jumbotron bg-light border border-secondary">
    <div class="row justify-content-center">
        <div class="col align-self-center">
        <div class="card-deck">
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Estoque</h5>
                        <p class="card-text">
                            Gerenciar Produtos, Categorias, Entrada&Saídas, entre outros.
                        </p>
                        <a href="/outro/estoque" class="btn btn-primary">Estoque</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Ficha de Sala (Diário)</h5>
                        <p class="card-text">
                            Lançamentos de Diário
                        </p>
                        <a href="/outro/diario" class="btn btn-primary">Diário</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Provas</h5>
                        <p class="card-text">
                            Consultar Conteúdos e Questões
                        </p>
                        <a href="/outro/simulados/<?php echo e(date("Y")); ?>" class="btn btn-primary">Provas</a>
                    </div>
                </div>
            </div>
            
        </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"home"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/home_outro.blade.php ENDPATH**/ ?>