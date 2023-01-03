

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
    <a href="/outro/notas/<?php echo e($ano); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
    <br/><br/>
    <h5 class="card-title">Painel de Notas <?php echo e($nota->descricao); ?> - <?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> - <?php echo e($nota->bimestre); ?>º Bimestre - Ano: <?php echo e($nota->ano); ?></h5>
        <div class="table-responsive-xl">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Alunos</th>
                        <th>Disciplinas</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <?php
                    $qtdDiscs = count($disciplinas);
                ?>
                <tbody>
                    <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $pertence = 0;
                    ?>
                    <tr>
                        <td rowspan="<?php echo e($qtdDiscs+1); ?>"><?php echo e($aluno->name); ?></td>
                    </tr>
                        <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($disciplina->nome); ?></td>
                            <?php
                                $pertence = 0;
                            ?>
                            <?php $__currentLoopData = $lancamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lancamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($aluno->id == $lancamento->aluno->id && $disciplina->id==$lancamento->disciplina->id): ?>
                                    <?php
                                        $pertence ++;
                                    ?>
                                    <?php if($lancamento->nota==""): ?>
                                        <td style="color:red; text-align: center;"> Pendente
                                    <?php else: ?>
                                        <td><?php if($lancamento->nota>=7): ?><span class="badge rounded-pill bg-primary"><b><?php echo e($lancamento->nota); ?></b></span> <?php else: ?> <span class="badge rounded-pill bg-danger"><b><?php echo e($lancamento->nota); ?></b></span> <?php endif; ?>
                                        
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($pertence==0): ?>
                            <td style="color:blue; text-align: center; font-weight:bold;">Não se <br/>Aplica</td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function getValor(campo){
        var valor = id(campo).value.replace(',','.');
        var length = valor.length;
        if(length>0){
            id(campo).value = parseFloat(valor);
        } else {
            $('#'+ campo +'').val("");
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/outros/notas.blade.php ENDPATH**/ ?>