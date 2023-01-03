<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/prof/ocorrencias/<?php echo e($disciplina->id); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Painel de Ocorrências - Discplina: <?php echo e($disciplina->nome); ?> - Turma: <?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?></h5>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong><?php echo e($message); ?></strong>
                </div>
            <?php endif; ?>
            <?php if(count($ocorrencias)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem ocorrências lançadas!
                        <?php else: ?> <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/prof/ocorrencias/<?php echo e($disciplina->id); ?>" class="btn btn-success">Voltar</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card">
                <div class="card border">
                    <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/prof/ocorrencias/filtro/<?php echo e($disciplina->id); ?>/<?php echo e($turma->id); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="tipo" name="tipo" style="width:170px;">
                                <option value="">Selecione o tipo</option>
                                <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->codigo); ?> - <?php echo e($tipo->descricao); ?> - <?php if($tipo->tipo=="despontuacao"): ?> Despontuar: <?php else: ?> Elogio: <?php endif; ?><?php echo e($tipo->pontuacao); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="tipo">Tipo</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="aluno" name="aluno" style="width:170px;">
                                <option value="">Selecione o aluno</option>
                                <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($aluno->id); ?>"><?php echo e($aluno->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="aluno">Aluno</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="dataInicio">
                            <label for="dataInicio">Data Início</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="dataFim">
                            <label for="dataFim">Data Fim</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <br/>
            <div class="table-responsive-xl">
            <b><h5 class="font-italic">Exibindo <?php echo e($ocorrencias->count()); ?> de <?php echo e($ocorrencias->total()); ?> de Ocorrências (<?php echo e($ocorrencias->firstItem()); ?> a <?php echo e($ocorrencias->lastItem()); ?>)</u></h5></b>
            <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Pontuação</th>
                        <th>Aluno</th>
                        <th>Tipo de Ocorrencia</th>
                        <th>Data</th>
                        <th>Observação</th>
                        <th>Ações</th>
                        <th>Aprovação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $ocorrencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocorrencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td data-toggle="tooltip" data-placement="bottom" title="<?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?>"><?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?></td>
                        <td><?php echo e($ocorrencia->tipo_ocorrencia->pontuacao); ?></td>
                        <td data-toggle="tooltip" data-placement="bottom" title="Código: <?php echo e($ocorrencia->id); ?>"><?php echo e($ocorrencia->aluno->name); ?></td>
                        <td><?php echo e($ocorrencia->disciplina->nome); ?></td>
                        <td><?php echo e(date("d/m/Y", strtotime($ocorrencia->data))); ?></td>
                        <td>
                            <?php if($ocorrencia->observacao==""): ?>
                            <?php else: ?>
                            <button type="button" class="badge bg-info" data-bs-toggle="modal" data-bs-target="#exampleModalOb<?php echo e($ocorrencia->id); ?>">
                                <i class="material-icons white">visibility</i>
                            </button>
                            <?php endif; ?>
                            <div class="modal fade" id="exampleModalOb<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Observação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo e($ocorrencia->observacao); ?></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if($ocorrencia->aprovado==1): ?> 
                            <?php else: ?>
                                <?php if($ocorrencia->aprovado!==NULL): ?>
                                <?php else: ?>
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalOcorrencia<?php echo e($ocorrencia->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <div class="modal fade" id="exampleModalOcorrencia<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Ocorrência</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/prof/ocorrencias/editar/<?php echo e($ocorrencia->id); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <h6><b>Aluno: <?php echo e($ocorrencia->aluno->name); ?></b></h6>
                                            <h6><b>Tipo de Ocorrência: <?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?></b></h6>
                                            <h6><b>Disciplina: <?php echo e($ocorrencia->disciplina->nome); ?></b></h6>
                                            <br/>
                                            <label for="observacao">Observação</label>
                                            <textarea class="form-control" name="observacao" id="observacao" rows="10" cols="40" maxlength="500"><?php echo e($ocorrencia->observacao); ?></textarea> 
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="badge bg-primary">Editar</button>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>

                            <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($ocorrencia->id); ?>" data-toggle="tooltip" data-placement="left" title="Excluir"><i class="material-icons md-18">delete</i></button></td>
                                        <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Excluir Ocorrência Nº <?php echo e($ocorrencia->id); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6><b>Aluno: <?php echo e($ocorrencia->aluno->name); ?></b></h6>
                                                        <h6><b>Tipo de Ocorrência: <?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?></b></h6>
                                                        <h6><b>Disciplina: <?php echo e($ocorrencia->disciplina->nome); ?></b></h6>
                                                        <h5>Tem certeza que deseja excluir essa ocorrência?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                        <form action="/prof/ocorrencias/apagar/<?php echo e($ocorrencia->id); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="ocorrencia" value="<?php echo e($ocorrencia->id); ?>" required>
                                                            <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($ocorrencia->aprovado==1): ?>
                                <b><p style="color: green;"><i class="material-icons green">check_circle</i> APROVADO</p></b> 
                            <?php else: ?>
                                <?php if($ocorrencia->aprovado!==NULL): ?>
                                <b><p style="color: red;"><i class="material-icons red">highlight_off</i> REPROVADO</p></b>
                                <?php else: ?>
                                    <p><i class="material-icons">update</i> Aguardando Análise</p>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            <div class="card-footer">
                <?php echo e($ocorrencias->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"ocorrencias"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/profs/ocorrencias_prof.blade.php ENDPATH**/ ?>