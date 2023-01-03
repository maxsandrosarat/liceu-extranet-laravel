

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
        <a href="/prof/atividadeDiaria/disciplinas" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h5 class="card-title">Painel de Atividades Diárias - Disciplina: <?php echo e($disciplina->nome); ?></h5>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Atividade">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Atividade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="/prof/atividadeDiaria" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="disciplina" value="<?php echo e($disciplina->id); ?>">
                        <div class="col-auto form-floating">
                            <select class="form-select" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($turma->turma->id); ?>"><?php echo e($turma->turma->serie); ?>º ANO <?php echo e($turma->turma->turma); ?> (<?php if($turma->turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="data" id="data" required>
                            <label for="data">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="text" name="descricao" id="descricao" required>
                            <label for="descricao">Descrição</label>
                        </div>
                        <div class="col-auto form-floating">
                        <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                        </div>
                        <b style="font-size: 80%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
            <?php if(count($atividades)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem atividades cadastradas!
                        <?php endif; ?>
                        <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/prof/atividadeDiaria" class="btn btn-sm btn-success">Voltar</a>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/prof/atividadeDiaria/filtro/<?php echo e($disciplina->id); ?>">
                        <div class="col-auto form-floating">
                            <select class="form-select" id="turma" name="turma">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($turma->turma->id); ?>"><?php echo e($turma->turma->serie); ?>º ANO <?php echo e($turma->turma->turma); ?> (<?php if($turma->turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="data" id="data">
                            <label for="data">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control mr-sm-2" type="text" placeholder="Digite a descrição" name="descricao">
                            <label for="descricao">Descrição Atividade</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo <?php echo e($atividades->count()); ?> de <?php echo e($atividades->total()); ?> de Atividades (<?php echo e($atividades->firstItem()); ?> a <?php echo e($atividades->lastItem()); ?>)</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $dataAtual = date("Y-m-d");
                ?>
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo e($atividade->id); ?>"><div id="my-div" class="bd-callout <?php if($atividade->impresso==1): ?> bd-callout-success <?php else: ?> <?php if($atividade->data==$dataAtual && $atividade->impresso==0): ?> bd-callout-warning <?php else: ?> <?php if($atividade->data>$dataAtual && $atividade->impresso==0): ?> bd-callout-info <?php else: ?> <?php if($atividade->data<$dataAtual && $atividade->impresso==0): ?> bd-callout-danger <?php endif; ?> <?php endif; ?> <?php endif; ?> <?php endif; ?>">
                        <h4><?php echo e($atividade->disciplina->nome); ?> - <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?> - <?php echo e($atividade->descricao); ?></h4>
                        <p>Data: <?php echo e(date("d/m/Y", strtotime($atividade->data))); ?></p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo e($atividade->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atividade: <?php echo e($atividade->descricao); ?> <?php if($atividade->impresso==0): ?> <button type="button" class="badge bg-warning" data-toggle="tooltip" data-placement="bottom" title="Não Impresso" disabled><i class="material-icons">print_disabled</i></button> <?php else: ?> <button type="button" class="badge bg-success" data-toggle="tooltip" data-placement="bottom" title="Impresso" disabled><i class="material-icons">print</i></button> <?php endif; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Disciplina: <?php echo e($atividade->disciplina->nome); ?> <br/> <hr/>
                                Turma: <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?> <br/> <hr/>
                                Descrição: <?php echo e($atividade->descricao); ?> <br/> <hr/>
                                Data: <?php echo e(date("d/m/Y", strtotime($atividade->data))); ?> <br/> <hr/>
                                Criado por: <?php echo e($atividade->usuario); ?><br/>
                                Data da Criação: <?php echo e(date("d/m/Y H:i", strtotime($atividade->created_at))); ?><br/>
                                Última Alteração: <?php echo e(date("d/m/Y H:i", strtotime($atividade->updated_at))); ?>

                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge bg-success" href="/prof/atividadeDiaria/download/<?php echo e($atividade->id); ?>"><i class="material-icons md-48">cloud_download</i></a> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#modalEditar<?php echo e($atividade->id); ?>"><i class="material-icons md-48">edit</i></button> <a type="button" class="badge bg-danger" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($atividade->id); ?>" data-bs-toggle="tooltip" data-placement="bottom" title="Excluir Atividade"><i class="material-icons md-48">delete</i></a> <br/> <hr/>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="modalEditar<?php echo e($atividade->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Atividade: <?php echo e($atividade->descricao); ?> - <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="/prof/atividadeDiaria/editar/<?php echo e($atividade->id); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="disciplina" value="<?php echo e($disciplina->id); ?>">
                                        <div class="col-auto form-floating">
                                            <select id="disciplina" class="form-control" name="turma" required>
                                                <option value="<?php echo e($atividade->turma->id); ?>"><?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?></option>
                                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($turma->turma->id!=$atividade->turma->id): ?>
                                                <option value="<?php echo e($turma->turma->id); ?>"><?php echo e($turma->turma->serie); ?>º ANO <?php echo e($turma->turma->turma); ?></option>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <label for="turma">Turma</label>
                                        </div>
                                        <div class="col-auto form-floating">
                                            <input class="form-control" type="date" name="data" id="data" value="<?php echo e(date("Y-m-d", strtotime($atividade->data))); ?>" required>
                                            <label for="data">Data</label>
                                        </div>
                                        <div class="col-auto form-floating">
                                            <input type="text" class="form-control" name="descricao" id="descricao" value="<?php echo e($atividade->descricao); ?>" required>
                                            <label for="descricao">Descrição</label>
                                        </div>
                                        <div class="col-auto form-floating">
                                            <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf">
                                        </div>
                                        <b style="font-size: 80%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>
                            <!-- Modal Deletar -->
                            <div class="modal fade" id="exampleModalDelete<?php echo e($atividade->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Atividade: <?php echo e($atividade->descricao); ?> - <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Tem certeza que deseja excluir essa atividade?</h5>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-danger" href="/prof/atividadeDiaria/apagar/<?php echo e($atividade->id); ?>">Excluir</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="card-footer">
                <?php echo e($atividades->links()); ?>

            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"atividade"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/profs/atividade_diaria_prof.blade.php ENDPATH**/ ?>