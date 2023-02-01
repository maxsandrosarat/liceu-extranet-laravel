<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <title>Extranet - Colégio Liceu II</title>
    <link rel="shortcut icon" href="/storage/favicon.png"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#00008B">
	<meta name="apple-mobile-web-app-status-bar-style" content="#00008B">
	<meta name="msapplication-navbutton-color" content="#00008B">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    
</head>
<body>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/public.js')); ?>"></script>
    <div class="container">
            <header>
                <?php $__env->startComponent('components.componente_navbar', ["current"=>$current ?? '']); ?>
                <?php echo $__env->renderComponent(); ?>
            </header>
            <main>
                <?php if (! empty(trim($__env->yieldContent('body')))): ?>
                    <?php echo $__env->yieldContent('body'); ?>   
                <?php endif; ?>
            </main>
            <?php $__env->startComponent('components.componente_footer'); ?>
            <?php echo $__env->renderComponent(); ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var qtdArq = 0;

        function addArquivo(){
            qtdArq += 1;
            s = "";
            s = '<li class="list-group-item"><input class="form-control" type="file" id="arquivo'+ qtdArq +'" name="arquivo'+ qtdArq +'"></li>'
            $('#arquivos').append(s);
            $('#qtdArq').val(qtdArq);
        }
        
        function enviar(){
            var prof = 0;
            var disciplina = 0;
            var turma = $('#turma').val();
            var data = $('#data').val();
            var descricao = $('#descricao').val();
            var arquivo = $('#arquivo0').val();
            if($("#prof").length>0){
                prof = $('#prof').val();
            }
            if($("#disciplina").length>0){
                disciplina = $('#disciplina').val();
            }
            if($("#prof").length==1 && prof==""){
                alert("Selecione um(a) professor(a)!");
                $('#prof').focus();
            } else if($("#disciplina").length==1 && disciplina==""){
                alert("Selecione uma disciplina!");
                $('#disciplina').focus();
            } else if(turma==""){
                alert("Selecione uma turma!");
                $('#turma').focus();
            } else if(data==""){
                alert("Selecione uma data!");
                $('#data').focus();
            } else if(descricao==""){
                alert("Preencha a descrição!");
                $('#descricao').focus();
            } else if(arquivo==""){
                alert("Inclua um arquivo!");
                $('#arquivo0').focus();
            } else {
                $('#nova-atividade').submit();
                qtdArq = 0;
            }
        }
        
        function id(campo){
            return document.getElementById(campo);
        }

        function validarSenhaForca(){
            var senha = document.getElementById('senhaForca').value;
            var forca = 0;
        
            if((senha.length >= 4) && (senha.length <= 8)){
                forca += 10;
            }else if(senha.length > 8){
                forca += 25;
            }
        
            if((senha.length >= 5) && (senha.match(/[a-z]+/))){
                forca += 10;
            }
        
            if((senha.length >= 6) && (senha.match(/[A-Z]+/))){
                forca += 20;
            }
        
            if((senha.length >= 7) && (senha.match(/[@#$%&;*]/))){
                forca += 25;
            }
        
            if(senha.match(/([1-9]+)\1{1,}/)){
                forca += -25;
            }
        
            mostrarForca(forca);
        }
        
        function mostrarForca(forca){
            if(forca < 30 ){
                document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div></div>';
            }else if((forca >= 30) && (forca < 50)){
                document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div></div>';
            }else if((forca >= 50) && (forca < 70)){
                document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>';
            }else if((forca >= 70) && (forca < 100)){
                document.getElementById("erroSenhaForca").innerHTML = '<div class="progress"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
            }
        }
        
        function processar(){
            $('#form-importar-excel').submit();
            $('#form-gerar-conteudo').submit();
            $('#form-relatorio').submit();
            document.getElementById("processamento").innerHTML = '<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Processando...</button>';
        }

        $('#form-relatorio').on("submit", function () {

                document.getElementById("processamento").innerHTML = '<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Processando...</button>';
            
        });


        $('#form-sim').on("submit", function (e) {
            var arr = $(this).serialize().toString();
            if(arr.indexOf("turmas") < 0){
                e.preventDefault();
                alert("Selecione pelo menos uma série");
            } else{
                document.getElementById("processamento").innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...';
            }
        });

        $(document).ready(function(){
            //OPÇÕES DE LOGIN
            $('#principal').children('div').hide();
            $('#tipoLogin').on('change', function(){
                
                var selectValor = '#'+$(this).val();
                $('#principal').children('div').hide();
                $('#principal').children(selectValor).show();

            });

            //OPÇÕES DE RECADOS
            $('#principalSelect').children('div').hide();
            $('#selectGeral').on('change', function(){
                
                var selectValorGeral = '#'+$(this).val();
                $('#principalSelect').children('div').hide();
                $('#principalSelect').children(selectValorGeral).show();

            });

        });

        function formataNumeroTelefone() {
            var numero = document.getElementById('telefone').value;
            var length = numero.length;
            var telefoneFormatado;
            
            if (length == 10) {
            telefoneFormatado = '(' + numero.substring(0, 2) + ') ' + numero.substring(2, 6) + '-' + numero.substring(6, 10);
            } else if (length == 11) {
            telefoneFormatado = '(' + numero.substring(0, 2) + ') ' + numero.substring(2, 7) + '-' + numero.substring(7, 11);
            } else {
                telefoneFormatado = 'Número Inválido, digite número com DDD';
            }
            id('telefone').value = telefoneFormatado;
        }

        function mostrarSenha(){
            if($("#floatingPassword").attr('type')=="password"){
                $("#floatingPassword").attr('type', "text");
                $("#icone-senha").html("visibility_off");
                $("#botao-senha").removeClass();
                $("#botao-senha").addClass("badge bg-warning rounded-pill");
                $("#botao-senha").attr('title', "Ocultar Senha");
            } else {
                $("#floatingPassword").attr('type', "password");
                $("#icone-senha").html("visibility");
                $("#botao-senha").removeClass();
                $("#botao-senha").addClass("badge bg-success rounded-pill");
                $("#botao-senha").attr('title', "Mostrar Senha");
            }
        }

        function mostrarSenhaProf(){
            if($("#floatingPasswordProf").attr('type')=="password"){
                $("#floatingPasswordProf").attr('type', "text");
                $("#icone-senha-prof").html("visibility_off");
                $("#botao-senha-prof").removeClass();
                $("#botao-senha-prof").addClass("badge bg-warning rounded-pill");
                $("#botao-senha-prof").attr('title', "Ocultar Senha");
            } else {
                $("#floatingPasswordProf").attr('type', "password");
                $("#icone-senha-prof").html("visibility");
                $("#botao-senha-prof").removeClass();
                $("#botao-senha-prof").addClass("badge bg-success rounded-pill");
                $("#botao-senha-prof").attr('title', "Mostrar Senha");
            }
        }

        function mostrarSenhaAdmin(){
            if($("#floatingPasswordAdmin").attr('type')=="password"){
                $("#floatingPasswordAdmin").attr('type', "text");
                $("#icone-senha-admin").html("visibility_off");
                $("#botao-senha-admin").removeClass();
                $("#botao-senha-admin").addClass("badge bg-warning rounded-pill");
                $("#botao-senha-admin").attr('title', "Ocultar Senha");
            } else {
                $("#floatingPasswordAdmin").attr('type', "password");
                $("#icone-senha-admin").html("visibility");
                $("#botao-senha-admin").removeClass();
                $("#botao-senha-admin").addClass("badge bg-success rounded-pill");
                $("#botao-senha-admin").attr('title', "Mostrar Senha");
            }
        }

        function adicionarProduto(){
            var prod = $('#input-prodEx').val();
            s = "";
            s = '<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">' +
                    '<input type="checkbox" checked class="form-check-input" name="produtosExtras[]" value="'+ prod +'">' +
                    '<label class="form-check-label">'+ prod +'</label>' +
                    '<span class="badge badge-primary badge-pill">0</span>' +
                '</li>'

            $('#lista-produtos').append(s);
            $('#input-prodEx').val("");
        }

        $(document).on('change', '#disciplina', function(){
            var prof = $('input[name="prof"]').attr("value");
            var disc = this.value;
            if(disc=='' || disc==null){
                $('#turma>option').remove();
                s = "";
                s = '<option value="">Selecione a disciplina</option>'
                $('#turma').append(s);
            } else {
                $.get("/turmas",{disc: disc, prof: prof},function (data) {
                    $('#turma>option').remove();
                    s = "";
                    s = '<option value="">Selecione</option>'
                    $('#turma').append(s);
                    for(i=0; i<data.length; i++){
                        s = "";
                        s = '<option value="' + data[i].id + '">' + data[i].serie + 'º ANO ' + data[i].turma + '</option>'
                        $('#turma').append(s);
                    }
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\liceu-extranet-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>