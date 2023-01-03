

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
        <h5 class="card-title">Painel de Atividades Complementares</h5>
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
            <a type="button" class="float-button" data-toggle="modal" data-target="#exampleModalNovo" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Atividade">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <div class="modal fade" id="exampleModalNovo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Atividade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <form method="POST" action="/admin/atividadeComplementar" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <label for="turma">Turma</label>
                        <select class="custom-select" id="turma" name="turma" required>
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br/>
                        <label for="prof">Professor(a)</label>
                        <select class="custom-select" id="prof" name="prof" required>
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $profs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prof->id); ?>"><?php echo e($prof->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br/>
                        <label for="disciplina">Disciplina</label>
                        <select class="custom-select" id="disciplina" name="disciplina" required>
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($disciplina->id); ?>"><?php echo e($disciplina->nome); ?> (<?php if($disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <br/><br/>
                        <label for="data">Data Utilização</label>
                        <input class="form-control" type="date" name="data" id="data" required>
                        <br/>
                        <label for="descricao">Descrição</label>
                        <input class="form-control" type="text" name="descricao" id="descricao" required>
                        <br/>
                        <input class="form-control" type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf" required>
                        <br/>
                        <b style="font-size: 80%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                        <br/><br/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
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
                        <a href="/admin/atividade" class="btn btn-sm btn-success">Voltar</a>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="form-inline my-2 my-lg-0" method="GET" action="/admin/atividadeComplementar/filtro">
                        <?php echo csrf_field(); ?>
                        <label for="turma">Turma
                            <select class="custom-select" id="turma" name="turma">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select></label>
                            <label for="disciplina">Disciplina
                            <select class="custom-select" id="disciplina" name="disciplina">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($disciplina->id); ?>"><?php echo e($disciplina->nome); ?><?php if($disciplina->ensino=='fund'): ?> (Fundamental) <?php else: ?> <?php if($disciplina->ensino=='medio'): ?> (Médio) <?php endif; ?> <?php endif; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select></label>
                        <label for="descricao">Descrição Atividade</label>
                            <input class="form-control mr-sm-2" type="text" placeholder="Digite a descrição" name="descricao">
                        <button class="btn btn-sm btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo <?php echo e($atividades->count()); ?> de <?php echo e($atividades->total()); ?> de Atividades (<?php echo e($atividades->firstItem()); ?> a <?php echo e($atividades->lastItem()); ?>)</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $data = date("Y-m-d");
                    $dataAtiv = date("Y-m-d", strtotime($atividade->data));
                ?>
                    <a class="fill-div" data-toggle="modal" data-target="#exampleModal<?php echo e($atividade->id); ?>"><div id="my-div" class="bd-callout <?php if($atividade->impresso==true): ?> bd-callout-success <?php else: ?> <?php if($dataAtiv==$data && $atividade->data>$data): ?> bd-callout-warning <?php else: ?> <?php if($atividade->data>$data): ?> bd-callout-info <?php else: ?> <?php if($atividade->data<$data): ?> bd-callout-danger <?php endif; ?> <?php endif; ?> <?php endif; ?> <?php endif; ?>">
                        <h4><?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?> - <?php echo e($atividade->disciplina->nome); ?> - <?php echo e($atividade->descricao); ?></h4>
                        <p>Utilização: <?php echo e(date("d/m/Y", strtotime($atividade->data))); ?></p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?php echo e($atividade->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atividade: <?php echo e($atividade->descricao); ?> <?php if($atividade->impresso==false): ?><a type="button" href="/admin/atividadeComplementar/impresso/<?php echo e($atividade->id); ?>" class="badge badge-success" data-toggle="tooltip" data-placement="bottom" title="Impresso"><i class="material-icons">print</i></a><?php else: ?> <a type="button" href="/admin/atividadeComplementar/impresso/<?php echo e($atividade->id); ?>" class="badge badge-warning" data-toggle="tooltip" data-placement="bottom" title="Não Impresso"><i class="material-icons">print</i></a> <?php endif; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Professor(a): <?php echo e($atividade->prof->name); ?> - Disciplina: <?php echo e($atividade->disciplina->nome); ?> <br/> <hr/>
                                Turma: <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?> <br/> <hr/>
                                Descrição: <?php echo e($atividade->descricao); ?> <br/> <hr/>
                                Data Utilização: <?php echo e(date("d/m/Y", strtotime($atividade->data))); ?> <br/> <hr/>
                                Data da Criação: <?php echo e(date("d/m/Y H:i", strtotime($atividade->created_at))); ?><br/>
                                Última Alteração: <?php echo e(date("d/m/Y H:i", strtotime($atividade->updated_at))); ?>

                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge badge-success" href="/admin/atividadeComplementar/download/<?php echo e($atividade->id); ?>"><i class="material-icons md-48">cloud_download</i></a> <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#modalEditar<?php echo e($atividade->id); ?>"><i class="material-icons md-48">edit</i></button> <a type="button" class="badge badge-danger" href="#" data-toggle="modal" data-target="#exampleModalDelete<?php echo e($atividade->id); ?>" data-toggle="tooltip" data-placement="bottom" title="Excluir Atividade"><i class="material-icons md-48">delete</i></a> <br/> <hr/>
                            <!-- Modal Editar -->
                            <div class="modal fade" id="modalEditar<?php echo e($atividade->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Atividade: <?php echo e($atividade->descricao); ?> - <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="/admin/atividadeComplementar/editar/<?php echo e($atividade->id); ?>" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <label for="turma">Turma</label>
                                        <select id="turma" class="form-control" name="turma" required>
                                            <option value="<?php echo e($atividade->turma->id); ?>"><?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?> (<?php if($atividade->turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($atividade->turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                            <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($turma->id!=$atividade->turma->id): ?>
                                            <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <br/>
                                        <label for="data" class="col-md-4 col-form-label text-md-right">Data Utilização</label>
                                        <input type="date" class="form-control" name="data" id="data" value="<?php echo e(date("Y-m-d", strtotime($atividade->data))); ?>" required>
                                        <br/>
                                        <label for="descricao">Descrição</label>
                                        <input type="text" class="form-control" name="descricao" id="descricao" value="<?php echo e($atividade->descricao); ?>" required>
                                        <br/>
                                        <input type="file" id="arquivo" name="arquivo" accept=".doc,.docx,.pdf">
                                        <br/>
                                        <b style="font-size: 80%;">Aceito apenas extensões do Word e PDF (".doc", ".docx" e ".pdf")</b>
                                        <br/><br/>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>
                            <!-- Modal Deletar -->
                            <div class="modal fade" id="exampleModalDelete<?php echo e($atividade->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Excluir Atividade: <?php echo e($atividade->descricao); ?> - <?php echo e($atividade->turma->serie); ?>º ANO <?php echo e($atividade->turma->turma); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5>Tem certeza que deseja excluir essa atividade?</h5>
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-danger" href="/admin/atividadeComplementar/apagar/<?php echo e($atividade->id); ?>">Excluir</a>
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
<br>
<a href="/admin/pedagogico" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/atividades_complementares_admin.blade.php ENDPATH**/ ?>