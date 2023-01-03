

<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Categorias</h5>
                    <p class="card-text">
                        Consulte e Cadastre suas categorias
                    </p>
                    <a href="/outro/categorias" class="btn btn-primary">Categorias</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Produtos</h5>
                    <p class="card-text">
                        Consulte e Cadastre seus produtos
                    </p>
                    <a href="/outro/produtos" class="btn btn-primary">Produtos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Entradas e Saídas</h5>
                    <p class="card-text">
                        Veja e faça suas entradas e saídas até o momento
                    </p>
                    <a href="/outro/entradaSaida" class="btn btn-primary">Relatório</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Lista de Compras</h5>
                    <p class="card-text">
                        Selecione produtos e gere uma lista de compras
                    </p>
                    <a href="/outro/listaCompras" class="btn btn-primary">Lista de Compras</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"estoque"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/outros/home_estoque.blade.php ENDPATH**/ ?>