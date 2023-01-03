

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <h5 class="card-title">Painel de Recados</h5>
            <!-- Button trigger modal -->
            <a type="button" class="float-button" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Recado">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <?php if($message = Session::get('success')): ?>
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                        <strong><?php echo e($message); ?></strong>
                </div>
            <?php endif; ?>
            <?php if(count($recados)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem recados cadastrados! Faça novo cadastro no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        <?php else: ?> <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/admin/recados" class="btn btn-success">Voltar</a>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card">
                <div class="card border">
                    <h5 class="card-title">Filtros:</h5>
                    <form class="form-inline my-2 my-lg-0" method="GET" action="/admin/recados/filtro">
                        <?php echo csrf_field(); ?>
                        <input class="form-control mr-sm-2" type="text" placeholder="Titulo" name="titulo">
                        <label for="dataInicio">Data Início</label>
                        <input class="form-control mr-sm-2" type="date" name="dataInicio">
                        <label for="dataFim">Data Fim</label>
                        <input class="form-control mr-sm-2" type="date" name="dataFim">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                    </form>
                </div>
            </div>
            <br/>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover" style="text-align: center;">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Titulo</th>
                        <th>Descrição</th>
                        <th>Geral</th>
                        <th>Turma</th>
                        <th>Aluno</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($recado->id); ?></td>
                        <td><?php echo e($recado->titulo); ?></td>
                        <td><button type="button" class="badge badge-primary" data-toggle="modal" data-target="#exampleModalDesc<?php echo e($recado->id); ?>">Descrição</button></td>
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" id="exampleModalDesc<?php echo e($recado->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo e($recado->titulo); ?> - <?php echo e(date("d/m/Y", strtotime($recado->created_at))); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php echo e($recado->descricao); ?>

                            </div>
                            </div>
                        </div>
                        </div>
                        <td><?php if($recado->geral==1): ?> SIM <?php else: ?> NÃO <?php endif; ?></td>
                        <td><?php if($recado->turma==""): ?> <?php else: ?> <?php echo e($recado->turma->serie); ?>º ANO <?php echo e($recado->turma->turma); ?> <?php endif; ?></td>
                        <td><?php if($recado->aluno==""): ?> <?php else: ?> <?php echo e($recado->aluno->name); ?> <?php endif; ?></td>
                        <td><?php echo e(date("d/m/Y", strtotime($recado->created_at))); ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal<?php echo e($recado->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-48">edit</i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo e($recado->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Recado</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card border">
                                            <div class="card-body">
                                                <form action="/admin/recados/editar/<?php echo e($recado->id); ?>" method="POST" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label for="titulo">Titulo Recado</label>
                                                        <input type="text" class="form-control" name="titulo" id="titulo" value="<?php echo e($recado->titulo); ?>" required>
                                                        <label for="descricao">Descrição
                                                        <textarea class="form-control" name="descricao" id="descricao" rows="10" cols="60" required><?php echo e($recado->descricao); ?></textarea></label>
                                                        <h5>Geral?</h5>
                                                        <input type="radio" id="sim" name="geral" value="1" <?php if($recado->geral=="1"): ?> checked <?php endif; ?> required>
                                                        <label for="sim">Sim</label>
                                                        <input type="radio" id="nao" name="geral" value="0" <?php if($recado->geral=="0"): ?> checked <?php endif; ?> required>
                                                        <label for="nao">Não</label>
                                                        <br/>
                                                        <select class="custom-select" id="turma" name="turma" required>
                                                            <option value="<?php if($recado->turma==""): ?> <?php else: ?> <?php echo e($recado->turma->id); ?> <?php endif; ?>"><?php if($recado->turma==""): ?>Selecione <?php else: ?> <?php echo e($recado->turma->serie); ?>º ANO <?php echo e($recado->turma->turma); ?><?php endif; ?></option>
                                                            <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($recado->turma!="" && $turma->id==$recado->turma->id): ?>
                                                                <?php else: ?>
                                                                <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <br/>
                                                        <h5>Ou</h5>
                                                        <select class="custom-select" id="aluno" name="aluno" required>
                                                            <option value="<?php if($recado->aluno==""): ?> <?php else: ?> <?php echo e($recado->aluno->id); ?> <?php endif; ?>"><?php if($recado->aluno==""): ?>Selecione <?php else: ?> <?php echo e($recado->aluno->name); ?><?php endif; ?></option>
                                                            <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($recado->aluno!="" && $aluno->id==$recado->aluno->id): ?>
                                                                <?php else: ?>
                                                                <option value="<?php echo e($aluno->id); ?>"><?php echo e($aluno->name); ?></option>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <a href="/admin/recados/apagar/<?php echo e($recado->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Excluir"><i class="material-icons md-48">delete</i></a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            <div class="card-footer">
                <?php echo e($recados->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Novo Recado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card border">
                <div class="card-body">
                    <form action="/admin/recados" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="titulo">Titulo Recado</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Digite o titulo" required>
                            <label for="descricao">Descrição
                            <textarea class="form-control" name="descricao" id="descricao" rows="10" cols="60" required></textarea></label>
                            <br/>
                            <label for="selectGeral">Geral?</label>
                            <select class="custom-select" name="geral" id="selectGeral">
                                <option value="">Selecione</option>
                                <option value="1">SIM</option>
                                <option value="0">NÃO</option>
                            </select>
                            <br/>
                            <div id="principalSelect">
                                <div id="1">
                                </div>
                                <div id="0">
                                    <br/>
                                    <select class="custom-select" id="turma" name="turma">
                                        <option value="">Selecione uma turma</option>
                                        <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <br/>
                                    <h5>Ou</h5>
                                    <select class="custom-select" id="aluno" name="aluno">
                                        <option value="">Selecione um aluno</option>
                                            <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($aluno->id); ?>"><?php echo e($aluno->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    <br>
    <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/recados_admin.blade.php ENDPATH**/ ?>