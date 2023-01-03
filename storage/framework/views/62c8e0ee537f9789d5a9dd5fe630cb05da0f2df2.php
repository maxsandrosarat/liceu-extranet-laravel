

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Tipos de Ocorrências</h5>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Tipo de Ocorrência">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastro de Tipos Ocorrências</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" action="/admin/tiposOcorrencias" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="codigo" type="text" id="codigo" placeholder="Código" required/>
                                    <label for="codigo">Código</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="descricao" type="text" id="descricao" placeholder="Descrição" required/>
                                    <label for="descricao">Descrição</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="">Selecione o tipo</option>
                                        <option value="despontuacao">Despontuação</option>
                                        <option value="elogio">Elogio</option>
                                    </select>
                                    <label for="tipo">Tipo</label>
                                </div> 
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="pontuacao" type="text" id="pontuacao" placeholder="Pontuação" required/>
                                    <label for="pontuacao">Pontuação</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(count($tipos)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem tipos cadastrados!
                </div>
            <?php else: ?>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Pontuação</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($tipo->codigo); ?></td>
                        <td><?php echo e($tipo->descricao); ?></td>
                        <td><?php if($tipo->tipo=='despontuacao'): ?> Despontuação <?php else: ?> Elogio <?php endif; ?></td>
                        <td><?php echo e($tipo->pontuacao); ?></td>
                        <td>
                            <?php if($tipo->ativo==1): ?>
                                <b><i class="material-icons green">check_circle</i></b>
                            <?php else: ?>
                                <b><i class="material-icons red">highlight_off</i></b>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo e($tipo->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <div class="modal fade" id="exampleModal<?php echo e($tipo->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar Tipo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row g-3" action="/admin/tiposOcorrencias/editar/<?php echo e($tipo->id); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="col-12 form-floating">
                                                    <input class="form-control" name="codigo" type="text" id="codigo" value="<?php echo e($tipo->codigo); ?>" required/>
                                                    <label for="codigo">Código</label>
                                                </div>
                                                <div class="col-12 form-floating">
                                                    <input class="form-control" name="descricao" type="text" id="descricao" value="<?php echo e($tipo->descricao); ?>" required/>
                                                    <label for="descricao">Descrição</label>
                                                </div>
                                                <div class="col-12 form-floating">
                                                    <select class="form-select" id="tipo" name="tipo" required>
                                                        <option value="<?php echo e($tipo->tipo); ?>"><?php if($tipo->tipo=="despontuacao"): ?> Despontuação <?php else: ?> Elogio <?php endif; ?></option>
                                                            <?php if($tipo->tipo=="elogio"): ?>    
                                                            <option value="despontuacao">Despontuação</option>
                                                            <?php else: ?>
                                                            <option value="elogio">Elogio</option>
                                                            <?php endif; ?>
                                                    </select>
                                                    <label for="tipo">Tipo</label>
                                                </div> 
                                                <div class="col-12 form-floating">
                                                    <input class="form-control" name="pontuacao" type="text" id="pontuacao" value="<?php echo e($tipo->pontuacao); ?>" required/>
                                                    <label for="pontuacao">Pontuação</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($tipo->ativo==1): ?>
                                <a href="/admin/tiposOcorrencias/apagar/<?php echo e($tipo->id); ?>" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            <?php else: ?>
                                <a href="/admin/tiposOcorrencias/apagar/<?php echo e($tipo->id); ?>" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"administrativo"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/tipo_ocorrencia.blade.php ENDPATH**/ ?>