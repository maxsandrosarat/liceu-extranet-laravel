

<?php $__env->startSection('body'); ?>
<div class="jumbotron bg-light border border-secondary">
    <div class="row justify-content-center">
        <div class="col align-self-center">
        <div class="card-deck">
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Atividades Complementares</h5>
                        <p class="card-text">
                            Consultar as Atividades
                        </p>
                        <a href="/admin/atividadeComplementar" class="btn btn-primary">Atividades</a>
                    </div>
                </div>
            </div>
            <!--<div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Atividades</h5>
                        <p class="card-text">
                            Consultar as Atividades
                        </p>
                        <a href="/admin/atividade" class="btn btn-primary">Atividades</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Listas Atividades</h5>
                        <p class="card-text">
                            Consultar as Listas Atividades
                        </p>
                        <a href="/admin/listaAtividade/<?php echo e(date("Y")); ?>" class="btn btn-primary">Listas Atividades</a>
                    </div>
                </div>
            </div>-->
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Ficha de Sala (Diário)</h5>
                        <p class="card-text">
                            Lançamentos de Diário
                        </p>
                        <a href="/admin/diario" class="btn btn-primary">Diário</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Ocorrências</h5>
                        <p class="card-text">
                            Consultar e Analisar as Ocorrências
                        </p>
                        <a href="/admin/ocorrencias" class="btn btn-primary">Ocorrências</a>
                    </div>
                </div>
            </div>
            <!--<div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Conteúdos de Provas</h5>
                        <p class="card-text">
                            Gerar Campos e Consultar
                        </p>
                        <a href="/admin/conteudosProvas/<?php echo e(date("Y")); ?>" class="btn btn-primary">Conteúdos</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Conteúdos</h5>
                        <p class="card-text">
                            Gerar Campos e Consultar
                        </p>
                        <a href="/admin/conteudos/<?php echo e(date("Y")); ?>" class="btn btn-primary">Conteúdos</a>
                    </div>
                </div>
            </div>-->
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Recados</h5>
                        <p class="card-text">
                            Cadastrar e Consultar Recados
                        </p>
                        <a href="/admin/recados" class="btn btn-primary">Recados</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Provas</h5>
                        <p class="card-text">
                            Consultar Conteúdos e Questões
                        </p>
                        <a href="/admin/simulados/<?php echo e(date("Y")); ?>" class="btn btn-primary">Provas</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Planejamentos</h5>
                        <p class="card-text">
                            Cadastrar e Consultar Planejamentos
                        </p>
                        <a href="/admin/planejamentos/<?php echo e(date("Y")); ?>" class="btn btn-primary">Planejamentos</a>
                    </div>
                </div>
            </div>
            <!--<div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Atividades Extras</h5>
                        <p class="card-text">
                            Consultar e cadastrar Atividades Extras
                        </p>
                        <a href="/atividadeExtra" class="btn btn-primary">Atividades Extras</a>
                    </div>
                </div>
            </div>-->
        </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', ["current"=>"pedagogico"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/home_pedagogico.blade.php ENDPATH**/ ?>