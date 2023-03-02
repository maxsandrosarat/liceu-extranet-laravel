

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col">
                    <form action="/admin/planejamentos" method="GET">
                        <?php echo csrf_field(); ?>
                        <label for="ano">Selecione o ano:
                        <select class="form-select" id="ano" name="ano">
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $anos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $an): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($an->ano); ?>"><?php echo e($an->ano); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select></label>
                        <input type="submit" class="btn btn-primary" value="Selecionar">
                    </form>
                </div>
                <div class="col" style="text-align: right;">
                    <h5>Baixe o modelo da Máscara</h5>
                    <a type="button" class="btn btn-info" href="/admin/templates/download/mascara-planejamento">Baixar Máscara</a>
                </div>
            </div>
            <?php if(count($planejamentos)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem planejamentos cadastrados para o ano <?php echo e($ano); ?>! Tente consultar outros anos!
                </div>
            <?php else: ?>
            <h5 class="card-title">Planejamentos - <?php echo e($ano); ?></h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Ano</th>
                        <th>Série(s)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $planejamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($plan->id); ?></td>
                        <td><?php echo e($plan->descricao); ?></td>
                        <td><?php echo e($plan->ano); ?></td>
                        <td>
                            <ul>
                            <?php $__currentLoopData = $plan->series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($serie->serie); ?>º</li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                        <td>
                            <a href="/admin/planejamentos/painel/<?php echo e($plan->id); ?>" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-48">attach_file</i></a>
                            <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($plan->id); ?>"><i class="material-icons md-48">delete</i></button></td>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($plan->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Excluir Prova: <?php echo e($plan->descricao); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Tem certeza que deseja excluir esse planejamento?</h5>
                                            <p>Não será possivel reverter esta ação.</p>
                                            <a href="/admin/planejamentos/apagar/<?php echo e($plan->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <br>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="habilitarSubmit();">
        Gerar Painel
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Gerar Painel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <form action="/admin/planejamentos/gerar" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="col-12 form-floating">
                        <input class="form-control" type="text" name="descricao" id="descricao" placeholder="Descrição" required>
                        <label for="descricao">Descrição</label>
                    </div>
                    <div class="col-12 form-floating">
                        <input class="form-control" type="number" name="ano" id="ano" placeholder="Ano" required>
                        <label for="ano">Ano</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="processamento" class="btn btn-primary">Gerar</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <br><br>
    <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/home_planejamentos.blade.php ENDPATH**/ ?>