

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
    <a href="/admin/provas/<?php echo e($ano); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    <?php if($ensino=="fund" || $ensino=="todos"): ?>
            <h5 class="card-title">Painel de Conteúdos de Prova - Ensino Fundamental - <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre - Ano: <?php echo e($prova->ano); ?></h5>
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
                                            <?php if($contFund->descricao==''): ?>
                                                <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contFund->id); ?>"><i class="material-icons md-18">cloud_upload</i></button>
                                            <?php else: ?>
                                                <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contFund->id); ?>"><i class="material-icons md-50 green" data-toggle="tooltip" data-placement="left" title="Enviado">check_circle</i></a><br/>
                                            <?php endif; ?>
                                            </td>
                                            <!-- Modal Anexar -->
                                                    <div style="text-align: center;" class="modal fade" id="exampleModalAnexar<?php echo e($contFund->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Conteúdo do(a) Prova <?php echo e($prova->descricao); ?> - <?php echo e($contFund->disciplina->nome); ?> - <?php echo e($contFund->turma->serie); ?>º<?php echo e($contFund->turma->turma); ?><?php echo e($contFund->turma->turno); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5>Conteúdo</h5>
                                                                <form method="POST" action="/admin/conteudosProvas/anexar/<?php echo e($contFund->id); ?>" enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <div class="col-12 form-floating">
                                                                        <textarea class="form-control" name="descricao" id="descricao" rows="50" cols="40" placeholder="Escreva aqui ou copei e cole do arquivo, a descrição completa dos conteúdos que serão cobrados." <?php if($contFund->descricao==''): ?> required <?php endif; ?>><?php if($contFund->descricao!=''): ?><?php echo e($contFund->descricao); ?><?php endif; ?></textarea>
                                                                        <label for="descricao">Descrição</label>
                                                                    </div>
                                                                    <div class="col-3 form-floating">
                                                                        <input class="form-control" type="date" id="dataAplicacao" name="dataAplicacao" <?php if($contFund->data_aplicacao==null): ?> placeholder="Data Aplicação" required <?php else: ?> value="<?php echo e(date("Y-m-d", strtotime($contFund->data_aplicacao))); ?>" <?php endif; ?>>
                                                                        <label for="dataAplicacao">Data Aplicação</label>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-outline-primary">Salvar</button>
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
                    <tr style="background-color: green;">
                        <td style="color: white;"><b>Gerar Arquivo (PDF)</b></td>
                        <?php $__currentLoopData = $fundTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPdf<?php echo e($fundTurma->id); ?>">
                                <?php echo e($fundTurma->serie); ?>º<?php echo e($fundTurma->turma); ?><?php echo e($fundTurma->turno); ?>

                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalPdf<?php echo e($fundTurma->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Gerar Arquivo (PDF) - <?php echo e($fundTurma->serie); ?>º <?php echo e($fundTurma->turma); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-conteudos<?php echo e($fundTurma->id); ?>" method="POST" action="/admin/conteudosProvas/pdf/<?php echo e($prova->id); ?>/<?php echo e($fundTurma->id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <h5>Selecione as disciplinas:</h5>
                                        <ul class="list-group">
                                        <?php $__currentLoopData = $fundTurma->disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundDisc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($fundDisc->ativo==1): ?>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" name="disciplinas[]" value="<?php echo e($fundDisc->id); ?>" checked><?php echo e($fundDisc->nome); ?>

                                            </li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="form-conteudos<?php echo e($fundTurma->id); ?>" formtarget="_blank" class="btn btn-success">Gerar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </tbody>
            </table>
            </div>
        <?php endif; ?>
        <?php if($ensino=="medio" || $ensino=="todos"): ?>
            <h5 class="card-title">Painel de Conteúdos de Provas - Ensino Médio - <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre - Ano: <?php echo e($prova->ano); ?></h5>
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
                                        <?php if($contMedio->descricao==''): ?>
                                        <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contMedio->id); ?>"><i class="material-icons md-18">cloud_upload</i></button> 
                                    <?php else: ?>
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($contMedio->id); ?>"><i class="material-icons md-50 green" data-toggle="tooltip" data-placement="left" title="Enviado">check_circle</i></a><br/>
                                    <?php endif; ?>
                                    </td>
                                    <!-- Modal Anexar -->
                                            <div style="text-align: center;" class="modal fade" id="exampleModalAnexar<?php echo e($contMedio->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Conteúdo do(a) <?php echo e($prova->descricao); ?> - <?php echo e($contMedio->disciplina->nome); ?> - <?php echo e($contMedio->turma->serie); ?>º<?php echo e($contMedio->turma->turma); ?><?php echo e($contMedio->turma->turno); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Conteúdo</h5>
                                                        <form method="POST" action="/admin/conteudosProvas/anexar/<?php echo e($contMedio->id); ?>" enctype="multipart/form-data">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="col-12 form-floating">
                                                                <textarea class="form-control" name="descricao" id="descricao" rows="50" cols="40" placeholder="Escreva aqui ou copei e cole do arquivo, a descrição completa dos conteúdos que serão cobrados." <?php if($contMedio->descricao==''): ?> required <?php endif; ?>><?php if($contMedio->descricao!=''): ?><?php echo e($contMedio->descricao); ?><?php endif; ?></textarea>
                                                                <label for="descricao">Descrição</label>
                                                            </div>
                                                            <div class="col-3 form-floating">
                                                                <input class="form-control" type="date" id="dataAplicacao" name="dataAplicacao" <?php if($contMedio->data_aplicacao==null): ?> placeholder="Data Aplicação" required <?php else: ?> value="<?php echo e(date("Y-m-d", strtotime($contMedio->data_aplicacao))); ?>" <?php endif; ?>>
                                                                <label for="dataAplicacao">Data Aplicação</label>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                            </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr style="background-color: green;">
                        <td style="color: white;"><b>Gerar Arquivo (PDF)</b></td>
                        <?php $__currentLoopData = $medioTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medioTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPdf<?php echo e($medioTurma->id); ?>">
                                <?php echo e($medioTurma->serie); ?>º<?php echo e($medioTurma->turma); ?><?php echo e($medioTurma->turno); ?>

                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="modalPdf<?php echo e($medioTurma->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Gerar Arquivo (PDF) - <?php echo e($medioTurma->serie); ?>º <?php echo e($medioTurma->turma); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form-conteudos<?php echo e($medioTurma->id); ?>" method="POST" action="/admin/conteudosProvas/pdf/<?php echo e($prova->id); ?>/<?php echo e($medioTurma->id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <h5>Selecione as disciplinas:</h5>
                                        <ul class="list-group">
                                        <?php $__currentLoopData = $medioTurma->disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medioDisc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($medioDisc->ativo==1): ?>
                                            <li class="list-group-item">
                                                <input class="form-check-input me-1" type="checkbox" name="disciplinas[]" value="<?php echo e($medioDisc->id); ?>" checked><?php echo e($medioDisc->nome); ?>

                                            </li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" form="form-conteudos<?php echo e($medioTurma->id); ?>" formtarget="_blank" class="btn btn-success">Gerar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </tbody>
            </table>
            </div>
        <?php endif; ?>
    </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/conteudos_provas.blade.php ENDPATH**/ ?>