<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
    <a href="/admin/notas/<?php echo e($ano); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
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
                                        <td style="color:red; text-align: center;"> Pendente <br/> <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($lancamento->id); ?>"><i class="material-icons md-18">cloud_upload</i></button>
                                    <?php else: ?>
                                        <td><?php if($lancamento->nota>=7): ?><span class="badge rounded-pill bg-primary"><b><?php echo e($lancamento->nota); ?></b></span> <?php else: ?> <span class="badge rounded-pill bg-danger"><b><?php echo e($lancamento->nota); ?></b></span> <?php endif; ?><br/>
                                        <button type="button" class="badge bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModalAnexar<?php echo e($lancamento->id); ?>"><i class="material-icons md-18">edit</i></button> <a type="button" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#exampleModalDelete<?php echo e($lancamento->id); ?>"><i class="material-icons md-18 white">delete</i></a></td>
                                        <!-- Modal Deletar -->
                                        <div style="text-align: center;" class="modal fade" id="exampleModalDelete<?php echo e($lancamento->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Zerar Nota <?php echo e($nota->descricao); ?> - <?php echo e($lancamento->disciplina->nome); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>ALuno(a): <?php echo e($aluno->name); ?></h4>
                                                        <h5>Tem certeza que deseja zerar essa nota?</h5>
                                                        <p>Não será possivel reverter esta ação.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <a href="/admin/notas/zerar/<?php echo e($lancamento->id); ?>" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="right" title="Zerar">Zerar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <!-- Modal Anexar -->
                                    <div style="text-align: center;" class="modal fade" id="exampleModalAnexar<?php echo e($lancamento->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Lançar Nota <?php echo e($nota->descricao); ?> - <?php echo e($lancamento->disciplina->nome); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="/admin/notas/lancar/<?php echo e($lancamento->id); ?>">
                                                    <h4>Aluno(a): <?php echo e($aluno->name); ?></h4>
                                                    <?php echo csrf_field(); ?>
                                                    <div class="col-12 input-group mb-3">
                                                        <label for="nota<?php echo e($lancamento->id); ?>" class="input-group-text">Nota</label>
                                                        <input class="form-control" type="text" id="nota<?php echo e($lancamento->id); ?>" name="nota" value="<?php echo e($lancamento->nota); ?>" onblur="getValor('nota<?php echo e($lancamento->id); ?>')" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-outline-primary">Lançar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
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

<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/notas.blade.php ENDPATH**/ ?>