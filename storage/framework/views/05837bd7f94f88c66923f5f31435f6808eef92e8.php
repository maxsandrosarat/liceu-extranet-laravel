

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body bg-light">
        <a href="/outro/diario" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h3 class="card-title" style="text-align: center;">Diário de Turma - 
            <?php
            $diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
            $diasemana_numero = date('w', strtotime($dia)); 
            ?>
            Dia: <?php echo e(date("d/m/Y", strtotime($dia))); ?> (<?php echo e($diasemana[$diasemana_numero]); ?>) - <?php echo e($turma->serie); ?>º<?php echo e($turma->turma); ?><?php echo e($turma->turno); ?>

        </h3>
        <?php if(session('mensagem')): ?>
            <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                <?php echo e(session('mensagem')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <?php $__currentLoopData = $diarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="flush-heading<?php echo e($diario->id); ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo e($diario->id); ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo e($diario->id); ?>">
                                <b><?php echo e($diario->tempo); ?>º Tempo <?php if($diario->segundo_tempo==1): ?> & <?php echo e($diario->outro_tempo); ?>º Tempo <?php endif; ?>- <?php echo e($diario->disciplina->nome); ?> - Prof(a). <?php echo e($diario->prof->name); ?></b>
                            </button>
                          </h2>
                          <div id="flush-collapse<?php echo e($diario->id); ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo e($diario->id); ?>" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <b><p>
                                    Conteúdo: <?php echo e($diario->tema); ?><br/>
                                    <?php echo nl2br($diario->conteudo); ?><br/>
                                    Referências: <?php echo e($diario->referencias); ?><br/>
                                    Tarefa: <?php echo e($diario->tarefa); ?><br/>
                                    Forma de Entrega da Tarefa:<?php if($diario->tipo_tarefa=="AULA"): ?> VISTADA EM AULA <?php else: ?> ENVIADA NO SCULES <?php endif; ?><br/>
                                    Data da Entrega da Tarefa: <?php echo e(date("d/m/Y", strtotime($diario->entrega_tarefa))); ?><br/>
                                    Prof(a). <?php echo e($diario->prof->name); ?>

                                    <br/><br/>
                                    <a type="button" <?php if($diario->conferido===0): ?> href="/outro/diario/conferido/<?php echo e($diario->id); ?>" class="badge bg-warning" <?php else: ?> class="badge bg-success" <?php endif; ?>>
                                        <b><?php if($diario->conferido===0): ?><i class="material-icons md-18 red">highlight_off</i> NÃO CONFERIDO <?php else: ?> <i class="material-icons md-18 green">check_circle</i> CONFERIDO <?php endif; ?></b>
                                    </a>
                                </p></b>
                                <!-- Modal -->
                                    <div class="modal fade" id="exampleModal<?php echo e($diario->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Editar Diário - <?php echo e($diario->tempo); ?>º Tempo <?php if($diario->segundo_tempo==1): ?> & <?php echo e($diario->outro_tempo); ?>º Tempo <?php endif; ?>- <?php echo e($diario->disciplina->nome); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row g-3" method="POST" action="/outro/diario/editar/<?php echo e($diario->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <b>
                                                        <div class="col-12 form-floating">
                                                            <input class="form-control" type="text" name="tema" id="tema" <?php if($diario->tema!=""): ?> value="<?php echo e($diario->tema); ?>" <?php else: ?> placeholder="Exemplo: Pré-História" <?php endif; ?> required>
                                                            <label for="tema">Tema da Aula</label>
                                                        </div>  
                                                        <div class="col-12 form-floating">
                                                            <textarea class="form-control" name="conteudo" id="conteudo" rows="5" cols="40" maxlength="245" placeholder="Exemplo: Características, Períodos e Curiosidades" required><?php if($diario->conteudo!=""): ?><?php echo e($diario->conteudo); ?><?php endif; ?></textarea>
                                                            <label for="conteudo">Conteúdo</label>
                                                        </div>  
                                                        <div class="col-12 form-floating">
                                                            <input class="form-control" type="text" name="referencias" id="referencias" <?php if($diario->referencias!=""): ?> value="<?php echo e($diario->referencias); ?>" <?php else: ?> placeholder="Exemplo: Livro 1 Cap. 3 Pág. 50" <?php endif; ?> required>
                                                            <label for="referencias">Referências</label>
                                                        </div>  
                                                        <div class="col-12 form-floating">
                                                            <textarea class="form-control" name="tarefa" id="tarefa" rows="5" cols="40" maxlength="245" placeholder="Exemplo: Exercícios 1 à 10 (Módulo 1)" required><?php if($diario->tarefa!=""): ?><?php echo e($diario->tarefa); ?><?php endif; ?></textarea>
                                                            <label for="tarefa">Tarefa</label>
                                                        </div>  
                                                        <div class="col-12 form-floating">
                                                            <select class="form-select" id="tipoTarefa" name="tipoTarefa" required>
                                                                <?php if($diario->tipo_tarefa==""): ?>
                                                                <option value="">Selecione tipo de tarefa</option>
                                                                <option value="AULA"> VISTADA EM AULA </option>
                                                                <option value="SCULES"> ENVIADA NO SCULES </option>
                                                                <?php else: ?>
                                                                    <option value="<?php echo e($diario->tipo_tarefa); ?>"><?php if($diario->tipo_tarefa=="AULA"): ?> VISTADA EM AULA <?php else: ?> ENVIADA NO SCULES <?php endif; ?></option>
                                                                    <?php if($diario->tipo_tarefa=="AULA"): ?>
                                                                    <option value="SCULES"> ENVIADA NO SCULES </option>
                                                                    <?php else: ?>
                                                                    <option value="AULA"> VISTADA EM AULA </option>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                            <label for="tempo">Tipo de Tarefa</label>
                                                        </div>  
                                                        <div class="col-12 form-floating">
                                                            <input class="form-control" type="date" name="entregaTarefa" <?php if($diario->entrega_tarefa!=""): ?> value="<?php echo e(date("Y-m-d", strtotime($diario->entrega_tarefa))); ?>" <?php endif; ?> required>
                                                            <label for="data">Data da Entrega da Tarefa</label>
                                                        </div> 
                                                    </b>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col" style="text-align: right">
        <button type="button" class="badge bg-info" data-bs-toggle="modal" data-bs-target="#exampleModalGeral">Conteúdo Geral Para Copiar</button>
        </div>
                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-lg" id="exampleModalGeral" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Diário: <?php echo e($turma->serie); ?>º<?php echo e($turma->turma); ?><?php echo e($turma->turno); ?> - <?php echo e(date("d/m/Y", strtotime($dia))); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p id="texto">
                                                    Conteúdo Ministrado em Aula - <?php echo e($turma->serie); ?>º<?php echo e($turma->turma); ?><?php echo e($turma->turno); ?> - <?php echo e(date("d/m/Y", strtotime($dia))); ?><br/><br/>
                                                    <?php $__currentLoopData = $diarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    Disciplina: <?php echo e($diario->disciplina->nome); ?><br/>
                                                    Conteúdo: <?php echo e($diario->tema); ?><br/>
                                                    <?php echo nl2br($diario->conteudo); ?><br/>
                                                    Referências: <?php echo e($diario->referencias); ?><br/>
                                                    Tarefa: <?php echo e($diario->tarefa); ?><br/>
                                                    Forma de Entrega da Tarefa:<?php if($diario->tipo_tarefa=="AULA"): ?> VISTADA EM AULA <?php else: ?> ENVIADA NO SCULES <?php endif; ?><br/>
                                                    Data da Entrega da Tarefa: <?php echo e(date("d/m/Y", strtotime($diario->entrega_tarefa))); ?><br/>
                                                    Prof(a). <?php echo e($diario->prof->name); ?><br/><br/>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        <hr/>
                    <b><h3 class="card-title" style="text-align: center;">Ocorrências do Dia</h3></b>
                    <?php if(count($ocorrencias)==0): ?>
                        <div class="alert alert-dark" role="alert">
                            Sem ocorrências lançadas!
                        </div>
                    <?php else: ?>
                    <div class="table-responsive-xl">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Ocorrência</th>
                                <th>Aluno</th>
                                <th>Disciplina</th>
                                <th>Observação</th>
                                <th>Ações</th>
                                <th>Aprovação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $ocorrencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocorrencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?></td>
                                <td><?php echo e($ocorrencia->aluno->name); ?></td>
                                <td><?php echo e($ocorrencia->disciplina->nome); ?></td>
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
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($ocorrencia->id); ?>" data-toggle="tooltip" data-placement="left" title="Excluir"><i class="material-icons md-18">delete</i></button></td>
                                    <!-- Modal -->
                                    <div class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ocorrência: <?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?> - <?php echo e($ocorrencia->aluno->name); ?> - <?php echo e($ocorrencia->disciplina->nome); ?> - <?php echo e(date("d/m/Y", strtotime($ocorrencia->data))); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Tem certeza que deseja excluir essa ocorrência?</h5>
                                                    <p>Não será possivel reverter esta ação.</p>
                                                    <a href="/outro/ocorrencias/apagar/<?php echo e($ocorrencia->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
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
                                        <?php endif; ?>
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
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/outros/diario_outro.blade.php ENDPATH**/ ?>