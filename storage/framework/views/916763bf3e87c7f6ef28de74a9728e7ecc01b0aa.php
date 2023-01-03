<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title><?php echo e($turma->serie); ?> º Ano <?php echo e($turma->turma); ?> - Conteúdos <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre</title>
        <link rel="shortcut icon" href="/storage/favicon.png"/>
    </head>
    <body>
    <div class="card border">
        <div class="card-body" style="text-align: center;">
            <img src="storage/liceu.png" width="150"/>
            <h5 class="card-title">Turma: <?php echo e($turma->serie); ?> º Ano <?php echo e($turma->turma); ?><br/>
            Conteúdos da Prova: <?php echo e($prova->descricao); ?> - <?php echo e($prova->bimestre); ?>º Bimestre</h5>
     
            <table class="table table-striped table-bordered table-sm">
                <thead class="thead-dark" style="font-size: 80%; text-align: center;">
                    <tr>
                        <th>Disciplina</th>
                        <th>Professor(a)</th>
                        <th>Conteúdo</th>
                    </tr>
                </thead>
                <tbody style="font-size: 65%;">
                    <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $conteudos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conteudo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($conteudo->descricao!=''): ?>
                                <?php if($conteudo->disciplina->id==$disc->id): ?>
                                <tr>
                                    <td style="text-align: center;"><?php echo e($conteudo->disciplina->nome); ?></td>
                                    <td style="text-align: center;">
                                        <?php $__currentLoopData = $profs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $prof->disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($disciplina->id==$disc->id): ?><b><?php echo e($prof->name); ?></b><?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td><?php echo nl2br($conteudo->descricao); ?></td>
                                </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/outros/conteudos_pdf.blade.php ENDPATH**/ ?>