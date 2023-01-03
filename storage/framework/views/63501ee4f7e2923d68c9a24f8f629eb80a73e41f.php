

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <h5 class="card-title">Provas - <?php echo e($ano); ?></h5>
            <?php if(count($provas)==0): ?>
                <div class="alert alert-danger" role="alert">
                    Sem provas cadastradas!
                </div>
            <?php else: ?>
            <div class="row">
                <div class="col">
                    <form class="row gy-2 gx-3 align-items-center" action="/prof/provas" method="GET">
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
                    <a type="button" class="btn btn-info" href="/prof/templates/download/mascara">Baixar Máscara</a>
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
                            <a href="/prof/conteudosProvas/painel/<?php echo e($prova->id); ?>" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
                        </td>
                        <td> 
                            <a href="/prof/provas/painel/<?php echo e($prova->id); ?>" class="badge bg-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a>
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
<?php echo $__env->make('layouts.app', ["current"=>"provas"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/profs/home_provas.blade.php ENDPATH**/ ?>