

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body bg-light">
            <h3 class="card-title" style="text-align: center;">Diário de Turma - 
                <?php
                $diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
                $diasemana_numero = date('w', strtotime($dia)); 
                ?>
                Dia: <?php echo e(date("d/m/Y", strtotime($dia))); ?> (<?php echo e($diasemana[$diasemana_numero]); ?>) - <?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?>

            </h3>
            <?php if(session('mensagem')): ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <p><?php echo e(session('mensagem')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(count($diarios)==0): ?>
                <div class="alert alert-dark" role="alert">
                    Sem lançamento até o momento!
                </div>
            <?php else: ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="accordion" id="accordionExample">
                            <?php $__currentLoopData = $diarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="card">
                              <div class="card-header" id="heading<?php echo e($diario->id); ?>">
                                <h5 class="mb-0">
                                  <a type="button" data-toggle="collapse" data-target="#collapse<?php echo e($diario->id); ?>" aria-expanded="true" aria-controls="collapse<?php echo e($diario->id); ?>">
                                    <?php echo e($diario->tempo); ?>º Tempo <?php if($diario->segundo_tempo==1): ?> & <?php echo e($diario->outro_tempo); ?>º Tempo <?php endif; ?>- <?php echo e($diario->disciplina->nome); ?> - Prof(a). <?php echo e($diario->prof->name); ?>

                                  </a>
                                </h5>
                              </div>
                              <div id="collapse<?php echo e($diario->id); ?>" class="collapse" aria-labelledby="heading<?php echo e($diario->id); ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <b><p>
                                        Conteúdo: <?php echo e($diario->tema); ?><br/>
                                        <?php echo e($diario->conteudo); ?><br/>
                                        Referências: <?php echo e($diario->referencias); ?><br/>
                                        Tarefa: <?php echo e($diario->tarefa); ?><br/>
                                        Forma de Entrega da Tarefa:<?php if($diario->tipo_tarefa=="AULA"): ?> VISTADA EM AULA <?php else: ?> ENVIADA NO SCULES <?php endif; ?><br/>
                                        Data da Entrega da Tarefa: <?php echo e(date("d/m/Y", strtotime($diario->entrega_tarefa))); ?><br/>
                                        Prof(a). <?php echo e($diario->prof->name); ?>

                                    </p></b>
                                </div>
                              </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <br/><br/>
                        <b><h3 class="card-title" style="text-align: center;">Ocorrências do Dia</h3></b>
                        <?php if(count($ocorrencias)==0): ?>
                            <div class="alert alert-dark" role="alert">
                                Sem ocorrências lançadas!
                            </div>
                        <?php else: ?>
                        <div class="table-responsive-xl">
                        <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ocorrência</th>
                                    <th>Aluno</th>
                                    <th>Disciplina</th>
                                    <th>Observação</th>
                                    <th>Aprovação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $ocorrencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocorrencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($ocorrencia->aluno->turma_id==$turma->id): ?>
                                <tr>
                                    <td><?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?></td>
                                    <td><?php echo e($ocorrencia->aluno->name); ?></td>
                                    <td><?php echo e($ocorrencia->disciplina->nome); ?></td>
                                    <td>
                                        <?php if($ocorrencia->observacao==""): ?>
                                        <h6 style="color: red;">Sem observação</h6>
                                        <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#exampleModalOb<?php echo e($ocorrencia->id); ?>">
                                            Ver Observação
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
                                            <b><p style="color: green; font-size: 50%;"><i class="material-icons green">check_circle</i> APROVADO</p></b>
                                        <?php else: ?>
                                            <?php if($ocorrencia->aprovado!==NULL): ?>
                                                <b><p style="color: red; font-size: 50%;"><i class="material-icons green">highlight_off</i>REPROVADO</p></b>
                                            <?php else: ?>
                                                <p><i class="material-icons">update</i> Aguardando Análise</p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        </div>
                        <?php endif; ?>


        </div>
    </div>
    <br>
    <a href="/outro/diario" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"diario"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/diario_outro.blade.php ENDPATH**/ ?>