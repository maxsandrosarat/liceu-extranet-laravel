<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title><?php echo e($serie); ?> º Ano - Conteúdos <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre</title>
        <link rel="shortcut icon" href="/storage/favicon.png"/>
        <style type="text/css">
            .disc {
                white-space: nowrap;
            }
        </style>
    </head>
    <body>
    <div class="card border">
        <div class="card-body" style="text-align: center;">
            <img src="storage/liceu.png" width="150"/>
            <h5 class="card-title">Turma: <?php echo e($serie); ?> º Ano<br/>
            Prova: <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre</h5>
     
            <table class="table table-striped table-sm">
                <thead class="thead-dark" style="font-size: 80%; text-align: center;">
                    <tr>
                        <th class="disc">Disciplina</th>
                        <th>Professor(a)</th>
                        <th>Conteúdo</th>
                    </tr>
                </thead>
                <tbody style="font-size: 65%;">
                    <?php $__currentLoopData = $conteudos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($conts->descricao!=''): ?>
                    <tr>
                        <td class="disc" style="text-align: center;"><?php echo e($conts->disciplina->nome); ?></td>
                        <td style="text-align: center;">
                            <?php $__currentLoopData = $profs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($prof->disciplina->id==$conts->disciplina->id && $prof->prof->ativo=="1"): ?><b><?php echo e($prof->prof->name); ?></b><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td><?php echo nl2br($conts->descricao); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/conteudos_pdf.blade.php ENDPATH**/ ?>