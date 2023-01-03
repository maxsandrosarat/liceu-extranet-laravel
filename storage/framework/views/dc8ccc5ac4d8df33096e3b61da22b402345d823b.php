

<?php $__env->startSection('body'); ?>
<div class="card border">
    <div class="card-body">
        <a href="/outro" class="btn btn-success"data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
        <br/><br/>
        <h5 class="card-title">Painel de Documentos Importantes</h5>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(count($documentos)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem documentos cadastrados!
                        <?php endif; ?>
                        <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/outro/documentos" class="btn btn-sm btn-success">Voltar</a>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card border">
                <h5 class="card-title">Filtros:</h5>
                    <form class="row gy-2 gx-3 align-items-center" method="GET" action="/outro/documentos/filtro">
                        <?php echo csrf_field(); ?>
                        <div class="col-auto form-floating">
                            <input class="form-control mr-sm-2" type="text" placeholder="Título" name="titulo">
                            <label for="titulo">Título</label>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                        </div>
                    </form>
            </div>
            <hr/>
            <b><h5 class="font-italic">Exibindo <?php echo e($documentos->count()); ?> de <?php echo e($documentos->total()); ?> de Documentos (<?php echo e($documentos->firstItem()); ?> a <?php echo e($documentos->lastItem()); ?>)</u></h5></b>
            <hr/>
            <div class="table-responsive-xl">
                <?php $__currentLoopData = $documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $data = date("Y-m-d H:i");
                    $dataAtivPub = date("Y-m-d H:i", strtotime($documento->data_publicacao));
                    $dataAtivRem = date("Y-m-d H:i", strtotime($documento->data_remocao));
                ?>
                    <a class="fill-div" data-bs-toggle="modal" data-bs-target="#modalDoc<?php echo e($documento->id); ?>"><div id="my-div" class="bd-callout <?php if($dataAtivPub<$data && $dataAtivRem>$data): ?> bd-callout-success <?php else: ?> <?php if($dataAtivPub>$data): ?> bd-callout-warning <?php else: ?> bd-callout-danger <?php endif; ?> <?php endif; ?>">
                        <h4><?php echo e($documento->titulo); ?></h4>
                        <p>Publicação: <?php echo e(date("d/m/Y H:i", strtotime($documento->data_publicacao))); ?> - Remoção: <?php echo e(date("d/m/Y H:i", strtotime($documento->data_remocao))); ?></p>
                    </div></a>
                    <!-- Modal -->
                    <div class="modal fade" id="modalDoc<?php echo e($documento->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Documento: <?php echo e($documento->titulo); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bolder">
                                Título: <?php echo e($documento->titulo); ?> <br/> <hr/>
                                Data Publicação: <?php echo e(date("d/m/Y H:i", strtotime($documento->data_publicacao))); ?> <br/> <hr/>
                                Data Remoção: <?php echo e(date("d/m/Y H:i", strtotime($documento->data_remocao))); ?> <br/> <hr/>
                                Data Criação: <?php echo e(date("d/m/Y H:i", strtotime($documento->created_at))); ?><br/>
                                Última Alteração: <?php echo e(date("d/m/Y H:i", strtotime($documento->updated_at))); ?>

                            </p>
                        </div>
                        <div class="modal-footer">
                            <a type="button" class="badge bg-success" href="/outro/documentos/download/<?php echo e($documento->id); ?>"><i class="material-icons md-48">cloud_download</i></a>
                        </div>
                        </div>
                    </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="card-footer">
                <?php echo e($documentos->links()); ?>

            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/documentos_outro.blade.php ENDPATH**/ ?>