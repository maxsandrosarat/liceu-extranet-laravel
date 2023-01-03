<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/outro/estoque" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Relatório de Entradas/Saídas</h5>
            <!-- Button trigger modal -->
            <a type="button" class="float-button" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Lançar Entrada e Saída">
                <i class="material-icons blue md-60">add_circle</i>
            </a>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lançamento de Entrada e Saída</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/outro/entradaSaida" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <br>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" type="radio" id="entrada" name="tipo" value="entrada" required>
                                <label class="form-check-label" for="entrada">
                                Entrada
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" type="radio" id="saida" name="tipo" value="saida" required>
                                <label class="form-check-label" for="entrada">
                                Saída
                                </label>
                            </div>
                            <br>
                            <label for="data">Selecione a Data
                            <input class="form-control" type="date" name="data" value="<?php echo e(date("Y-m-d")); ?>" required></label>
                            <br>
                            <label for="produtos">Produto</label>
                            <select class="custom-select" id="produtos" name="produto" required>
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prod->id); ?>"><?php echo e($prod->nome); ?> - Estoque: <?php echo e($prod->estoque); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <br><br>
                            <label for="qtd">Quantidade</label>
                            <input class="form-control" type="number" class="form-control" name="qtd" id="qtd" placeholder="Digite a quantidade">
                            <br>
                            <label for="req">Requisitante</label>
                            <input class="form-control" type="text" class="form-control" name="req" id="req" placeholder="Digite o requisitante">
                            <br>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                </div>
                </form>
                </div>
            </div>
            </div>
            <?php if(count($rels)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem movimentos cadastrados! Faça novo movimento no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        <?php else: ?> <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/outro/entradaSaida" class="btn btn-success">Voltar</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card border">
            <h5>Filtros: </h5>
            <form class="form-inline my-2 my-lg-0" method="GET" action="/outro/entradaSaida/filtro">
                <?php echo csrf_field(); ?>
                <label for="tipo">Tipo</label>
                <select class="custom-select" id="tipo" name="tipo">
                    <option value="">Selecione o tipo</option>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
                <label for="produto">Produto
                <select class="custom-select" id="produto" name="produto">
                    <option value="">Selecione</option>
                    <?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($prod->id); ?>"><?php echo e($prod->nome); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select></label>
                <label for="dataInicio">Data Início
                <input class="form-control" type="date" name="dataInicio"></label>
                <label for="dataFim">Data Fim
                <input class="form-control" type="date" name="dataFim"></label>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
            </form>
            </div>
            <div class="table-responsive-xl">
            <table id="yesprint" class="table table-striped table-ordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Produto</th>
                        <th>Qtd</th>
                        <th>Requisitante</th>
                        <th>Usuário</th>
                        <th>Data</th>
                        <th>Lançamento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $rels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($rel->tipo=='entrada'): ?> <tr style="color:blue;"> <?php else: ?> <tr style="color:red;"> <?php endif; ?>
                        <td><?php echo e($rel->id); ?></td>
                        <td><?php if($rel->tipo=='entrada'): ?> Entrada <?php else: ?> Saída <?php endif; ?></td>
                        <td><?php echo e($rel->produto_nome); ?></td>
                        <td><?php echo e($rel->quantidade); ?></td>
                        <td><?php echo e($rel->requisitante); ?></td>
                        <td><?php echo e($rel->usuario); ?></td>
                        <td><?php echo e(date("d/m/Y", strtotime($rel->data))); ?></td>
                        <td><?php echo e(date("d/m/Y H:i", strtotime($rel->created_at))); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
			<div class="card-footer">
            <?php echo e($rels->links()); ?>

			</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"estoque"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/entrada_saida.blade.php ENDPATH**/ ?>