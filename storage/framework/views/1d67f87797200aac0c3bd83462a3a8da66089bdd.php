<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
    <a href="/outro/simulados/<?php echo e($ano); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/>
    <?php if($ensino=="fund" || $ensino=="todos"): ?>
            <h5 class="card-title">Painel de Questões de Prova - Ensino Fundamental - <?php echo e($simulado->descricao); ?> - <?php echo e($simulado->bimestre); ?>º Bimestre - Ano: <?php echo e($simulado->ano); ?></h5>
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
                                        <?php if($fundPertence===0): ?> <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td>
                                        <?php else: ?>
                                            <?php if($contFund->arquivo==''): ?>
                                                <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge badge-warning" disabled><i class="material-icons md-18">cloud_upload</i></button> 
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
                                                <a type="button" class="badge badge-success" href="/outro/simulados/download/<?php echo e($contFund->id); ?>"><i class="material-icons md-18">cloud_download</i></a>
                                                
                                            <?php endif; ?>
                                            </td>
                                                    <!-- Modal Conferir -->
                                                        <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contFund->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do <?php echo e($simulado->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->serie); ?>º ANO</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="/outro/simulados/conferir" method="POST" enctype="multipart/form-data">
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
            <h5 class="card-title">Painel de Questões de Provas - Ensino Médio - <?php echo e($simulado->descricao); ?> - <?php echo e($simulado->bimestre); ?>º Bimestre - Ano: <?php echo e($simulado->ano); ?></h5>
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
                                    <?php if($medioPertence===0): ?> <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td> 
                                    <?php else: ?>
                                        <?php if($contMedio->arquivo==''): ?>
                                        <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge badge-warning" disabled><i class="material-icons md-18">cloud_upload</i></button> 
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
                                        <a type="button" class="badge badge-success" href="/outro/simulados/download/<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">cloud_download</i></a>
                
                                        <?php endif; ?>
                                    </td>
                                    
                                            <!-- Modal Conferir -->
                                                <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Conferir Questões do <?php echo e($simulado->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->serie); ?>º ANO</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="/outro/simulados/conferir" method="POST" enctype="multipart/form-data">
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

<?php echo $__env->make('layouts.app', ["current"=>"simulados"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/simulados.blade.php ENDPATH**/ ?>