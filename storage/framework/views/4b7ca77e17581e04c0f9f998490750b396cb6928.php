

<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col" style="text-align: left">
                        <a href="/admin/diario" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
                        </div>
                    </div>
                    <br/>
                    <h5 class="card-title">Relatório de Diários</h5>
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
                    <form id="form-relatorio" method="POST" action="/admin/diario/relatorio">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                    <label for="dataInicio">Entre / A partir</label>
                                    <input class="form-control" type="date" id="dataInicio" name="dataInicio" required>
                                </div>
                                <div class="col-auto my-1">
                                    <label for="dataFim">E / Até</label>
                                    <input class="form-control" type="date" placeholder="E / Até" id="dataFim" name="dataFim">
                                </div>
                                <div class="col-auto my-1">
                                    <label for="turma">Turma
                                    <select class="custom-select mr-sm-2" id="turma" name="turma" required>
                                        <option value="">Selecione</option>
                                        <?php $__currentLoopData = $turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($turma->ativo==false): ?> style="color: red;" <?php endif; ?> value="<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    </label>
                                </div>
                                <div class="col-auto my-1">
                                    <label for="disciplina">Disciplina
                                    <select class="custom-select" id="disciplina" name="disciplina">
                                        <option value="">Selecione</option>
                                        <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php if($disc->ativo==false): ?> style="color: red;" <?php endif; ?> value="<?php echo e($disc->id); ?>"><?php echo e($disc->nome); ?> (<?php if($disc->ensino=="fund"): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    </label>
                                </div>
                                <div class="col-auto my-1">
                                    <label for="prof">Professor(a)
                                    <select class="custom-select" id="prof" name="prof">
                                        <option value="">Selecione</option>
                                        <?php $__currentLoopData = $profs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($prof->ativo==false): ?> style="color: red;" <?php endif; ?> value="<?php echo e($prof->id); ?>"><?php echo e($prof->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    </label>
                                </div>
                                <div class="col-auto my-1">
                                    <label for="conferido">Conferido
                                    <select class="custom-select" id="conferido" name="conferido">
                                        <option value="">Selecione</option>
                                        <option value="1">Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                    </label>
                                </div>
                            </div>
                            <hr/>
                                <h3>Campos do Relatório</h3>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="disciplina" name="campos[]" value="disciplina" checked>
                                    <label class="form-check-label" for="disciplina">Disciplina</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="prof" name="campos[]" value="prof" checked>
                                    <label class="form-check-label" for="prof">Professor(a)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tema" name="campos[]" value="tema" checked>
                                    <label class="form-check-label" for="tema">Tema</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="conteudo" name="campos[]" value="conteudo" checked>
                                    <label class="form-check-label" for="conteudo">Conteúdo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="referencia" name="campos[]" value="referencia" checked>
                                    <label class="form-check-label" for="referencia">Referências</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tarefa" name="campos[]" value="tarefa" checked>
                                    <label class="form-check-label" for="tarefa">Tarefa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tempos" name="campos[]" value="tempos">
                                    <label class="form-check-label" for="tempos">Tempos</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tipoTarefa" name="campos[]" value="tipoTarefa">
                                    <label class="form-check-label" for="tipoTarefa">Tipo de Tarefa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="entregaTarefa" name="campos[]" value="entregaTarefa">
                                    <label class="form-check-label" for="entregaTarefa">Entrega da Tarefa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="conferido" name="campos[]" value="conferido">
                                    <label class="form-check-label" for="conferido">Conferido</label>
                                </div>
                            <hr/>
                            <div class="modal-footer" id="processamento">
                                <button id="btn-submit" type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/diario_relatorio.blade.php ENDPATH**/ ?>