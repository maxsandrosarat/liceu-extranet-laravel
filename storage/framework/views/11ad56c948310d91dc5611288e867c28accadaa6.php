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
                            Gerenciar as Atividades
                        </p>
                        <a href="/prof/atividadeComplementar" class="btn btn-primary">Atividades</a>
                    </div>
                </div>
            </div>
            <!--<div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Atividades Complementares</h5>
                        <p class="card-text">
                            Gerenciar as Atividades
                        </p>
                        <a href="/prof/atividade/disciplinas" class="btn btn-primary">Atividades</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Rotinas Semanais</h5>
                        <p class="card-text">
                            Gerenciar as Lista de Atividades
                        </p>
                        <a href="/prof/listaAtividade/<?php echo e(date("Y")); ?>" class="btn btn-primary">LAs</a>
                    </div>
                </div>
            </div>-->
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Ficha de Sala (Diário)</h5>
                        <p class="card-text">
                            Lançar os Conteúdos e Tarefas
                        </p>
                        <a href="/prof/diario/disciplinas" class="btn btn-primary">Diário</a>
                    </div>
                </div>
            </div>
            <!--<div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Ocorrências</h5>
                        <p class="card-text">
                            Lançar as Ocorrências
                        </p>
                        <a href="/prof/ocorrencias/disciplinas" class="btn btn-primary">Ocorrências</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Conteúdos de Provas</h5>
                        <p class="card-text">
                            Anexar e baixar os conteúdos
                        </p>
                        <a href="/prof/conteudos/<?php echo e(date("Y")); ?>" class="btn btn-primary">Conteúdos</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Conteúdos de Provas</h5>
                        <p class="card-text">
                            Anexar e baixar os conteúdos
                        </p>
                        <a href="/prof/conteudosProvas/<?php echo e(date("Y")); ?>" class="btn btn-primary">Conteúdos</a>
                    </div>
                </div>
            </div>-->
            <div class="d-flex justify-content-center centralizado">
                <div class="card border-primary text-center" style="width: 300px;">
                    <div class="card-body">
                        <h5>Provas</h5>
                        <p class="card-text">
                            Cadastrar Conteúdos e Questões
                        </p>
                        <a href="/prof/simulados/<?php echo e(date("Y")); ?>" class="btn btn-primary">Provas</a>
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
                        <a href="/prof/planejamentos/<?php echo e(date("Y")); ?>" class="btn btn-primary">Planejamentos</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"home"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/profs/home_prof.blade.php ENDPATH**/ ?>