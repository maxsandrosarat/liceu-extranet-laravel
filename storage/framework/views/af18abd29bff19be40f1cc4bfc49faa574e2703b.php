

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
    <a href="/prof/provas/<?php echo e($ano); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    <?php if($ensino=="fund" || $ensino=="todos"): ?>
            <h5 class="card-title">Painel de Questões de Prova - Ensino Fundamental - <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre - Ano: <?php echo e($prova->ano); ?></h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="3" style="white-space: nowrap; text-align: center; vertical-align: middle;">Disciplinas</th>
                        <th colspan="<?php echo e(count($fundTurmas)); ?>">Turmas</th>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $fundSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundSerie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $qtdTurmas = 0;
                            foreach($fundTurmas as $fundTurma){
                                if($fundTurma->serie==$fundSerie->serie){
                                    $qtdTurmas++;
                                }
                            }
                        ?>
                        <th colspan="<?php echo e($qtdTurmas); ?>"><?php echo e($fundSerie->serie); ?>º</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $fundTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($fundTurma->serie); ?>º<?php echo e($fundTurma->turma); ?><?php echo e($fundTurma->turno); ?></th>
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

                            <?php $__currentLoopData = $fundTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $fundPertence = 0;
                                foreach($fundDisc->turmas as $turmaFund){
                                    if($turmaFund->serie==$fundTurma->serie && $turmaFund->turma==$fundTurma->turma){
                                        $fundPertence = 1;
                                    }
                                }
                            ?>
                            </td>
                            <?php $__currentLoopData = $contFunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contFund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($contFund->disciplina->nome == $fundDisc->nome && $contFund->turma->serie==$fundTurma->serie && $contFund->turma->turma==$fundTurma->turma): ?>
                                        <?php if($fundPertence===0): ?> <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td>
                                        <?php else: ?>
                                        <?php if($contFund->arquivo==''): ?>
                                        <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contFund->id); ?>"><i class="material-icons md-18">cloud_upload</i></button> 
                                    <?php else: ?>
                                        <?php if($contFund->comentario!=""): ?>
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        <?php else: ?>
                                            <?php if($contFund->conferido==1): ?> 
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Conferido e Liberado">check_circle</i></a><br/>
                                            <?php else: ?>
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Conferido">highlight_off</i></a><br/>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <a type="button" class="badge bg-success" href="/prof/provas/download/<?php echo e($contFund->id); ?>"><i class="material-icons md-18">cloud_download</i></a> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contFund->id); ?>"><i class="material-icons md-18">edit</i></button> <a type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($contFund->id); ?>"><i class="material-icons md-18 white">delete</i></a>
                                        <!-- Modal Deletar -->
                                        <div style="text-align: center;" class="modal fade" id="exampleModalDelete<?php echo e($contFund->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Excluir Questões do(a) <?php echo e($prova->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->turma->serie); ?>º<?php echo e($contFund->turma->turma); ?><?php echo e($contFund->turma->turno); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Tem certeza que deseja excluir esse arquivo?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <a href="/prof/provas/apagar/<?php echo e($contFund->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Anexar Questões do(a) Prova <?php echo e($prova->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->turma->serie); ?>º<?php echo e($contFund->turma->turma); ?><?php echo e($contFund->turma->turno); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="/prof/provas/anexar/<?php echo e($contFund->id); ?>" enctype="multipart/form-data">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="col-12 input-group mb-3">
                                                                <label for="arquivo" class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Adicionar Arquivo"><i class="material-icons blue md-24">note_add</i></label>
                                                                <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                                                            </div>
                                                            <b style="font-size: 80%;">Aceito apenas Arquivos Word e PDF (".doc", ".docx" e ".pdf")</b>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-outline-primary">Enviar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <!-- Modal Conferir -->
                                                <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contFund->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do <?php echo e($prova->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->turma->serie); ?>º<?php echo e($contFund->turma->turma); ?><?php echo e($contFund->turma->turno); ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/prof/provas/conferir" method="POST" enctype="multipart/form-data">
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
        <?php endif; ?>
        <?php if($ensino=="medio" || $ensino=="todos"): ?>
            <h5 class="card-title">Painel de Questões de Provas - Ensino Médio - <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre - Ano: <?php echo e($prova->ano); ?></h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-bordered table-hover" style="text-align: center;">
                <thead class="table-dark">
                    <tr>
                        <th rowspan="3" style="white-space: nowrap; text-align: center; vertical-align: middle;">Disciplinas</th>
                        <th colspan="<?php echo e(count($medioTurmas)); ?>">Turmas</th>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $medioSeries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medioSerie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $qtdTurmas = 0;
                            foreach($medioTurmas as $medioTurma){
                                if($medioTurma->serie==$medioSerie->serie){
                                    $qtdTurmas++;
                                }
                            }
                        ?>
                        <th colspan="<?php echo e($qtdTurmas); ?>"><?php echo e($medioSerie->serie); ?>º</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $medioTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medioTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($medioTurma->serie); ?>º<?php echo e($medioTurma->turma); ?><?php echo e($medioTurma->turno); ?></th>
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

                            <?php $__currentLoopData = $medioTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medioTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $medioPertence = 0;
                                foreach($medioDisc->turmas as $turmaMedio){
                                    if($turmaMedio->serie==$medioTurma->serie && $turmaMedio->turma==$medioTurma->turma){
                                        $medioPertence = 1;
                                    }
                                }
                            ?>
                            </td>
                            <?php $__currentLoopData = $contMedios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contMedio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($contMedio->disciplina->nome == $medioDisc->nome && $contMedio->turma->serie==$medioTurma->serie && $contMedio->turma->turma==$medioTurma->turma): ?>
                                    <?php if($medioPertence===0): ?> <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td> 
                                    <?php else: ?>
                                    <?php if($contMedio->arquivo==''): ?>
                                    <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">cloud_upload</i></button> 
                                <?php else: ?>
                                        <?php if($contMedio->comentario!=""): ?>
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        <?php else: ?>
                                            <?php if($contMedio->conferido==1): ?> 
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Conferido e Liberado">check_circle</i></a><br/>
                                            <?php else: ?>
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Conferido">highlight_off</i></a><br/>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <a type="button" class="badge bg-success" href="/prof/provas/download/<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">cloud_download</i></a> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">edit</i></button> <a type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($contMedio->id); ?>"><i class="material-icons md-18 white">delete</i></a>
                                    <!-- Modal Deletar -->
                                        <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Excluir Questões do <?php echo e($prova->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->turma->serie); ?>º<?php echo e($contMedio->turma->turma); ?><?php echo e($contMedio->turma->turno); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Tem certeza que deseja excluir esse arquivo?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                        <a href="/prof/provas/apagar/<?php echo e($contMedio->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
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
                                                <h5 class="modal-title" id="exampleModalLabel">Anexar Questões do <?php echo e($prova->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->turma->serie); ?>º<?php echo e($contMedio->turma->turma); ?><?php echo e($contMedio->turma->turno); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="/prof/provas/anexar/<?php echo e($contMedio->id); ?>" enctype="multipart/form-data">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="col-12 input-group mb-3">
                                                            <label for="arquivo" class="input-group-text" data-toggle="tooltip" data-placement="bottom" title="Adicionar Arquivo"><i class="material-icons blue md-24">note_add</i></label>
                                                            <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                                                        </div>
                                                        <b style="font-size: 80%;">Aceito apenas Arquivos Word e PDF (".doc", ".docx" e ".pdf")</b>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-outline-primary">Enviar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <!-- Modal Conferir -->
                                            <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do <?php echo e($prova->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->turma->serie); ?>º<?php echo e($contMedio->turma->turma); ?><?php echo e($contMedio->turma->turno); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/prof/provas/conferir" method="POST" enctype="multipart/form-data">
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
        <?php endif; ?>
    </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"provas"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/provas.blade.php ENDPATH**/ ?>