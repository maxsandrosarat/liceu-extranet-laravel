

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/prof" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
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
                    <form action="/prof/simulados" method="GET">
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
                </div>
                <div class="col" style="text-align: right">
                    <h5>Baixe o modelo da Máscara</h5>
                    <a type="button" class="btn btn-info" href="/prof/templates/download/mascara">Baixar Máscara</a>
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
                        <td><a href="/prof/conteudosProvas/painel/<?php echo e($sim->id); ?>" class="badge badge-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a></td>
                        <td><a href="/prof/simulados/painel/<?php echo e($sim->id); ?>" class="badge badge-primary" data-toggle="tooltip" data-placement="right" title="Painel"><i class="material-icons md-18">attach_file</i></a></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"simulados"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/profs/home_simulados.blade.php ENDPATH**/ ?>