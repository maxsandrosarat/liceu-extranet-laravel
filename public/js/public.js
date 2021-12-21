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
    document.getElementById("processamento").innerHTML = '<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Processando...</button>';
}


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
    var tipo = document.getElementById("senha");
    if(tipo.type=="password"){
        tipo.type = "text";
        id('icone-senha').innerHTML = "visibility_off";
        id('botao-senha').className = "btn btn-warning btn-sm";
        id('botao-senha').title = "Ocultar Senha";
    } else {
        tipo.type = "password";
        id('icone-senha').innerHTML = "visibility";
        id('botao-senha').className = "btn btn-success btn-sm";
        id('botao-senha').title = "Exibir Senha";
    }
}

function mostrarSenhaProf(){
    var tipo = document.getElementById("senha-prof");
    if(tipo.type=="password"){
        tipo.type = "text";
        id('icone-senha-prof').innerHTML = "visibility_off";
        id('botao-senha-prof').className = "btn btn-warning btn-sm";
        id('botao-senha-prof').title = "Ocultar Senha";
    } else {
        tipo.type = "password";
        id('icone-senha-prof').innerHTML = "visibility";
        id('botao-senha-prof').className = "btn btn-success btn-sm";
        id('botao-senha-prof').title = "Exibir Senha";
    }
}

function mostrarSenhaAdmin(){
    var tipo = document.getElementById("senha-admin");
    if(tipo.type=="password"){
        tipo.type = "text";
        id('icone-senha-admin').innerHTML = "visibility_off";
        id('botao-senha-admin').className = "btn btn-warning btn-sm";
        id('botao-senha-admin').title = "Ocultar Senha";
    } else {
        tipo.type = "password";
        id('icone-senha-admin').innerHTML = "visibility";
        id('botao-senha-admin').className = "btn btn-success btn-sm";
        id('botao-senha-admin').title = "Exibir Senha";
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

function checksDisc(id){
    console.log(id);
    $('#disciplina'+ id +'').keyup(function(){
        var busca = $('#disciplina'+ id + '').val();
        console.log(busca);
        if(busca!=""){
            $.post("/admin/disciplinas/busca",{busca: busca,_token:$('input[name="_token"]').attr("value")},function (data) {
                $('#listaDisciplinas'+ id + '>li').remove();
                console.log(data);
                for(i=0; i<data.length; i++){
                    s = "";
                    if(data[i].ativo===1){
                        if(data[i].ensino==="fund"){
                        s = '<li class="list-group-item" id="disciplina'+ data[i].id + '"><input type="checkbox" class="form-check-input" id="disciplina'+ data[i].id + '" name="disciplinas[]" value="'+ data[i].id +'">' +
                            '<label class="form-check-label" for="disciplina'+ data[i].id + '">' + data[i].nome + ' (Fundamental)</label></li>'
                        } else {
                        s = '<li class="list-group-item" id="disciplina'+ data[i].id + '"><input type="checkbox" class="form-check-input" id="disciplina'+ data[i].id + '" name="disciplinas[]" value="'+ data[i].id +'">' +
                            '<label class="form-check-label" for="disciplina'+ data[i].id + '">' + data[i].nome + ' (Médio)</label></li>'
                        }
                        $('#listaDisciplinas'+ id +'').append(s);
                    }
                }
            });
        } else{
            $('#listaDisciplinas'+ id +'>li').remove();
        }
    });

    $(document).on('change', 'input[type=checkbox]', function(){
        if(this.checked) {
            var valor = this.value;
            $.post("/admin/disciplinas/checked",{id: valor,_token:$('input[name="_token"]').attr("value")},function (data) {
                    s = "";
                    if(data.ativo==1){
                        if(data.ensino==="fund"){
                        s = '<li class="list-group-item" id="disciplina'+ data.id + '"><input type="checkbox" class="form-check-input me-1" id="disciplina'+ data.id + '" name="disciplinas[]" value="'+ data.id +'" checked>' +
                            '<label class="form-check-label" for="disciplina'+ data.id + '">' + data.nome + ' (Fundamental)</label></li>'
                        } else {
                        s = '<li class="list-group-item" id="disciplina'+ data.id + '"><input type="checkbox" class="form-check-input me-1" id="disciplina'+ data.id + '" name="disciplinas[]" value="'+ data.id +'" checked>' +
                            '<label class="form-check-label" for="disciplina'+ data.id + '">' + data.nome + ' (Médio)</label></li>'
                        }
                        $('#listaDisciplinas'+ id +' #disciplina'+ data.id +'').remove();
                        var elem = document.querySelector('#listaDisciplinasChecked'+ id +'>li #disciplina'+ data.id +'');
                        if (elem) {
                            console.log("Elemento encontrado");
                        } else {
                            $('#listaDisciplinasChecked'+ id +'').append(s);
                        }
                    }
            });
        } else {
            $('#listaDisciplinasChecked'+ id +' #disciplina'+ this.value +'').remove();
        }
    });
}