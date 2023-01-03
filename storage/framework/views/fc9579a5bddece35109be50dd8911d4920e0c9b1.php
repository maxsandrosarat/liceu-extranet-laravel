

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <h5 class="card-title">Painel de Ocorrências</h5>
            <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong><?php echo e($message); ?></strong>
                </div>
            <?php endif; ?>
            <?php if(count($ocorrencias)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem ocorrências cadastradas!
                        <?php else: ?> <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/admin/ocorrencias" class="btn btn-success">Voltar</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card">
                <div class="card border">
                    <h5 class="card-title">Filtros:</h5>
                    <form class="form-inline my-2 my-lg-0" method="GET" action="/admin/ocorrencias/filtro">
                        <?php echo csrf_field(); ?>
                        <label for="tipo">Tipo
                        <select class="custom-select" id="tipo" name="tipo" style="width:170px;">
                            <option value="">Selecione o tipo</option>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->codigo); ?> - <?php echo e($tipo->descricao); ?> - <?php if($tipo->tipo=="despontuacao"): ?> Despontuar: <?php else: ?> Elogio: <?php endif; ?><?php echo e($tipo->pontuacao); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select></label>
                        <label for="aluno">Aluno
                        <select class="custom-select" id="aluno" name="aluno" style="width:170px;">
                            <option value="">Selecione o aluno</option>
                            <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($aluno->id); ?>"><?php echo e($aluno->name); ?> - <?php echo e($aluno->turma->serie); ?>º ANO <?php echo e($aluno->turma->turma); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select></label>
                        <label for="dataInicio">Data Início
                        <input class="form-control" type="date" name="dataInicio"></label>
                        <label for="dataFim">Data Fim
                        <input class="form-control" type="date" name="dataFim"></label>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                    </form>
                </div>
            </div>
            <br/>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th>Tipo</th>
                        <th>Aluno</th>
                        <th>Turna</th>
                        <th>Disciplina</th>
                        <th>Data</th>
                        <th>Observação</th>
                        <th>Ações</th>
                        <th>Aprovação</th>
                        <th>Resp. Ciente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $ocorrencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocorrencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td data-toggle="tooltip" data-placement="bottom" title="<?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?>"><?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?></td>
                        <td data-toggle="tooltip" data-placement="bottom" title="Código: <?php echo e($ocorrencia->id); ?>"><?php echo e($ocorrencia->aluno->name); ?></td>
                        <td><?php echo e($ocorrencia->aluno->turma->serie); ?>º ANO <?php echo e($ocorrencia->aluno->turma->turma); ?></td>
                        <td><?php echo e($ocorrencia->disciplina->nome); ?></td>
                        <td><?php echo e(date("d/m/Y", strtotime($ocorrencia->data))); ?></td>
                        <td>
                            <?php if($ocorrencia->observacao==""): ?>
                            <?php else: ?>
                            <button type="button" class="badge badge-info" data-toggle="modal" data-target="#exampleModalOb<?php echo e($ocorrencia->id); ?>">
                                <i class="material-icons white">visibility</i>
                            </button>
                            <?php endif; ?>
                            <div class="modal fade" id="exampleModalOb<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Observação</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
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
                            <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#exampleModalOcorrencia<?php echo e($ocorrencia->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <div class="modal fade" id="exampleModalOcorrencia<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Ocorrência</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/admin/ocorrencias/editar/<?php echo e($ocorrencia->id); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <h6><b>Aluno: <?php echo e($ocorrencia->aluno->name); ?></b></h6>
                                            <h6><b>Tipo de Ocorrência: <?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?></b></h6>
                                            <h6><b>Disciplina: <?php echo e($ocorrencia->disciplina->nome); ?></b></h6>
                                            <br/>
                                            <label for="observacao">Observação</label>
                                            <textarea class="form-control" name="observacao" id="observacao" rows="10" cols="40" maxlength="500"><?php echo e($ocorrencia->observacao); ?></textarea> 
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="badge badge-primary">Editar</button>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>

                            
                            <?php endif; ?>
                            <?php endif; ?>
                            <button type="button" class="badge badge-danger" data-toggle="modal" data-target="#exampleModalDelete<?php echo e($ocorrencia->id); ?>" data-toggle="tooltip" data-placement="bottom" title="Excluir"><i class="material-icons md-18">delete</i></button></td>
                                        <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Ocorrência: <?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?> - <?php echo e($ocorrencia->aluno->name); ?> - <?php echo e($ocorrencia->disciplina->nome); ?> - <?php echo e(date("d/m/Y", strtotime($ocorrencia->data))); ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Tem certeza que deseja excluir essa ocorrência?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                        <a href="/admin/ocorrencias/apagar/<?php echo e($ocorrencia->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        </td>
                        <td>
                            <?php if($ocorrencia->aprovado==1): ?>
                                <b><p style="color: green; font-size: 50%;"><i class="material-icons green">check_circle</i> APROVADO</p></b>
                            <?php else: ?>
                                <?php if($ocorrencia->aprovado!==NULL): ?>
                                    <b><p style="color: red; font-size: 50%;"><i class="material-icons red">highlight_off</i>REPROVADO</p></b>
                                <?php else: ?>
                                    <a href="/admin/ocorrencias/aprovar/<?php echo e($ocorrencia->id); ?>" class="badge badge-success"><i class="material-icons white">thumb_up</i></a>
                                    <a href="/admin/ocorrencias/reprovar/<?php echo e($ocorrencia->id); ?>" class="badge badge-danger"><i class="material-icons white">thumb_down</i></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($ocorrencia->responsavel_ciente==1): ?> <i class="material-icons green">thumb_up</i> <?php else: ?> <i class="material-icons red">thumb_down</i> <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="card-footer">
                <?php echo e($ocorrencias->links()); ?>

            </div>
            </div>
            <?php endif; ?>
        </div> 
    </div>
    <br>
    <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/ocorrencias_admin.blade.php ENDPATH**/ ?>