

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
    <a href="/outro/atividadeComplementar/<?php echo e($ano); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    <?php if($ensino=="fund" || $ensino=="todos"): ?>
            <h5 class="card-title">Painel de Atividades Complementares - Ensino Fundamental - <?php echo e($atividade->descricao); ?> - <?php echo e($atividade->bimestre); ?>º Bimestre - Ano: <?php echo e($atividade->ano); ?></h5>
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
                        <th colspan="<?php echo e($qtdTurmas); ?>"><?php echo e($fundSerie->serie); ?>º ANO</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $fundTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($fundTurma->serie); ?>º <?php echo e($fundTurma->turma); ?></th>
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
                                        <td style="color:red; text-align: center;"> Pendente <br/>
                                    <?php else: ?>
                                        <?php if($contFund->comentario!=""): ?>
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        <?php else: ?>
                                            <?php if($contFund->impresso==1): ?> 
                                            <td style="text-align: center;"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Impresso e Liberado">check_circle</i><br/>
                                            <?php else: ?>
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contFund->id); ?>"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Impresso">highlight_off</i></a><br/>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <p><b><?php echo e(date("d/m/Y", strtotime($contFund->data_utilizacao))); ?></b></p>
                                        <a type="button" class="badge bg-success" href="/outro/atividadeComplementar/download/<?php echo e($contFund->id); ?>"><i class="material-icons md-18">cloud_download</i></a>
                                    <?php endif; ?>
                                    </td>
                                            <!-- Modal Conferir -->
                                                <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contFund->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Marcar como Impresso Atividade Complementar <?php echo e($atividade->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->turma->serie); ?>º ANO <?php echo e($contFund->turma->turma); ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5>Tem certeza que deseja marcar como impresso essa atividade?</h5>
                                                                <p>Não será possivel reverter esta ação.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <a href="/outro/atividadeComplementar/impresso/<?php echo e($contFund->id); ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="right" title="Inativar">Marcar como Impresso</a>
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
            <h5 class="card-title">Painel de Atividades Complementares - Ensino Médio - <?php echo e($atividade->descricao); ?> - <?php echo e($atividade->bimestre); ?>º Bimestre - Ano: <?php echo e($atividade->ano); ?></h5>
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
                        <th colspan="<?php echo e($qtdTurmas); ?>"><?php echo e($medioSerie->serie); ?>º ANO</th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <tr>
                        <?php $__currentLoopData = $medioTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medioTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e($medioTurma->serie); ?>º <?php echo e($medioTurma->turma); ?></th>
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
                                    <td style="color:red; text-align: center;"> Pendente <br/> 
                                <?php else: ?>
                                        <?php if($contMedio->comentario!=""): ?>
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 yellow" data-toggle="tooltip" data-placement="left" title="Problemas Encontrados">report_problem</i></a><br/>
                                        <?php else: ?>
                                            <?php if($contMedio->impresso==1): ?> 
                                            <td style="text-align: center;"><i class="material-icons md-48 green" data-toggle="tooltip" data-placement="left" title="Impresso e Liberado">check_circle</i><br/>
                                            <?php else: ?>
                                            <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalConf<?php echo e($contMedio->id); ?>"><i class="material-icons md-48 red" data-toggle="tooltip" data-placement="left" title="Não Impresso">highlight_off</i></a><br/>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <p><b><?php echo e(date("d/m/Y", strtotime($contMedio->data_utilizacao))); ?></b></p>
                                    <a type="button" class="badge bg-success" href="/outro/atividadeComplementar/download/<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">cloud_download</i></a>
                                    <?php endif; ?>
                                </td>
                                        <!-- Modal Conferir -->
                                            <div style="text-align: center;" class="modal fade bd-example-modal-lg" id="exampleModalConf<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Marcar como Impresso Atividade Complementar <?php echo e($atividade->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->turma->serie); ?>º ANO <?php echo e($contMedio->turma->turma); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>Tem certeza que deseja marcar como impresso essa atividade?</h5>
                                                            <p>Não será possivel reverter esta ação.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <a href="/outro/atividadeComplementar/impresso/<?php echo e($contMedio->id); ?>" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="right" title="Inativar">Marcar como Impresso</a>
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
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/atividades_complementares_outro.blade.php ENDPATH**/ ?>