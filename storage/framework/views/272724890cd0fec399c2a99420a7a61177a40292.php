

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/outro/listaCompras" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Produtos no Sistema com Estoque atual</h5>
            <?php if(count($prods)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem produtos cadastrados!
                </div>
            <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-md-auto">
                    <form action="/outro/listaCompras" method="POST">
                        <?php echo csrf_field(); ?>
                        <ul id="lista-produtos" class="list-group">
                        <?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <input type="checkbox" id="produto<?php echo e($prod->id); ?>" class="form-check-input" name="produtos[]" value="<?php echo e($prod->id); ?>">
                                <label class="form-check-label" for="produto<?php echo e($prod->id); ?>"><?php echo e($prod->nome); ?></label>
                                <span class="badge bg-primary rounded-pill"><?php echo e($prod->estoque); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        </ul>
                        <br/>
                        <div class="input-group mb-3">
                            <input id="input-prodEx" type="text" class="form-control" name="produtoExtra" placeholder="Adicionar Produto Extra">
                            <div class="input-group-append">
                                <button id="botao-add-prod" class="btn btn-success btn-sm" type="button" data-toggle="tooltip" data-placement="bottom" title="Adicionar Produto" onclick="adicionarProduto()"><i class="material-icons white">add_circle</i></button>
                            </div>
                        </div>
                        <br/>
                        <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"estoque"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/lista_compra_selecionar.blade.php ENDPATH**/ ?>