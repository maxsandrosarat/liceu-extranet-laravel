<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Login</th>
            <th>Série</th>
            <th>Turma</th>
            <th>Turno</th>
            <th>Ensino</th>
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
            <td><?php echo e($aluno->turma->serie); ?></td>
            <td><?php echo e($aluno->turma->turma); ?></td>
            <td><?php echo e($aluno->turma->turno); ?></td>
            <td><?php echo e($aluno->turma->ensino); ?></td>
            <td><?php if($aluno->ativo==1): ?>Sim <?php else: ?> Não <?php endif; ?></td>
            <td><?php echo e($aluno->created_at->format('d/m/Y H:i')); ?></td>
            <td><?php echo e($aluno->updated_at->format('d/m/Y H:i')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/alunosTable.blade.php ENDPATH**/ ?>