

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <h5 class="card-title">Lista de Disciplinas</h5>
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
            <?php if(count($discs)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem disciplinas cadastradas!
                </div>
            <?php else: ?>
            <div class="table-responsive-xl">
            <table class="table table-striped table-ordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Ensino</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($disc->id); ?></td>
                        <td><?php echo e($disc->nome); ?></td>
                        <td><?php if($disc->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?></td>
                        <td>
                            <?php if($disc->ativo==1): ?>
                                <b><i class="material-icons green">check_circle</i></b>
                            <?php else: ?>
                                <b><i class="material-icons red">highlight_off</i></b>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($disc->ativo==1): ?>
                                <a href="/admin/disciplinas/apagar/<?php echo e($disc->id); ?>" class="badge badge-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            <?php else: ?>
                                <a href="/admin/disciplinas/apagar/<?php echo e($disc->id); ?>" class="badge badge-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
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
    <br>
    <!-- Button trigger modal -->
    <a type="button" class="float-button" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Nova Disciplina">
        <i class="material-icons blue md-60">add_circle</i>
    </a>
  
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Disciplinas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="card border">
                        <div class="card-body">
                            <form action="/admin/disciplinas" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="nome">Nome da Disciplina</label>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome da disciplina" required>
                                   <br/> 
                                    <label for="ensino">Ensino</label>
                                    <select class="custom-select" id="ensino" name="ensino" required>
                                        <option value="">Selecione</option>
                                            <option value="fund">Fundamental</option>
                                            <option value="medio">Médio</option>
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
    <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"administrativo"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/disciplinas.blade.php ENDPATH**/ ?>