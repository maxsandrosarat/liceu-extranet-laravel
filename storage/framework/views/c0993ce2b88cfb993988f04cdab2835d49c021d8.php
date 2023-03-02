

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
        <div class="row">
            <div class="col-9" style="text-align: left">
                <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            </div>
            <div class="col-3" style="text-align: right">
                <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModalDeleteAll" data-toggle="tooltip" data-placement="bottom" title="Excluir Todas as Atividades">
                    <i class="material-icons red md-50">delete_forever</i>
                </a>
            </div>
        </div>
        <h5 class="card-title">Painel de Atividades Diárias - <?php echo e(date("d/m/Y H:i")); ?></h5>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Atividade">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Atividade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="nova-atividade" method="POST" action="/admin/atividadeDiaria" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="prof" name="prof" required>
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $profs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($prof->id); ?>"><?php echo e($prof->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="prof">Professor(a)</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="disciplina" name="disciplina" required>
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($disciplina->id); ?>"><?php echo e($disciplina->nome); ?> (<?php if($disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="disciplina">Disciplina</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º<?php echo e($turma->turma); ?><?php echo e($turma->turno); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="data" id="data" required>
                            <label for="data">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="text" name="descricao" id="descricao" required>
                            <label for="descricao">Descrição</label>
                        </div>
                        <div class="col-auto form-floating">
                            <ul id="arquivos" class="list-group">
                                <li class="list-group-item"><input class="form-control" type="file" id="arquivo0" name="arquivo0" required></li>
                            </ul>
                            <input type="hidden" id="qtdArq" name="qtdArq" value="0">
                            <div class="modal-footer">
                                <a href="#" onclick="addArquivo();" class="badge bg-info" data-toggle="tooltip" data-placement="bottom" title="Adicionar Mais Arquivos"><i class="material-icons white md-24">add</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a onclick="enviar();" class="btn btn-sm btn-primary">Enviar</a>
                    </div>
                </form>
                </div>
            </div>
            </div>
            <?php if(count($atividades)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem atividades cadastradas!
                        <?php endif; ?>
                        <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/admin/atividadeDiaria" class="btn btn-sm btn-success">Voltar</a>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/atividadeDiaria/filtro">
                        <?php echo csrf_field(); ?>
                        <div class="col-auto form-floating">
                            <select class="form-select" name="prof">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $profs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($prof->id); ?>"><?php echo e($prof->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="prof">Professor(a)</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" name="disciplina">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($disciplina->id); ?>"><?php echo e($disciplina->nome); ?><?php if($disciplina->ensino=='fund'): ?> (Fundamental) <?php else: ?> <?php if($disciplina->ensino=='medio'): ?> (Médio) <?php endif; ?> <?php endif; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="disciplina">Disciplina</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" name="turma">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º<?php echo e($turma->turma); ?><?php echo e($turma->turno); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" name="data">
                            <label for="data">Data</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control mr-sm-2" type="text" placeholder="Digite a descrição" name="descricao">
                            <label for="descricao">Descrição Atividade</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo <?php echo e($atividades->count()); ?> de <?php echo e($atividades->total()); ?> de Atividades (<?php echo e($atividades->firstItem()); ?> a <?php echo e($atividades->lastItem()); ?>)</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $dataAtual = date("Y-m-d");
                ?>
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo e($atividade->id); ?>"><div id="my-div" class="bd-callout <?php if($atividade->impresso==1): ?> bd-callout-success <?php else: ?> <?php if($atividade->data==$dataAtual && $atividade->impresso==0): ?> bd-callout-warning <?php else: ?> <?php if($atividade->data>$dataAtual && $atividade->impresso==0): ?> bd-callout-info <?php else: ?> <?php if($atividade->data<$dataAtual && $atividade->impresso==0): ?> bd-callout-danger <?php endif; ?> <?php endif; ?> <?php endif; ?> <?php endif; ?>">
                        <h4><?php echo e($atividade->prof->name); ?> - <?php echo e($atividade->disciplina->nome); ?> - <?php echo e($atividade->turma->serie); ?>º<?php echo e($atividade->turma->turma); ?><?php echo e($atividade->turma->turno); ?> - <?php echo e($atividade->descricao); ?></h4>
                        <p>Data: <?php echo e(date("d/m/Y", strtotime($atividade->data))); ?></p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo e($atividade->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atividade: <?php echo e($atividade->descricao); ?> <a href="/admin/atividadeDiaria/impresso/<?php echo e($atividade->id); ?>"> <?php if($atividade->impresso==0): ?> <button type="button" class="badge bg-warning" data-toggle="tooltip" data-placement="bottom" title="Não Impresso (Marcar como Impresso)"><i class="material-icons">print_disabled</i></button> <?php else: ?> <button type="button" class="badge bg-success" data-toggle="tooltip" data-placement="bottom" title="Impresso (Marcar como Não Impresso)"><i class="material-icons">print</i></button> <?php endif; ?></a></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Professor(a): <?php echo e($atividade->prof->name); ?> <br/> <hr/>
                                Disciplina: <?php echo e($atividade->disciplina->nome); ?> <br/> <hr/>
                                Turma: <?php echo e($atividade->turma->serie); ?>º<?php echo e($atividade->turma->turma); ?><?php echo e($atividade->turma->turno); ?><br/> <hr/>
                                Descrição: <?php echo e($atividade->descricao); ?> <br/> <hr/>
                                Data: <?php echo e(date("d/m/Y", strtotime($atividade->data))); ?> <br/> <hr/>
                                <ol class="list-group list-group-numbered">
                                <?php $__currentLoopData = $atividade->anexos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anexo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                      <div class="fw-bold"><?php echo e($anexo->descricao); ?></div>
                                    </div>
                                    <a type="button" class="badge bg-success rounded-pill" href="/admin/atividadeDiaria/download/<?php echo e($anexo->id); ?>"><i class="material-icons md-48">cloud_download</i></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ol>
                                <hr/>
                                Criado por: <?php echo e($atividade->usuario); ?><br/>
                                Data da Criação: <?php echo e(date("d/m/Y H:i", strtotime($atividade->created_at))); ?>

                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge bg-danger" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($atividade->id); ?>" data-bs-toggle="tooltip" data-placement="bottom" title="Excluir Atividade"><i class="material-icons md-48">delete</i></a> <br/> <hr/>
                            <!-- Modal Deletar -->
                            <div class="modal fade" id="exampleModalDelete<?php echo e($atividade->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Atividade: <?php echo e($atividade->descricao); ?> - <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Tem certeza que deseja excluir essa atividade?</h5>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-danger" href="/admin/atividadeDiaria/apagar/<?php echo e($atividade->id); ?>">Excluir</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="card-footer">
                <?php echo e($atividades->links()); ?>

            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- Modal Deletar Todos -->
<div class="modal fade" id="exampleModalDeleteAll" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Excluir Todas as Atividades</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Tem certeza que deseja excluir todas as atividades?</h5>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-danger" href="/admin/atividadeDiaria/apagar/-1">Excluir</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/atividade_diaria_admin.blade.php ENDPATH**/ ?>