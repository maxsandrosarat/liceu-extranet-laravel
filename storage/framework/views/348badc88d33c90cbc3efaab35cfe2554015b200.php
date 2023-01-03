<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/outro/estoque" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Produtos</h5>
            <a type="button" class="float-button" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Produto">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="card border">
                            <div class="card-body">
                                <form action="/outro/produtos" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label for="nomeProduto">Nome do Produto</label>
                                        <input type="text" class="form-control" name="nomeProduto" id="nomeProduto" placeholder="Digite o nome do produto" required>
                                        <label for="estoqueProduto">Estoque do Produto</label>
                                        <input type="number" class="form-control" name="estoqueProduto" id="estoqueProduto" placeholder="Digite a quantidade em estoque do produto" required>
                                        <br>
                                        <label for="categoriaProduto">Categoria</label>
                                        <select class="custom-select" id="categoriaProduto" name="categoriaProduto" required>
                                            <option value="">Selecione</option>
                                            <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->nome); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <?php if(count($prods)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem produtos cadastrados! Faça novo cadastro no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        <?php endif; ?>
                        <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/outro/produtos" class="btn btn-success">Voltar</a>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card border">
                <h5>Filtros: </h5>
                <form class="form-inline my-2 my-lg-0" method="GET" action="/outro/produtos/filtro">
                    <?php echo csrf_field(); ?>
                    <input class="form-control" type="text" placeholder="Nome do Produto" name="nomeProduto">
                    <select class="custom-select" id="categoria" name="categoria">
                        <option value="">Selecione uma categoria</option>
                        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->nome); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <select class="custom-select" id="ativo" name="ativo">
                        <option value="1">Ativo: Sim</option>
                        <option value="0">Ativo: Não</option>
                    </select>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                </form>
                </div>
            <h5>Exibindo <?php echo e($prods->count()); ?> de <?php echo e($prods->total()); ?> de Produtos (<?php echo e($prods->firstItem()); ?> a <?php echo e($prods->lastItem()); ?>)</h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Estoque</th>
                        <th>Categoria</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($prod->id); ?></td>
                        <td><?php echo e($prod->nome); ?></td>
                        <td><?php echo e($prod->estoque); ?></td>
                        <td><?php echo e($prod->categoria->nome); ?></td>
                        <td>
                            <?php if($prod->ativo==1): ?>
                                <b><i class="material-icons green">check_circle</i></b>
                            <?php else: ?>
                                <b><i class="material-icons red">highlight_off</i></b>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#exampleModal<?php echo e($prod->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo e($prod->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de Produto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card border">
                                            <div class="card-body">
                                                <form action="/outro/produtos/editar/<?php echo e($prod->id); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label for="nomeProduto">Nome do Produto</label>
                                                        <input type="text" class="form-control" name="nomeProduto" id="nomeProduto" value="<?php echo e($prod->nome); ?>" required>
                                                        <br>
                                                        <label for="categoriaProduto">Categoria</label>
                                                        <select class="custom-select" id="categoriaProduto" name="categoriaProduto" required>
                                                            <option value="<?php echo e($prod->categoria->id); ?>"><?php echo e($prod->categoria->nome); ?></option>
                                                            <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($cat->id==$prod->categoria->id || $cat->ativo==false): ?>
                                                                <?php else: ?>
                                                                <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->nome); ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <?php if($prod->ativo==1): ?>
                                <a href="/outro/produtos/apagar/<?php echo e($prod->id); ?>" class="badge badge-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            <?php else: ?>
                                <a href="/outro/produtos/apagar/<?php echo e($prod->id); ?>" class="badge badge-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <div class="card-footer">
            <?php echo e($prods->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"estoque"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/produtos.blade.php ENDPATH**/ ?>