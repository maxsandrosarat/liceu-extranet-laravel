

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body bg-light">
            <a href="/prof/diario/<?php echo e($disciplina->id); ?>/<?php echo e($turma->id); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h3 class="card-title" style="text-align: center;">Diário de Turma</h3>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php $__currentLoopData = $diarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h5>Disciplina: <?php echo e($diario->disciplina->nome); ?></h5>
                        <h5>Turma: <?php echo e($diario->turma->serie); ?>º ANO <?php echo e($diario->turma->turma); ?></h5>
                        <?php
                        $diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');
                        $diasemana_numero = date('w', strtotime($diario->dia)); 
                        ?>
                        <h5>Dia: <?php echo e(date("d/m/Y", strtotime($diario->dia))); ?> (<?php echo e($diasemana[$diasemana_numero]); ?>)</h5>
                        <div class="row">
                            <div class="col" style="text-align: left">
                                <a type="button" <?php if($diario->conferido===0): ?> class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="bottom" title="Aguardando conferência dos lançamentos pela Coordenação" <?php else: ?> class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Conferência concluída pela Coordenação" <?php endif; ?>>
                                    <b><?php if($diario->conferido===0): ?><i class="material-icons md-18 red">highlight_off</i> NÃO CONFERIDO <?php else: ?> <i class="material-icons md-18 green">check_circle</i> CONFERIDO <?php endif; ?></b>
                                </a>
                            </div>
                            <div class="col" style="text-align: right">
                                <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDeleteDia<?php echo e($diario->id); ?>" data-toggle="tooltip" data-placement="left" title="Excluir"><i class="material-icons md-18">delete</i></button></td>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="exampleModalDeleteDia<?php echo e($diario->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Diário Nº <?php echo e($diario->id); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Tem certeza que deseja excluir esse diário?</h5>
                                            <p>Não será possivel reverter esta ação.</p>
                                            <form action="/prof/diario/apagar" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="ocorrencia" value="<?php echo e($diario->id); ?>" required>
                                                <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Excluir Diário">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <form id="form-diario" class="row g-3" method="POST" action="/prof/diario">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="diario" value="<?php echo e($diario->id); ?>">
                            <b>
                            <div class="col-auto form-floating">
                                <select class="form-select" id="tempo" name="tempo" required>
                                    <?php if($diario->tempo==""): ?>
                                    <option value="">Selecione o tempo</option>
                                    <option value="1">1º Tempo</option>
                                    <option value="2">2º Tempo</option>
                                    <option value="3">3º Tempo</option>
                                    <option value="4">4º Tempo</option>
                                    <option value="5">5º Tempo</option>
                                    <?php if($disciplina->ensino=="medio"): ?>
                                    <option value="6">6º Tempo</option>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <option value="<?php echo e($diario->tempo); ?>"><?php echo e($diario->tempo); ?>º Tempo</option>
                                    <?php if($diario->tempo==1): ?>
                                        <option value="2">2º Tempo</option>
                                        <option value="3">3º Tempo</option>
                                        <option value="4">4º Tempo</option>
                                        <option value="5">5º Tempo</option>
                                        <?php if($disciplina->ensino=="medio"): ?>
                                        <option value="6">6º Tempo</option>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if($diario->tempo==2): ?>
                                            <option value="1">1º Tempo</option>
                                            <option value="3">3º Tempo</option>
                                            <option value="4">4º Tempo</option>
                                            <option value="5">5º Tempo</option>
                                            <?php if($disciplina->ensino=="medio"): ?>
                                            <option value="6">6º Tempo</option>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if($diario->tempo==3): ?>
                                                <option value="1">1º Tempo</option>
                                                <option value="2">2º Tempo</option>
                                                <option value="4">4º Tempo</option>
                                                <option value="5">5º Tempo</option>
                                                <?php if($disciplina->ensino=="medio"): ?>
                                                <option value="6">6º Tempo</option>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if($diario->tempo==4): ?>
                                                    <option value="1">1º Tempo</option>
                                                    <option value="2">2º Tempo</option>
                                                    <option value="3">3º Tempo</option>
                                                    <option value="5">5º Tempo</option>
                                                    <?php if($disciplina->ensino=="medio"): ?>
                                                    <option value="6">6º Tempo</option>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if($diario->tempo==5): ?>
                                                        <option value="1">1º Tempo</option>
                                                        <option value="2">2º Tempo</option>
                                                        <option value="3">3º Tempo</option>
                                                        <option value="4">4º Tempo</option>
                                                        <?php if($disciplina->ensino=="medio"): ?>
                                                        <option value="6">6º Tempo</option>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if($diario->tempo==6): ?>
                                                            <option value="1">1º Tempo</option>
                                                            <option value="2">2º Tempo</option>
                                                            <option value="3">3º Tempo</option>
                                                            <option value="4">4º Tempo</option>
                                                            <option value="5">5º Tempo</option>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </select>
                                <label for="tempo">Tempo</label>
                            </div>
                                <input type="hidden" id="valorPrevio" value="<?php echo e($diario->segundo_tempo); ?>"/>
                                <div id="selects">
                                    <div id="div_select1">
                                        <div class="col-auto form-floating">
                                            <select class="form-select" id="select1" name="segundoTempo" required>
                                                <?php if($diario->segundo_tempo=="0"): ?>
                                                <option id="select1_nao" value="0">NÃO</option>
                                                <option id="select1_sim" value="1">SIM</option>
                                                <?php else: ?>
                                                    <?php if($diario->segundo_tempo=="1"): ?>
                                                    <option id="select1_sim" value="1">SIM</option>
                                                    <option id="select1_nao" value="0">NÃO</option>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </select>
                                            <label for="segundoTempo">Duplicar lançamento para outro tempo?</label>
                                        </div>
                                    </div>
                                    <div id="div_select2">
                                        <div class="col-auto form-floating">
                                            <select class="form-select" id="select2" name="outroTempo">
                                                <?php if($diario->outro_tempo==""): ?>
                                                <option value="">Selecione o tempo</option>
                                                <option value="1">1º Tempo</option>
                                                <option value="2">2º Tempo</option>
                                                <option value="3">3º Tempo</option>
                                                <option value="4">4º Tempo</option>
                                                <option value="5">5º Tempo</option>
                                                <?php if($disciplina->ensino=="medio"): ?>
                                                <option value="6">6º Tempo</option>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                <option value="<?php echo e($diario->outro_tempo); ?>"><?php echo e($diario->outro_tempo); ?>º Tempo</option>
                                                <?php if($diario->outro_tempo==1): ?>
                                                    <option value="2">2º Tempo</option>
                                                    <option value="3">3º Tempo</option>
                                                    <option value="4">4º Tempo</option>
                                                    <option value="5">5º Tempo</option>
                                                    <?php if($disciplina->ensino=="medio"): ?>
                                                    <option value="6">6º Tempo</option>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if($diario->outro_tempo==2): ?>
                                                        <option value="1">1º Tempo</option>
                                                        <option value="3">3º Tempo</option>
                                                        <option value="4">4º Tempo</option>
                                                        <option value="5">5º Tempo</option>
                                                        <?php if($disciplina->ensino=="medio"): ?>
                                                        <option value="6">6º Tempo</option>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if($diario->outro_tempo==3): ?>
                                                            <option value="1">1º Tempo</option>
                                                            <option value="2">2º Tempo</option>
                                                            <option value="4">4º Tempo</option>
                                                            <option value="5">5º Tempo</option>
                                                            <?php if($disciplina->ensino=="medio"): ?>
                                                            <option value="6">6º Tempo</option>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php if($diario->outro_tempo==4): ?>
                                                                <option value="1">1º Tempo</option>
                                                                <option value="2">2º Tempo</option>
                                                                <option value="3">3º Tempo</option>
                                                                <option value="5">5º Tempo</option>
                                                                <?php if($disciplina->ensino=="medio"): ?>
                                                                <option value="6">6º Tempo</option>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <?php if($diario->outro_tempo==5): ?>
                                                                    <option value="1">1º Tempo</option>
                                                                    <option value="2">2º Tempo</option>
                                                                    <option value="3">3º Tempo</option>
                                                                    <option value="4">4º Tempo</option>
                                                                    <?php if($disciplina->ensino=="medio"): ?>
                                                                    <option value="6">6º Tempo</option>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <?php if($diario->outro_tempo==6): ?>
                                                                        <option value="1">1º Tempo</option>
                                                                        <option value="2">2º Tempo</option>
                                                                        <option value="3">3º Tempo</option>
                                                                        <option value="4">4º Tempo</option>
                                                                        <option value="5">5º Tempo</option>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </select>
                                            <label for="outroTempo">Outro Tempo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="col-auto form-floating">
                                <input class="form-control" type="text" form="form-diario" name="tema" id="tema" <?php if($diario->tema!=""): ?> value="<?php echo e($diario->tema); ?>" <?php else: ?> placeholder="Tema da Aula" <?php endif; ?> required>
                                <label for="tema">Tema da Aula</label>
                            </div>
                            <div class="col-auto form-floating">
                                <textarea class="form-control" form="form-diario" name="conteudo" id="conteudo" rows="5" cols="40" maxlength="245" placeholder="Conteúdo" required><?php if($diario->conteudo!=""): ?><?php echo e($diario->conteudo); ?><?php endif; ?></textarea>
                                <label for="conteudo">Conteúdo</label>
                            </div>
                            <div class="col-auto form-floating">
                                <input class="form-control" type="text" form="form-diario" name="referencias" id="referencias" <?php if($diario->referencias!=""): ?> value="<?php echo e($diario->referencias); ?>" <?php else: ?> placeholder="Referências" <?php endif; ?> required>
                                <label for="referencias">Referências</label>
                            </div>
                            <div class="col-auto form-floating">
                                <select class="form-select" id="tipoTarefa" form="form-diario" name="tipoTarefa" required>
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
                            <div class="col-auto form-floating">
                                <textarea class="form-control" form="form-diario" name="tarefa" id="tarefa" rows="5" cols="40" maxlength="245" placeholder="Tarefa" required><?php if($diario->tarefa!=""): ?><?php echo e($diario->tarefa); ?><?php endif; ?></textarea>
                                <label for="tarefa">Tarefa</label>
                            </div>
                            <div class="col-auto form-floating">
                                <input class="form-control" type="date" form="form-diario" name="entregaTarefa" <?php if($diario->entrega_tarefa!=""): ?> value="<?php echo e(date("Y-m-d", strtotime($diario->entrega_tarefa))); ?>" <?php endif; ?> required>
                                <label for="data">Data da Entrega da Tarefa</label>
                            </div></b>
                            <div class="modal-footer">
                                <button type="submit" form="form-diario" class="btn btn-outline-primary">Salvar Diário</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <hr/>
                        <b><h3 class="card-title" style="text-align: center;">Ocorrências do Dia</h3></b>
                        <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Lançar Ocorrências">
                            <i class="material-icons blue md-60">add_circle</i>
                        </a>
                        <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Lançamento de Ocorrência</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5 style="color: red;"><u>Clique sobre o nome do aluno para ver a foto, e clique em qualquer área fora da foto para sair da visualização da foto.</u></h5>
                                    <div class="table-responsive-xl">
                                    <table class="table table-striped table-sm">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Marcar</th>
                                                <th style="text-align: center;">Aluno</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <form method="POST" action="/prof/ocorrencias">
                                                    <?php echo csrf_field(); ?>
                                                    <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><input type="checkbox" name="alunos[]" value="<?php echo e($aluno->id); ?>"></td>
                                                    <td><button type="button" class="badge bg-secondary" data-bs-toggle="modal" data-bs-target="#exampleModalFoto<?php echo e($aluno->id); ?>"><?php echo e($aluno->name); ?></button></td>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModalFoto<?php echo e($aluno->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-body" style="color: black; text-align: center;">
                                                                <?php if($aluno->foto!=""): ?> <img src="/storage/<?php echo e($aluno->foto); ?>" alt="foto_aluno" style="width: 100%"> <?php else: ?> <i class="material-icons md-60">no_photography</i> <?php endif; ?>
                                                                <hr/>
                                                                <h6 class="font-italic">
                                                                <?php echo e($aluno->name); ?> - <?php echo e($aluno->turma->serie); ?>º ANO <?php echo e($aluno->turma->turma); ?> (<?php if($aluno->turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($aluno->turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)
                                                                </h6>
                                                                <hr/>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                    </table>
                                    </div>
                                    <br/>
                                    <div class="col-auto form-floating">
                                        <select class="form-select" id="tipo" name="tipo" required style="width:300px;">
                                            <option value="">Selecione o tipo</option>
                                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->codigo); ?> - <?php echo e($tipo->descricao); ?> - <?php if($tipo->tipo=="despontuacao"): ?> Despontuar: <?php else: ?> Elogio: <?php endif; ?><?php echo e($tipo->pontuacao); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <label for="tipo">Tipo de Ocorrência</label>
                                    </div>
                                    <br/><br/>
                                    <input type="hidden" name="disciplina" value="<?php echo e($disciplina->id); ?>">
                                    <input type="hidden" name="data" value="<?php echo e($dia); ?>" required>
                                    <label for="observacao">Observação</label>
                                    <textarea class="form-control" name="observacao" id="observacao" rows="10" cols="40" maxlength="500" placeholder="Atenção!!! Caso marque vários alunos e faça uma observação neste momento, a mesma será para todos marcados. Caso deseje apenas para alunos especificos lance sem observação e edite o lançamento para inserir a observação."></textarea> 
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                        <?php if(count($ocorrencias)==0): ?>
                                <div class="alert alert-dark" role="alert">
                                    Sem ocorrências lançadas! Faça novo lançamento no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                                </div>
                        <?php else: ?>
                        <div class="table-responsive-xl">
                        <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                            <thead class="table-dark">
                                <tr>
                                    <th>Ocorrência</th>
                                    <th>Aluno</th>
                                    <th>Observação</th>
                                    <th colspan="2">Ações</th>
                                    <th>Aprovação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $ocorrencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocorrencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($ocorrencia->aluno->turma_id==$turma->id): ?>
                                <tr>
                                    <td><?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?></td>
                                    <td><?php echo e($ocorrencia->aluno->name); ?></td>
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
                                    <td <?php if($ocorrencia->aprovado===0 || $ocorrencia->aprovado===1): ?>colspan="2" <?php endif; ?>>
                                        <?php if($ocorrencia->aprovado==1): ?> 
                                        <?php else: ?>
                                            <?php if($ocorrencia->aprovado!==NULL): ?>
                                            <?php else: ?>
                                        <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo e($ocorrencia->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar">
                                            <i class="material-icons md-18">edit</i>
                                        </button>
                                        
                                        <div class="modal fade" id="exampleModal<?php echo e($ocorrencia->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <label for="tipo">Tipo</label>
                                                        <select class="custom-select" id="tipo" name="tipo" required style="width:300px;">
                                                            <option value="<?php echo e($ocorrencia->tipo_ocorrencia->id); ?>"><?php echo e($ocorrencia->tipo_ocorrencia->codigo); ?> - <?php echo e($ocorrencia->tipo_ocorrencia->descricao); ?> - <?php if($ocorrencia->tipo_ocorrencia->tipo=="despontuacao"): ?> Despontuar: <?php else: ?> Elogio: <?php endif; ?><?php echo e($ocorrencia->tipo_ocorrencia->pontuacao); ?></option>
                                                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($tipo->id==$ocorrencia->tipo_ocorrencia_id): ?>
                                                            <?php else: ?>
                                                            <option value="<?php echo e($tipo->id); ?>"><?php echo e($tipo->codigo); ?> - <?php echo e($tipo->descricao); ?> - <?php if($tipo->tipo=="despontuacao"): ?> Despontuar: <?php else: ?> Elogio: <?php endif; ?><?php echo e($tipo->pontuacao); ?></option>
                                                            <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <input type="hidden" name="data" value="<?php echo e($dia); ?>" required>
                                                        <br/>
                                                        <label for="observacao">Observação</label>
                                                        <textarea class="form-control" name="observacao" id="observacao" rows="10" cols="40" maxlength="500"><?php echo e($ocorrencia->observacao); ?></textarea> 
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-sm">Editar</button>
                                                </div>
                                            </form>
                                            </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
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
                                    <td max-width="100px">
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
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        </div>
                        <?php endif; ?>

        </div>
    </div>
    <script type="text/javascript">
        window.addEventListener("load", start);

        let teste = document.querySelector("#valorPrevio").value;
        let sim = document.querySelector("#select1_sim");
        let nao = document.querySelector("#select1_nao");

        function start() {
        definirSegundoTempo();
        render();
        }

        function definirSegundoTempo() {
        teste === "1" ? (sim.selected = true) : (nao.selected = true);
        addEventListener("change", render);
        render();
        }

        function render() {
        let segundoTempo = document.querySelector("#div_select2");
        nao.selected === true
            ? (segundoTempo.style.display = "none")
            : (segundoTempo.style.display = "block");
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"diario"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/profs/diario_prof.blade.php ENDPATH**/ ?>