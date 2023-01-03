

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
            <h5 class="card-title">Painel de Planejamentos - Ensino Fundamental - <?php echo e($planejamento->descricao); ?> - Ano: <?php echo e($planejamento->ano); ?></h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th>Disciplinas</th>
                        <?php $__currentLoopData = $fundTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($turma->serie); ?>º ANO</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $fundDiscs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundDisc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $fundPertence = 0;
                    ?>
                    <tr>
                        <td><?php echo e($fundDisc->nome); ?>

                        <?php $__currentLoopData = $fundTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $fundPertence = 0;
                            ?>
                            <?php $__currentLoopData = $fundDisc->turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turmaFund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($turmaFund->serie==$turma->serie): ?>
                                    <?php
                                        $fundPertence = 1;
                                    ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                            <?php $__currentLoopData = $contFunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contFund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($contFund->disciplina->nome == $fundDisc->nome && $contFund->serie==$turma->serie): ?>
                                        <?php if($fundPertence===0): ?> <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td> <?php else: ?>
                                            <?php if($contFund->arquivo==''): ?>
                                                <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#exampleModalAnexar<?php echo e($contFund->id); ?>"><i class="material-icons md-18">cloud_upload</i></button> 
                                            <?php else: ?>
                                                <?php if($contFund->comentario!=""): ?>
                                                <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                                <?php else: ?>
                                                    <?php if($contFund->conferido==1): ?> 
                                                    <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Conferido e Liberado">check_circle</i></a><br/>
                                                    <?php else: ?>
                                                    <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Conferido">highlight_off</i></a><br/>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <a type="button" class="badge badge-success" href="/admin/planejamentos/download/<?php echo e($contFund->id); ?>"><i class="material-icons md-18">cloud_download</i></a> <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#exampleModalAnexar<?php echo e($contFund->id); ?>"><i class="material-icons md-18">edit</i></button> <a type="button" class="badge badge-danger" data-toggle="modal" data-target="#exampleModalDelete<?php echo e($contFund->id); ?>"><i class="material-icons md-18 white">delete</i></a>
                                                <!-- Modal Deletar -->
                                                    <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($contFund->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Questões do <?php echo e($planejamento->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->serie); ?>º ANO</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h5>Tem certeza que deseja excluir esse arquivo?</h5>
                                                                    <p>Não será possivel reverter esta ação.</p>
                                                                    <a href="/admin/planejamentos/apagar/<?php echo e($contFund->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php endif; ?>
                                            </td>
                                            <!-- Modal Anexar -->
                                                    <div style="text-align: center;" class="modal fade" id="exampleModalAnexar<?php echo e($contFund->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Anexar Questões do <?php echo e($planejamento->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->serie); ?>º ANO</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="/admin/planejamentos/anexar/<?php echo e($contFund->id); ?>" enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <input type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                                                                    <br/>
                                                                    <b style="font-size: 90%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal Conferir -->
                                                        <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contFund->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do <?php echo e($planejamento->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->serie); ?>º ANO</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="/admin/planejamentos/conferir" method="POST" enctype="multipart/form-data">
                                                                            <?php echo csrf_field(); ?>
                                                                            <div class="form-group">
                                                                                <input type="hidden" name="id" value="<?php echo e($contFund->id); ?>">
                                                                                <h5>Comentário</h5>
                                                                                <textarea class="form-control" name="comentario" id="comentario" rows="10" cols="40" maxlength="500" <?php if($contFund->comentario==""): ?> placeholder="Escreva um comentário apenas se encontrar algum problema, caso contrário não escreva." <?php endif; ?>><?php if($contFund->comentario!=""): ?><?php echo e($contFund->comentario); ?><?php endif; ?></textarea>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                        <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">Painel de Questões de Provas - Ensino Médio - <?php echo e($planejamento->descricao); ?> - <?php echo e($planejamento->bimestre); ?>º Bimestre - Ano: <?php echo e($planejamento->ano); ?></h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th>Disciplinas</th>
                        <?php $__currentLoopData = $medioTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($turma->serie); ?>º ANO</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $medioDiscs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medioDisc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $medioPertence = 0;
                    ?>
                    <tr>
                        <td><?php echo e($medioDisc->nome); ?>

                        <?php $__currentLoopData = $medioTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $medioPertence = 0;
                            ?>
                            <?php $__currentLoopData = $medioDisc->turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turmaMedio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($turmaMedio->serie==$turma->serie): ?>
                                    <?php
                                        $medioPertence = 1;
                                    ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></td>
                            <?php $__currentLoopData = $contMedios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contMedio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($contMedio->disciplina->nome == $medioDisc->nome && $contMedio->serie==$turma->serie): ?>
                                    <?php if($medioPertence===0): ?> <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td> <?php else: ?>
                                        <?php if($contMedio->arquivo==''): ?>
                                        <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#exampleModalAnexar<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">cloud_upload</i></button> 
                                    <?php else: ?>
                                        <?php if($contMedio->comentario!=""): ?>
                                        <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        <?php else: ?>
                                            <?php if($contMedio->conferido==1): ?> 
                                            <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Conferido e Liberado">check_circle</i></a><br/>
                                            <?php else: ?>
                                            <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Conferido">highlight_off</i></a><br/>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <a type="button" class="badge badge-success" href="/admin/planejamentos/download/<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">cloud_download</i></a> <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#exampleModalAnexar<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">edit</i></button> <a type="button" class="badge badge-danger" data-toggle="modal" data-target="#exampleModalDelete<?php echo e($contMedio->id); ?>"><i class="material-icons md-18 white">delete</i></a>
                                        <!-- Modal Deletar -->
                                            <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Excluir Questões do <?php echo e($planejamento->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->serie); ?>º ANO</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>Tem certeza que deseja excluir esse arquivo?</h5>
                                                            <p>Não será possivel reverter esta ação.</p>
                                                            <a href="/admin/planejamentos/apagar/<?php echo e($contMedio->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endif; ?>
                                    </td>
                                    <!-- Modal Anexar -->
                                            <div style="text-align: center;" class="modal fade" id="exampleModalAnexar<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Anexar Questões do <?php echo e($planejamento->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->serie); ?>º ANO</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="/admin/planejamentos/anexar/<?php echo e($contMedio->id); ?>" enctype="multipart/form-data">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                                                            <br/>
                                                            <b style="font-size: 90%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- Modal Conferir -->
                                                <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do <?php echo e($planejamento->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->serie); ?>º ANO</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/admin/planejamentos/conferir" method="POST" enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="id" value="<?php echo e($contMedio->id); ?>">
                                                                        <h5>Comentário</h5>
                                                                        <textarea class="form-control" name="comentario" id="comentario" rows="10" cols="40" maxlength="500" <?php if($contMedio->comentario==""): ?> placeholder="Escreva um comentário apenas se encontrar algum problema, caso contrário não escreva." <?php endif; ?>><?php if($contMedio->comentario!=""): ?><?php echo e($contMedio->comentario); ?><?php endif; ?></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <br>
<a href="/admin/planejamentos/<?php echo e($ano); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/planejamentos.blade.php ENDPATH**/ ?>