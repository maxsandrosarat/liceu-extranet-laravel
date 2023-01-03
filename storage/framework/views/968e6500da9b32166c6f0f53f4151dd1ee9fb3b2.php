<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Lista de Compras - <?php echo e(date("d/m/Y", strtotime($lista->data))); ?></title>
        <link rel="shortcut icon" href="/storage/favicon.png"/>
    </head>
    <body>
    <div class="card border">
        <div class="card-body">
            <h4 class="card-title">Lista de Compras - <?php echo e(date("d/m/Y", strtotime($lista->data))); ?></h4>
            <h5>Solicitante: <?php echo e($lista->usuario); ?></h5>
            <table class="table table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center;">Produto(s)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $produtos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($prod->produto->nome); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $produtoExtras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($prod->nome); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/compras_pdf.blade.php ENDPATH**/ ?>