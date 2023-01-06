

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <h5 class="card-title">Provas - <?php echo e($ano); ?></h5>
            <a type="button" class="float-button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="habilitarSubmit();" data-toggle="tooltip" data-placement="bottom" title="Criar Prova">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <?php if(count($provas)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem provas cadastradas!
                </div>
            <?php else: ?>
            <div class="row">
                <div class="col">
                    <form class="row gy-2 gx-3 align-items-center" action="/admin/provas" method="GET">
                        <?php echo csrf_field(); ?>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="ano" name="ano">
                                <option value="">Selecione</option>
                                <?php $__currentLoopData = $anos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $an): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($an->ano); ?>"><?php echo e($an->ano); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label for="ano">Ano:</label>
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="btn btn-primary" value="Selecionar">
                        </div> 
                    </form>
                </div>
                <div class="col" style="text-align: right;">
                    <h5>Baixe o modelo da Máscara</h5>
                    <a type="button" class="btn btn-info" href="/admin/templates/download/mascara">Baixar Máscara</a>
                </div>
            </div>
            <br/>
            <div class="table-responsive-xl">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Prazo Entrega</th>
                        <th>Descrição</th>
                        <th>Bimestre</th>
                        <th>Ano</th>
                        <th>Série(s)</th>
                        <th>Conteúdos</th>
                        <th>Questões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = date("Y-m-d");
                    ?>
                    <?php $__currentLoopData = $provas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prova): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr <?php if($prova->prazo==$data): ?> style="color:orange" <?php else: ?> <?php if($prova->prazo>$data): ?> style="color:green" <?php else: ?> <?php if($prova->prazo<$data): ?> style="color:red" <?php endif; ?> <?php endif; ?> <?php endif; ?>>
                        <td><?php echo e(date("d/m/Y", strtotime($prova->prazo))); ?></td>
                        <td><?php echo e($prova->descricao); ?></td>
                        <td><?php echo e($prova->bimestre); ?>° Bimestre</td>
                        <td><?php echo e($prova->ano); ?></td>
                        <td>
                            <ul>
                            <?php $__currentLoopData = $prova->series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($serie->turma->serie); ?>º ANO <?php echo e($serie->turma->turma); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                        <td>
                            <a href="/admin/conteudosProvas/painel/<?php echo e($prova->id); ?>" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                        </td>
                        <td> 
                            <a href="/admin/provas/painel/<?php echo e($prova->id); ?>" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                        </td>
                        <td> 
                            <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalEdit<?php echo e($prova->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar"><i class="material-icons md-18">edit</i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalEdit<?php echo e($prova->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Prova - <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>° Bimestre (<?php echo e($prova->ano); ?>)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/admin/provas/editar/<?php echo e($prova->id); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="col-12 form-floating">
                                                <input type="text" class="form-control" name="descricao" id="descricao" value="<?php echo e($prova->descricao); ?>" required>
                                                <label for="descricao">Descrição</label>
                                            </div>
                                            <div class="col-12 form-floating">
                                                <input type="date" class="form-control" name="prazo" id="prazo" value="<?php echo e(date("Y-m-d", strtotime($prova->prazo))); ?>" required>
                                                <label for="prazo">Prazo</label>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>

                            <button type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($prova->id); ?>"><i class="material-icons md-18">delete</i></button></td>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($prova->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Excluir Prova: <?php echo e($prova->descricao); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Tem certeza que deseja excluir essa prova?</h5>
                                            <p>Não será possivel reverter esta ação.</p>
                                            <a href="/admin/provas/apagar/<?php echo e($prova->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Criar Prova</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <form id="form-sim" action="/admin/provas/gerar" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="col-12 form-floating">
                        <input class="form-control" type="date" name="prazo" id="prazo" placeholder="Prazo Entrega" required>
                        <label for="prazo">Prazo Entrega</label>
                    </div>  
                    <div class="col-12 form-floating">
                        <input class="form-control" type="text"  name="descricao" id="descricao" placeholder="Descrição da Prova" required>
                        <label for="descricao">Descrição da Prova</label>
                    </div>  
                    <div class="col-12 form-floating">
                        <input class="form-control" type="number" name="ano" id="ano" placeholder="Ano" required>
                        <label for="ano">Ano</label>
                    </div>
                    <div class="col-12 form-floating">
                        <select class="form-select" id="bimestre" name="bimestre" required>
                            <option value="">Selecione</option>
                            <option value="1">1º</option>
                            <option value="2">2º</option>
                            <option value="3">3º</option>
                            <option value="4">4º</option>
                        </select>
                        <label for="bimestre">Bimestre</label>
                    </div>
                <hr/>
                <button class="btn btn-primary btn-sm" id="botao" type="button" data-toggle="tooltip" data-placement="bottom" title="Marcar Todas as Séries" onclick="marcacao()">Marcar Todas</button>
                <br/><br/>
                <div class="checkbox-group required">
                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input check" id="turma<?php echo e($turma->id); ?>" name="turmas[]" value="<?php echo e($turma->id); ?>">
                    <label class="form-check-label" for="turma<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> <?php if($turma->ensino=="fund"): ?> (Fundamental) <?php else: ?> <?php if($turma->ensino=="medio"): ?> (Médio) <?php endif; ?> <?php endif; ?></label>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="modal-footer">
                <button type="submit" id="processamento" class="btn btn-primary">Gerar</button>
                </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        function marcacao(){
            let checkbox = document.querySelectorAll('.check')

            var botao = document.getElementById("botao");
            if(botao.innerHTML=="Marcar Todas"){
                for(let current of checkbox){
                    current.checked = true
                }
                botao.innerHTML = "Desmarcar Todas";
                botao.className = "btn btn-warning btn-sm";
                botao.title = "Desmarcar Todas as Séries";
            } else {
                for(let current of checkbox){
                    current.checked = false
                }
                botao.innerHTML = "Marcar Todas";
                botao.className = "btn btn-primary btn-sm";
                botao.title = "Marcar Todas as Séries";
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/home_provas.blade.php ENDPATH**/ ?>