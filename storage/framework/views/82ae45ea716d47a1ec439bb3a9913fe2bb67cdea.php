

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/admin/pedagogico" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/>
            <?php if(session('mensagem')): ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p><?php echo e(session('mensagem')); ?></p>
            </div>
            <?php endif; ?>
            <?php if(count($simulados)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem provas cadastradas!
                </div>
            <?php else: ?>
            <div class="row">
                <div class="col" style="text-align: left">
                    <form action="/admin/simulados" method="GET">
                        <?php echo csrf_field(); ?>
                        <label for="ano">Selecione o ano:
                        <select class="custom-select" id="ano" name="ano">
                            <option value="">Selecione</option>
                            <?php $__currentLoopData = $anos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $an): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($an->ano); ?>"><?php echo e($an->ano); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select></label>
                        <input type="submit" class="btn btn-primary" value="Selecionar">
                    </form>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="habilitarSubmit();">
                        Gerar Painel
                    </button>
                </div>
                <div class="col" style="text-align: right">
                    <h5>Baixe o modelo da Máscara</h5>
                    <a type="button" class="btn btn-info" href="/admin/templates/download/mascara">Baixar Máscara</a>
                </div>
            </div>
            <h5 class="card-title">Provas - <?php echo e($ano); ?></h5>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="thead-dark">
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
                    <?php $__currentLoopData = $simulados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr <?php if($sim->prazo==$data): ?> style="color:orange" <?php else: ?> <?php if($sim->prazo>$data): ?> style="color:green" <?php else: ?> <?php if($sim->prazo<$data): ?> style="color:red" <?php endif; ?> <?php endif; ?> <?php endif; ?>>
                        <td><?php echo e(date("d/m/Y", strtotime($sim->prazo))); ?></td>
                        <td><?php echo e($sim->descricao); ?></td>
                        <td><?php echo e($sim->bimestre); ?>° Bimestre</td>
                        <td><?php echo e($sim->ano); ?></td>
                        <td>
                            <ul>
                            <?php $__currentLoopData = $sim->series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($serie->serie); ?>º ANO</li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                        <td>
                            <a href="/admin/conteudosProvas/painel/<?php echo e($sim->id); ?>" class="badge badge-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                        </td>
                        <td> 
                            <a href="/admin/simulados/painel/<?php echo e($sim->id); ?>" class="badge badge-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                        </td>
                        <td> 
                            <button type="button" class="badge badge-warning" data-toggle="modal" data-target="#exampleModalEdit<?php echo e($sim->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar"><i class="material-icons md-18">edit</i></button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalEdit<?php echo e($sim->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Editar Questões</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/admin/simulados/editar/<?php echo e($sim->id); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-group">
                                                <label for="descricao">Descrição</label>
                                                <input type="text" class="form-control" name="descricao" id="descricao" value="<?php echo e($sim->descricao); ?>" required>
                                                <label for="prazo">Prazo</label>
                                                <input type="date" class="form-control" name="prazo" id="prazo" value="<?php echo e(date("Y-m-d", strtotime($sim->prazo))); ?>" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sn">Salvar</button>
                                    </div>
                                </form>
                                </div>
                                </div>
                            </div>

                            <button type="button" class="badge badge-danger" data-toggle="modal" data-target="#exampleModalDelete<?php echo e($sim->id); ?>"><i class="material-icons md-18">delete</i></button></td>
                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" id="exampleModalDelete<?php echo e($sim->id); ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Excluir Prova: <?php echo e($sim->descricao); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5>Tem certeza que deseja excluir essa prova?</h5>
                                            <p>Não será possivel reverter esta ação.</p>
                                            <a href="/admin/simulados/apagar/<?php echo e($sim->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Inativar">Excluir</a>
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
            <h5 class="modal-title" id="exampleModalLabel">Gerar Painel</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <form id="form-sim" action="/admin/simulados/gerar" method="POST">
                    <?php echo csrf_field(); ?>
                <label for="prazo">Prazo Entrega</label>
                <input class="form-control" type="date" name="prazo" id="prazo" required>
                <label for="descricao">Descrição da Prova: </label>
                <input class="form-control" type="text"  name="descricao" id="descricao" required>
                <label for="ano">Ano: </label>
                <input class="form-control" type="number"  name="ano" id="ano" required>
                <label for="bimestre">Bimestre: </label>
                <select class="custom-select" id="bimestre" name="bimestre" required>
                    <option value="">Selecione</option>
                    <option value="1">1º</option>
                    <option value="2">2º</option>
                    <option value="3">3º</option>
                    <option value="4">4º</option>
                </select>
                <br/><br/>
                <button class="btn btn-primary btn-sm" id="botao" type="button" data-toggle="tooltip" data-placement="bottom" title="Marcar Todas as Séries" onclick="marcacao()">Marcar Todas</button>
                <br/>
                <div class="checkbox-group required">
                <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <br/>
                <input type="checkbox" class="check" id="turma<?php echo e($turma->id); ?>" name="turmas[]" value="<?php echo e($turma->id); ?>">
                <label for="turma<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO (<?php if($turma->ensino == "fund"): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</label>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <br/><br/>
                <button type="submit" id="processamento" class="btn btn-primary">Gerar</button>
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
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/home_simulados.blade.php ENDPATH**/ ?>