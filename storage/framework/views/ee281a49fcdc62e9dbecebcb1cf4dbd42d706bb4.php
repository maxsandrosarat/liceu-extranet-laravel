

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <h5 class="card-title">Lista de Turmas</h5>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(count($turmas)==0): ?>
                <br/><br/>
                <div class="alert alert-danger" role="alert">
                    Sem turmas cadastradas!
                </div>
            <?php else: ?>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Série</th>
                        <th>Turma</th>
                        <th>Turno</th>
                        <th>Ensino</th>
                        <th>Disciplinas</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($turma->id); ?></td>
                        <td><?php echo e($turma->serie); ?>º ANO</td>
                        <td><?php echo e($turma->turma); ?></td>
                        <td><?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?></td>
                        <td><?php if($turma->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?></td>
                        <td>
                            <?php
                                $qtdDiscs = 0;
                                foreach($turma->disciplinas as $disc){
                                    $qtdDiscs++;
                                }
                            ?>
                            
                                
                                <button type="button" class="btn btn-primary position-relative" data-placement="bottom" title="<?php echo e($qtdDiscs); ?> disciplinas vinculadas" data-bs-toggle="modal" data-bs-target="#modalDiscsTurma<?php echo e($turma->id); ?>">Disciplinas<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo e($qtdDiscs); ?></span></button>
                                <!-- Modal Turmas-->
                                <div class="modal fade" id="modalDiscsTurma<?php echo e($turma->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-discsTurma<?php echo e($turma->id); ?>" action="/admin/turmas/disciplinas" method="POST" style="text-align: center;">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <input type="hidden" name="turma" value="<?php echo e($turma->id); ?>">
                                                        <ul class="list-group">
                                                            <?php
                                                                $ensino = '';
                                                                $ensino = $turma->ensino;
                                                            ?>
                                                            <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($disciplina->ensino==$ensino): ?>
                                                                <li class="list-group-item" <?php if($disciplina->ativo==false): ?> style="color: red;" <?php endif; ?>>
                                                                    <div class="form-group form-check">
                                                                        <input type="checkbox" class="form-check-input" id="turma<?php echo e($turma->id); ?>" name="disciplinas[]" value="<?php echo e($disciplina->id); ?>" 
                                                                        <?php if(count($turma->disciplinas)>0): ?>
                                                                        <?php $__currentLoopData = $turma->disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php if($disc->id==$disciplina->id): ?> checked <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php endif; ?>
                                                                        >
                                                                        <label class="form-check-label" for="turma<?php echo e($turma->id); ?>"><?php echo e($disciplina->nome); ?> (<?php if($disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</label>
                                                                    </div>
                                                                </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" form="form-discsTurma<?php echo e($turma->id); ?>" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </td>
                        <td>
                            <?php if($turma->ativo==1): ?>
                                <b><i class="material-icons green">check_circle</i></b>
                            <?php else: ?>
                                <b><i class="material-icons red">highlight_off</i></b>
                            <?php endif; ?>
                        </td>
                        <td>
                        <?php if($turma->ativo==1): ?>
                            <a href="/admin/turmas/apagar/<?php echo e($turma->id); ?>" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                        <?php else: ?>
                            <a href="/admin/turmas/apagar/<?php echo e($turma->id); ?>" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                        <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
    <!-- Button trigger modal -->
    <a type="button" class="float-button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Turma">
        <i class="material-icons blue md-60">add_circle</i>
    </a>
  
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Turma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border">
                        <div class="card-body">
                            <form class="row g-3" action="/admin/turmas" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="serie" type="number" id="serie" placeholder="Série da Turma" required/>
                                    <label for="serie">Série da Turma</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <input class="form-control" name="turma" type="text" id="turma" placeholder="Turma" required/>
                                    <label for="turma">Turma</label>
                                </div>
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="turno" name="turno">
                                        <option value="">Selecione</option>
                                        <option value="M">Matutino</option>
                                        <option value="V">Vespertino</option>
                                        <option value="N">Noturno</option>
                                    </select>
                                    <label for="turno">Turno</label>
                                </div>  
                                <div class="col-12 form-floating">
                                    <select class="form-select" id="ensino" name="ensino">
                                        <option value="">Selecione</option>
                                        <option value="fund">Fundamental</option>
                                        <option value="medio">Médio</option>
                                    </select>
                                    <label for="ensino">Ensino</label>
                                </div>  
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>    
                </div> 
            </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"administrativo"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/turmas.blade.php ENDPATH**/ ?>