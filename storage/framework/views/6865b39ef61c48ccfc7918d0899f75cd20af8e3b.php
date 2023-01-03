

<?php $__env->startSection('body'); ?>
    <div class="card border">
        <div class="card-body">
            <a href="/admin/administrativo" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
            <br/><br/>
            <?php if(session('mensagem')): ?>
                <div class="alert <?php if(session('type')=="success"): ?> alert-success <?php else: ?> <?php if(session('type')=="warning"): ?> alert-warning <?php else: ?> <?php if(session('type')=="danger"): ?> alert-danger <?php else: ?> alert-info <?php endif; ?> <?php endif; ?> <?php endif; ?> alert-dismissible fade show" role="alert">
                    <?php echo e(session('mensagem')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <h5 class="card-title">Lista de Professores</h5>
            <a type="button" class="float-button" onclick="checksDisc(0);" data-bs-toggle="modal" data-bs-target="#exampleModal" data-toggle="tooltip" data-placement="bottom" title="Adicionar Novo Professor(a)">
                <i class="material-icons blue md-60">add_circle</i>
            </a>
            <?php if(count($profs)==0): ?>
                    <div class="alert alert-dark" role="alert">
                        <?php if($view=="inicial"): ?>
                        Sem professores cadastrados! Faça novo cadastro no botão    <a type="button" href="#"><i class="material-icons blue">add_circle</i></a>   no canto inferior direito.
                        <?php endif; ?>
                        <?php if($view=="filtro"): ?>
                        Sem resultados da busca!
                        <a href="/admin/prof/consulta" class="btn btn-success">Voltar</a>
                        <?php endif; ?>
                    </div>
            <?php else: ?>
            <div class="card border">
                <h5>Filtros: </h5>
                <form class="row gy-2 gx-3 align-items-center" method="GET" action="/admin/prof/filtro">
                    <?php echo csrf_field(); ?>
                    <div class="col-auto form-floating">
                        <input class="form-control" name="nome" type="text" id="nome" placeholder="Nome do Professor"/>
                        <label for="nome">Nome do Professor</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="disciplina" name="disciplina">
                            <option value="">Selecione uma disciplina</option>
                            <?php $__currentLoopData = $discs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php if($disc->ativo==false): ?> style="color: red;" <?php endif; ?> value="<?php echo e($disc->id); ?>"><?php echo e($disc->nome); ?> (<?php if($disc->ensino=="fund"): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <label for="disciplina">Disciplina</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="ativo" name="ativo">
                            <option value="1">Sim</option>
                            <option value="0">Inativo</option>
                        </select>
                        <label for="ativo">Ativo</label>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filtrar</button>
                    </div>
                </form>
            </div>
            <br>
            <h5>Exibindo <?php echo e($profs->count()); ?> de <?php echo e($profs->total()); ?> de Professor(es) (<?php echo e($profs->firstItem()); ?> a <?php echo e($profs->lastItem()); ?>)</h5>
            <div class="table-responsive-xl">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Login</th>
                        <th>Disciplinas (clique para Turmas)</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $profs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($prof->id); ?></td>
                        <td><?php echo e($prof->name); ?></td>
                        <td><?php echo e($prof->email); ?></td>
                        <td>
                            <ul class="list-group">
                                <?php $__currentLoopData = $prof->disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disciplina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $qtdTurmas = 0;
                                        foreach($disciplina->turmas as $turma){
                                            foreach($profDiscs as $disc){
                                                foreach($profTurmas as $profTurma){
                                                    if($disc->disciplina_id==$disciplina->id && $disc->prof_id==$prof->id && $disc->id==$profTurma->prof_disciplina_id && $profTurma->turma_id==$turma->id){
                                                        $qtdTurmas++;   
                                                    } 
                                                }
                                            }
                                        }
                                    ?>
                                <?php if($disciplina->ativo==1): ?>
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" <?php if($disciplina->ativo==false): ?> style="color: red;" <?php endif; ?>><button type="button" class="btn btn-primary position-relative" data-placement="bottom" title="<?php echo e($qtdTurmas); ?> turmas vinculadas" data-bs-toggle="modal" data-bs-target="#modalTurmasProf<?php echo e($prof->id); ?>Disc<?php echo e($disciplina->id); ?>"><?php echo e($disciplina->nome); ?> (<?php if($disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo e($qtdTurmas); ?></span></button> <a href="/admin/prof/desvincularDisciplinaProf/<?php echo e($prof->id); ?>/<?php echo e($disciplina->id); ?>"><i class="material-icons red" data-toggle="tooltip" data-placement="bottom" title="Desvincular">remove_circle</i></a></li>
                                <!-- Modal Turmas-->
                                <div class="modal fade" id="modalTurmasProf<?php echo e($prof->id); ?>Disc<?php echo e($disciplina->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e($prof->name); ?> - <?php echo e($disciplina->nome); ?> (<?php if($disciplina->ensino=='fund'): ?> Fundamental <?php else: ?> Médio <?php endif; ?>)</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form-turmasProf<?php echo e($prof->id); ?>Disc<?php echo e($disciplina->id); ?>" action="/admin/prof/turmas" method="POST" style="text-align: center;">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <input type="hidden" name="prof" value="<?php echo e($prof->id); ?>">
                                                        <input type="hidden" name="disciplina" value="<?php echo e($disciplina->id); ?>">
                                                        <ul class="list-group">
                                                            <?php $__currentLoopData = $disciplina->turmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $turma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="list-group-item">
                                                                    <div class="form-group form-check">
                                                                        <input type="checkbox" class="form-check-input" id="turma<?php echo e($turma->id); ?>" name="turmas[]" value="<?php echo e($turma->id); ?>" 
                                                                        <?php $__currentLoopData = $profDiscs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php $__currentLoopData = $profTurmas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profTurma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php if($disc->disciplina_id==$disciplina->id && $disc->prof_id==$prof->id && $disc->id==$profTurma->prof_disciplina_id && $profTurma->turma_id==$turma->id): ?> checked <?php endif; ?>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        >
                                                                        <label class="form-check-label" for="turma<?php echo e($turma->id); ?>"><?php echo e($turma->serie); ?>º ANO <?php echo e($turma->turma); ?> (<?php if($turma->turno=='M'): ?> Matutino <?php else: ?> <?php if($turma->turno=='V'): ?> Vespertino <?php else: ?> Noturno <?php endif; ?> <?php endif; ?>)</label>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" form="form-turmasProf<?php echo e($prof->id); ?>Disc<?php echo e($disciplina->id); ?>" class="btn btn-primary">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                        <td>
                            <?php if($prof->ativo==1): ?>
                                <b><i class="material-icons green">check_circle</i></b>
                            <?php else: ?>
                                <b><i class="material-icons red">highlight_off</i></b>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="badge bg-warning" onclick="checksDisc(<?php echo e($prof->id); ?>);" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo e($prof->id); ?>" data-toggle="tooltip" data-placement="left" title="Editar">
                                <i class="material-icons md-18">edit</i>
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo e($prof->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edição de Professor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card-body">
                                            <form method="POST" action="/admin/prof/editar/<?php echo e($prof->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="col-12 form-floating">
                                                    <input id="name" type="text" class="form-control" name="name" value="<?php echo e($prof->name); ?>" required autocomplete="name" autofocus>
                                                    <label for="name">Nome</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="email" type="email" class="form-control" name="email" value="<?php echo e($prof->email); ?>" required autocomplete="email">
                                                    <label for="email">E-Mail</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="password" type="password" class="form-control" name="password" autocomplete="new-password">
                                                    <label for="password">Senha</label>
                                                </div>  
                                                <div class="col-12 form-floating">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                                    <label for="password-confirm">Confirmação Senha</label>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-outline-primary">Salvar</button>
                                                </div>
                                                <hr/>
                                                <div>
                                                    <h3>Disciplinas</h3>
                                                    <div class="col-12">
                                                        <label for="disciplina<?php echo e($prof->id); ?>">Nome da Disciplina</label>
                                                        <input id="disciplina<?php echo e($prof->id); ?>" chave="<?php echo e($prof->id); ?>" class="form-control" type="text" name="fazenda" placeholder="Digite o nome">
                                                    </div>
                                                    <ul class="list-group" id="listaDisciplinasChecked<?php echo e($prof->id); ?>">
                                                        <?php $__currentLoopData = $prof->disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item" id="disciplina<?php echo e($disc->id); ?>"><input type="checkbox" class="form-check-input me-1" name="disciplinas[]" value="<?php echo e($disc->id); ?>" checked>
                                                        <label class="form-check-label" for="disciplina<?php echo e($disc->id); ?>"><?php echo e($disc->nome); ?> <?php if($disc->ensino=="fund"): ?> (Fundamental) <?php else: ?> <?php endif; ?></label></li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                    <hr/>
                                                    <ul class="list-group" id="listaDisciplinas<?php echo e($prof->id); ?>">
                                                        
                                                    </ul>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <?php if($prof->ativo==1): ?>
                                <a href="/admin/prof/apagar/<?php echo e($prof->id); ?>" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Inativar"><i class="material-icons md-18 red">disabled_by_default</i></a>
                            <?php else: ?>
                                <a href="/admin/prof/apagar/<?php echo e($prof->id); ?>" class="badge bg-secondary" data-toggle="tooltip" data-placement="right" title="Ativar"><i class="material-icons md-18 green">check_box</i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="card-footer">
                <?php echo e($profs->links()); ?>

            </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cadastro de Professor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form method="POST" action="/admin/prof">
                        <?php echo csrf_field(); ?>
                        <div class="col-12 form-floating">
                            <input id="name" type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus placeholder="Nome">
                            <label for="name">Nome</label>
                        </div>
                        <div class="col-12 form-floating">
                            <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" placeholder="E-Mail">
                            <label for="email">E-Mail</label>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-12 form-floating">
                            <input id="senhaForca" onkeyup="validarSenhaForca()" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="new-password" placeholder="Senha">
                            <label for="password">Senha</label>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="fs-6 fst-italic">(Mínimo de 8 caracteres)</p>
                        </div>
                        <div class="col-12">
                            <div name="erroSenhaForca" id="erroSenhaForca"></div>
                            <label for="erroSenhaForca">Força Senha</label>
                        </div>
                        <div class="col-12 form-floating">
                            <input id="password-confirm" type="password" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmação Senha">
                            <label for="password-confirm">Confirmação Senha</label>
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                        </div>
                        <hr/>
                        <div>
                            <h3>Disciplinas</h3>
                            <div class="col-12">
                                <label for="disciplina0">Nome da Disciplina</label>
                                <input id="disciplina0" chave="0" class="form-control" type="text" name="disciplina" placeholder="Digite o nome">
                            </div>
                            <ul class="list-group" id="listaDisciplinasChecked0">
                                
                            </ul>
                            <hr/>
                            <ul class="list-group" id="listaDisciplinas0">
                                
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    <?php echo csrf_field(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ["current"=>"administrativo"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u302411308/domains/colegioliceu2.com.br/resources/views/admin/profs.blade.php ENDPATH**/ ?>