<html>
    <head>
        <title>Relatório Diários - Turma: <?php echo e($turma->serie); ?>º Ano <?php echo e($turma->turma); ?></title>
        <link rel="shortcut icon" href="<?php echo e(base_path().'/public/storage/favicon.png'); ?>"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="<?php echo e(base_path().'/public_html/css/pdf.css'); ?>">
    </head>
    <body>
    <div class="card border">
        <div class="card-body" style="text-align: center;">
            <header>
                <div id="logos">
                    <img src="<?php echo e(base_path().'/public_html/storage/logo_liceu.png'); ?>" width="150"/>
                </div>
                <div id="cabeçalho">
                    <p style="color: #191970;"><b>RELATÓRIO DE DIÁRIOS </b><br/>
                        Turma: <?php echo e($turma->serie); ?>º Ano <?php echo e($turma->turma); ?>

                    </p>
                </div>
            </header>
            <main>
                <?php
                    $todos = false;
                    $tempos = false;
                    $disciplina = false;
                    $prof = false;
                    $tema = false;
                    $conteudo = false;
                    $referencia = false;
                    $tarefa = false;
                    $tipoTarefa = false;
                    $entregaTarefa = false;
                    $conferido = false;
                    foreach($campos as $campo){
                        if($campo=="tempos"){
                            $tempos = true;
                        } else if($campo=="disciplina"){
                            $disciplina = true;
                        } else if($campo=="prof"){
                            $prof = true;
                        } else if($campo=="tema"){
                            $tema = true;
                        } else if($campo=="conteudo"){
                            $conteudo = true;
                        } else if($campo=="referencia"){
                            $referencia = true;
                        } else if($campo=="tarefa"){
                            $tarefa = true;
                        } else if($campo=="tipoTarefa"){
                            $tipoTarefa = true;
                        } else if($campo=="entregaTarefa"){
                            $entregaTarefa = true;
                        } else if($campo=="conferido"){
                            $conferido = true;
                        } else {
                            $todos = true;
                        }
                    }
                ?>
                <?php if(count($diarios)==0): ?>
                    <div class="alert alert-warning" role="alert">
                    Sem diários lançados para os critérios escolhidos!
                    </div>
                <?php else: ?>
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Dia</th>
                            <th>Diários</th>
                        </tr>
                    </thead>
                    <?php
                        $trocouData = false;
                        $dataAtual = "";
                    ?>
                    <tbody>
                        <?php $__currentLoopData = $diarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            if($dataAtual!==$diario->dia){
                                $dataAtual = $diario->dia;
                                $trocouData = true;
                            } else {
                                $trocouData = false;
                            }
                        ?>
                        <tr>
                            <td style="white-space: nowrap; width: 70px; <?php if($trocouData): ?> border-top: 2px solid black; <?php endif; ?>"><?php echo e(date("d/m/Y", strtotime($diario->dia))); ?></td>
                            <td <?php if($trocouData): ?> style="border-top: 2px solid black;" <?php endif; ?>>
                                <?php if($tempos): ?> Tempo(s): <?php echo e($diario->tempo); ?>º <?php if($diario->segundo_tempo): ?> & <?php echo e($diario->outro_tempo); ?>º <?php endif; ?> <br/> <?php endif; ?>
                                <?php if($disciplina): ?> Disciplina: <?php echo e($diario->disciplina->nome); ?> <br/> <?php endif; ?>
                                <?php if($prof): ?> Professor(a): <?php echo e($diario->prof->name); ?> <br/> <?php endif; ?>
                                <?php if($tema): ?> Tema: <?php echo e($diario->tema); ?><br/> <?php endif; ?>
                                <?php if($conteudo): ?> Conteúdo: <?php echo e($diario->conteudo); ?><br/> <?php endif; ?>
                                <?php if($referencia): ?>  Referências: <?php echo e($diario->referencias); ?><br/> <?php endif; ?>
                                <?php if($tarefa): ?> Tarefa: <?php echo e($diario->tarefa); ?><br/> <?php endif; ?>
                                <?php if($tipoTarefa): ?> Tipo de Tarefa: <?php if($diario->tipo_tarefa=="AULA"): ?> VISTADA EM AULA <?php else: ?> ENVIADA NO SCULES <?php endif; ?><br/> <?php endif; ?>
                                <?php if($entregaTarefa): ?> Entrega da Tarefa: <?php echo e(date("d/m/Y", strtotime($diario->entrega_tarefa))); ?><br/> <?php endif; ?>
                                <?php if($conferido): ?> Conferido: <?php if($diario->conferido): ?> Sim <?php else: ?> Não <?php endif; ?> <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </main>
        </div>
    </div>
    </body>
</html><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/diario_relatorio_pdf.blade.php ENDPATH**/ ?>