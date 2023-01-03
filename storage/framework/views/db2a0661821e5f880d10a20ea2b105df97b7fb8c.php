<?php $__env->startSection('body'); ?>
<div class="container">
    <div class="row justify-content-center">
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Atividades Complementares</h5>
                    <p class="card-text">
                        Consultar as Atividades
                    </p>
                    <a href="/admin/atividadeDiaria" class="btn btn-primary">Atividades</a>
                </div>
            </div>
        </div>
        
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ficha de Sala (Diário)</h5>
                    <p class="card-text">
                        Lançamentos de Ficha de Sala (Diário)
                    </p>
                    <a href="/admin/diario" class="btn btn-primary">Diário</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Ocorrências</h5>
                    <p class="card-text">
                        Consultar e Analisar as Ocorrências
                    </p>
                    <a href="/admin/ocorrencias" class="btn btn-primary">Ocorrências</a>
                </div>
            </div>
        </div>
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Provas</h5>
                    <p class="card-text">
                        Consultar Conteúdos e Questões
                    </p>
                    <a href="/admin/provas/<?php echo e(date("Y")); ?>" class="btn btn-primary">Provas</a>
                </div>
            </div>
        </div>
        
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Documentos</h5>
                    <p class="card-text">
                        Gerenciar Documentos Importantes
                    </p>
                    <a href="/admin/documentos" class="btn btn-primary">Documentos</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Lembretes</h5>
                    <p class="card-text">
                        Gerenciar Lembretes
                    </p>
                    <a href="/admin/lembretes" class="btn btn-primary">Lembretes</a>
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="card border-primary text-center centralizado">
                <div class="card-body">
                    <h5>Planejamentos</h5>
                    <p class="card-text">
                        Cadastrar e Consultar Planejamentos
                    </p>
                    <a href="/admin/planejamentos/<?php echo e(date("Y")); ?>" class="btn btn-primary">Planejamentos</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/home_pedagogico.blade.php ENDPATH**/ ?>