<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/outro/estoque" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
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
            <h5 class="card-title">Listas de Compra</h5>
            <a type="button" class="float-button" href="/outro/listaCompras/nova" data-toggle="tooltip" data-placement="bottom" title="Nova Lista">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <?php if(count($listaProds)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem listas cadastradas!
                </div>
            <?php else: ?>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Usuário</th>
                        <th>Criação</th>
                        <th>Produtos</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $listaProds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($lista->id); ?></td>
                        <td><?php echo e($lista->usuario); ?></td>
                        <td><?php echo e(date("d/m/Y H:i", strtotime($lista->created_at))); ?></td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModal<?php echo e($lista->id); ?>">
                            Produtos
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo e($lista->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Produtos da Lista <?php echo e($lista->id); ?> - <?php echo e(date("d/m/Y", strtotime($lista->created_at))); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">
                                        <?php
                                            $qtd = $lista->produtos->count();
                                            $qtdEx = $lista->produtosExtras->count();
                                        ?>
                                        <?php if($qtd==0 && $qtdEx==0): ?>
                                            <p>Todos os Itens desta lista foram removidos!</p>
                                        <?php else: ?>
                                            <?php if($qtd!=0): ?>
                                                <?php $__currentLoopData = $lista->produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    <?php echo e($produto->nome); ?>

                                                    <a href="/outro/listaCompras/removerItem/<?php echo e($lista->id); ?>/<?php echo e($produto->id); ?>"><i class="material-icons red" data-toggle="tooltip" data-placement="bottom" title="Desvincular">remove_circle</i></a>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <?php if($qtdEx!=0): ?>
                                                <?php $__currentLoopData = $lista->produtosExtras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    <?php echo e($produto->nome); ?>

                                                    <a href="/outro/listaCompras/removerItemExtra/<?php echo e($lista->id); ?>/<?php echo e($produto->nome); ?>"><i class="material-icons red" data-toggle="tooltip" data-placement="bottom" title="Desvincular">remove_circle</i></a>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <td>
                            <?php if($qtd==0 && $qtdEx==0): ?>
                            <?php else: ?>
                            <a target="_blank" href="/outro/listaCompras/pdf/<?php echo e($lista->id); ?>" class="badge badge-success">Gerar PDF</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="card-footer">
                <?php echo e($listaProds->links()); ?>

            </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"estoque"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/lista_compra.blade.php ENDPATH**/ ?>