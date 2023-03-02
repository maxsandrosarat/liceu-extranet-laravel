<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Login</th>
            <th>Turma(s)</th>
            <th>Ativo</th>
            <th>Criação</th>
            <th>Última Atualização</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $alunos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aluno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($aluno->id); ?></td>
            <td><?php echo e($aluno->name); ?></td>
            <td><?php echo e($aluno->email); ?></td>
            <td>
                <?php $__currentLoopData = $aluno->turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <b <?php if($turma->ativo==false): ?> style="color: red;" <?php endif; ?>>- <?php echo e($turma->serie); ?>º<?php echo e($turma->turma); ?><?php echo e($turma->turno); ?> </b>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
            <td><?php if($aluno->ativo==1): ?>Sim <?php else: ?> Não <?php endif; ?></td>
            <td><?php echo e($aluno->created_at->format('d/m/Y H:i')); ?></td>
            <td><?php echo e($aluno->updated_at->format('d/m/Y H:i')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/admin/alunosTable.blade.php ENDPATH**/ ?>