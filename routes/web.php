<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/turmas', 'JSController@turmas');

//ADMIN
Route::group(['prefix' => 'admin'], function() {
    Route::get('/login', 'Auth\AdminLoginController@index')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/', 'AdminController@index')->name('admin.dashboard');
    Route::get('/novo', 'AdminController@cadastroAdmin');
    Route::post('/', 'AdminController@novoAdmin');

    Route::get('/estoque', function () { return view('admin.home_estoque'); })->middleware('auth:admin');
    Route::get('/administrativo', function () { return view('admin.home_administrativo'); })->middleware('auth:admin');
    Route::get('/pedagogico', function () { return view('admin.home_pedagogico'); })->middleware('auth:admin');

    Route::group(['prefix' => 'disciplinas'], function() {
        Route::get('/', 'AdminController@indexDisciplinas');
        Route::post('/', 'AdminController@novaDisciplina');
        Route::get('/apagar/{id}', 'AdminController@apagarDisciplina');
        Route::post('/busca', 'AdminController@buscarDisciplina');
        Route::post('/checked', 'AdminController@selecionarDisciplina');
    });
    
    Route::group(['prefix' => 'turmas'], function() {
        Route::get('/', 'AdminController@indexTurmas');
        Route::post('/', 'AdminController@novaTurma');
        Route::get('/apagar/{id}', 'AdminController@apagarTurma');
        Route::post('/busca', 'AdminController@buscarTurmas');
        Route::post('/disciplinas', 'AdminController@turmasDisciplinas');
    });

    Route::group(['prefix' => 'turmasDiscs'], function() {
        Route::get('/', 'AdminController@indexTurmaDiscs');
        Route::post('/', 'AdminController@novaTurmaDisc');
        Route::get('/apagar/{t}/{d}', 'AdminController@apagarTurmaDisc');
    });
    
    Route::group(['prefix' => 'tiposOcorrencias'], function() {
        Route::get('/', 'AdminController@indexTiposOcorrencia');
        Route::post('/', 'AdminController@novoTipoOcorrencia');
        Route::post('/editar/{id}', 'AdminController@editarTipoOcorrencia');
        Route::get('/apagar/{id}', 'AdminController@apagarTipoOcorrencia');
    });
    
    Route::get('/templates/download/{nome}', 'AdminController@templates');
    
    Route::group(['prefix' => 'prof'], function() {
        Route::get('/', 'AdminController@indexProfs');
        Route::post('/', 'AdminController@novoProf');
        Route::get('/filtro', 'AdminController@filtroProfs');
        Route::post('/editar/{id}', 'AdminController@editarProf');
        Route::get('/apagar/{id}', 'AdminController@apagarProf');
        Route::get('/desvincularDisciplinaProf/{p}/{d}', 'AdminController@desvincularDisciplinaProf');
        Route::post('/turmas', 'AdminController@turmasProf');
    });
    
    Route::group(['prefix' => 'aluno'], function() {
        Route::get('/', 'AdminController@indexAlunos');
        Route::post('/', 'AdminController@novoAluno');
        Route::get('/filtro', 'AdminController@filtroAluno');
        Route::post('/editar/{id}', 'AdminController@editarAluno');
        Route::get('/apagar/{id}', 'AdminController@apagarAluno');
        Route::post('/importarExcel', 'AdminController@importarAlunoExcel');
        Route::get('/exportarExcel', 'AdminController@exportarAlunoExcel');
        Route::get('/exportarExcelView', 'AdminController@exportarAlunoExcelView');
    });

    Route::group(['prefix' => 'responsavel'], function() {
        Route::get('/', 'AdminController@indexResps');
        Route::post('/', 'AdminController@novoResp');
        Route::get('/filtro', 'AdminController@filtroResps');
        Route::post('/editar/{id}', 'AdminController@editarResp');
        Route::get('/apagar/{id}', 'AdminController@apagarResp');
        Route::post('/vincular/{id}', 'AdminController@vincularAlunoResp');
        Route::get('/desvincular/{r}/{a}', 'AdminController@desvincularAlunoResp');
    });
    
    Route::group(['prefix' => 'colaborador'], function() {
        Route::get('/', 'AdminController@indexOutros');
        Route::post('/', 'AdminController@novoOutro');
        Route::get('/filtro', 'AdminController@filtroOutros');
        Route::post('/editar/{id}', 'AdminController@editarOutro');
        Route::get('/apagar/{id}', 'AdminController@apagarOutro');
        Route::post('/importarExcel', 'AdminController@importarOutroExcel');
    });

    Route::group(['prefix' => 'categorias'], function() {
        Route::get('/', 'AdminController@indexCategorias');
        Route::post('/', 'AdminController@novaCategoria');
        Route::post('/editar/{id}', 'AdminController@editarCategoria');
        Route::get('/apagar/{id}', 'AdminController@apagarCategoria');
    });

    Route::group(['prefix' => 'produtos'], function() {
        Route::get('/', 'AdminController@indexProdutos');
        Route::post('/', 'AdminController@novoProduto');
        Route::get('/filtro', 'AdminController@filtroProdutos');
        Route::post('/editar/{id}', 'AdminController@editarProduto');
        Route::get('/apagar/{id}', 'AdminController@apagarProduto');
    });
    
    Route::group(['prefix' => 'entradaSaida'], function() {
        Route::get('/', 'AdminController@indexEntradaSaidas');
        Route::post('/', 'AdminController@novaEntradaSaida');
        Route::get('/filtro', 'AdminController@filtroEntradaSaidas');
    });
    
    Route::group(['prefix' => 'listaCompras'], function() {
        Route::get('/', 'AdminController@indexListaCompras');
        Route::post('/', 'AdminController@novaListaCompra');
        Route::get('/nova', 'AdminController@selecionarListaCompra');
        Route::get('/pdf/{id}', 'AdminController@gerarPdfListaCompra');
        Route::get('/apagar/{id}', 'AdminController@apagarListaCompra');
        Route::get('/removerItem/{p}/{d}', 'AdminController@removerItem');
        Route::get('/removerItemExtra/{p}/{d}', 'AdminController@removerItemExtra');
    });
    
    Route::group(['prefix' => 'atividade'], function() {
        Route::get('/', 'AdminController@painelAtividades');
        Route::post('/', 'AdminController@novaAtividade');
        Route::get('/filtro', 'AdminController@filtroAtividade');
        Route::post('/editar/{id}', 'AdminController@editarAtividade');
        Route::get('/apagar/{id}', 'AdminController@apagarAtividade');
        Route::get('/download/{id}', 'AdminController@downloadAtividade');
        Route::get('/retornos/{id}', 'AdminController@retornos');
        Route::get('/retorno/download/{id}', 'AdminController@downloadRetorno');
    });

    Route::group(['prefix' => 'atividadeDiaria'], function() {
        Route::get('/{t}', 'AdminController@painelAtividadesDiarias');
        Route::post('/', 'AdminController@novaAtividadeDiaria');
        Route::get('/filtro', 'AdminController@filtroAtividadeDiaria');
        Route::post('/editar/{id}', 'AdminController@editarAtividadeDiaria');
        Route::get('/apagar/{id}', 'AdminController@apagarAtividadeDiaria');
        Route::get('/download/{id}', 'AdminController@downloadAtividadeDiaria');
        Route::get('/impresso/{id}', 'AdminController@imprimirAtividadeDiaria');
    });

    Route::group(['prefix' => 'atividadeComplementar'], function() {
        Route::get('/{a}', 'AdminController@indexAtividadesComplementaresAno');
        Route::get('/', 'AdminController@indexAtividadesComplementares');
        Route::post('/', 'AdminController@novaAtividadeComplementar');
        Route::post('/editar/{id}', 'AdminController@editarAtividadeComplementar');
        Route::get('/painel/{id}', 'AdminController@painelAtividadesComplementares');
        Route::post('/anexar/{id}', 'AdminController@anexarAtividadeComplementar');
        Route::get('/download/{id}', 'AdminController@downloadAtividadeComplementar');
        Route::get('/apagar/{id}', 'AdminController@apagarAtividadeComplementar');
        Route::get('/impresso/{id}', 'AdminController@imprimirAtividadeComplementar');
    });
    
    Route::group(['prefix' => 'listaAtividade'], function() {
        Route::get('/{ano}', 'AdminController@indexLAsAno');
        Route::get('/', 'AdminController@indexLAs');
        Route::post('/', 'AdminController@novaLA');
        Route::get('/painel/{data}', 'AdminController@painelLAs');
        Route::post('/anexar/{id}', 'AdminController@anexarLA');
        Route::get('/download/{id}', 'AdminController@downloadLA');
        Route::get('/apagar/{id}', 'AdminController@apagarLA');
    });

    Route::group(['prefix' => 'diario'], function() {
        Route::get('/', 'AdminController@indexDiario');
        Route::get('/consulta', 'AdminController@consultaDiario');
        Route::post('/editar/{id}', 'AdminController@editarDiario');
        Route::get('/conferido/{id}', 'AdminController@conferirDiario');
        Route::get('/apagar/{id}', 'AdminController@apagarDiario');
		Route::get('/relatorio', 'AdminController@relatorioDiario');
        Route::post('/relatorio', 'AdminController@relatorioTurma');
    });
    
    Route::group(['prefix' => 'ocorrencias'], function() {
        Route::get('/', 'AdminController@indexOcorrencias');
        Route::get('/filtro', 'AdminController@filtroOcorrencias');
        Route::post('/editar/{id}', 'AdminController@editarOcorrencia');
        Route::get('/aprovar/{id}', 'AdminController@aprovarOcorrencia');
        Route::get('/reprovar/{id}', 'AdminController@reprovarOcorrencia');
        Route::get('/apagar/{id}', 'AdminController@apagarOcorrencia');
    });

    Route::group(['prefix' => 'conteudos'], function() {
        Route::get('/{a}', 'AdminController@indexConteudosAno');
        Route::get('/', 'AdminController@indexConteudos');
        Route::get('/painel/{a}/{b}/{t}', 'AdminController@painelConteudos');
        Route::post('/gerar', 'AdminController@gerarConteudos');
        Route::post('/anexar/{id}', 'AdminController@anexarConteudo');
        Route::get('/download/{id}', 'AdminController@downloadConteudo');
        Route::get('/apagar/{id}', 'AdminController@apagarConteudo');
    });

    Route::group(['prefix' => 'conteudosProvas'], function() {
        Route::get('/painel/{id}', 'AdminController@painelConteudoProvas');
        Route::post('/gerar', 'AdminController@gerarConteudoProvas');
        Route::post('/anexar/{id}', 'AdminController@anexarConteudoProva');
        Route::get('/download/{id}', 'AdminController@downloadConteudoProva');
        Route::get('/apagar/{id}', 'AdminController@apagarConteudoProva');
        Route::post('/conferir', 'AdminController@conferirConteudoProva');
        Route::post('/pdf/{prova}/{turma}', 'AdminController@gerarPdfConteudo');
    });
    
    Route::group(['prefix' => 'recados'], function() {
        Route::get('/', 'AdminController@indexRecados');
        Route::post('/', 'AdminController@novoRecado');
        Route::get('/filtro', 'AdminController@filtroRecados');
        Route::post('/editar/{id}', 'AdminController@editarRecado');
        Route::get('/apagar/{id}', 'AdminController@apagarRecado');
    });

    Route::group(['prefix' => 'atividadeExtra'], function() {
        Route::get('/', function () { return view('admin.home_aes'); })->middleware('auth:admin');
        Route::get('/{a}/{b}/{t}', 'AdminController@painelAEs');
        Route::post('/gerar', 'AdminController@gerarAEs');
        Route::post('/anexar/{id}', 'AdminController@anexarAE');
        Route::get('/download/{id}', 'AdminController@downloadAE');
        Route::get('/apagar/{id}', 'AdminController@apagarAE');
    });

    Route::group(['prefix' => 'provas'], function() {
        Route::get('/{a}', 'AdminController@indexSimuladosAno');
        Route::get('/', 'AdminController@indexSimulados');
        Route::get('/painel/{id}', 'AdminController@painelSimulados');
        Route::post('/gerar', 'AdminController@gerarSimulados');
        Route::post('/editar/{id}', 'AdminController@editarSimulado');
        Route::post('/anexar/{id}', 'AdminController@anexarSimulado');
        Route::get('/download/{id}', 'AdminController@downloadSimulado');
        Route::get('/apagar/{id}', 'AdminController@apagarSimulado');
        Route::post('/conferir', 'AdminController@conferirSimulado');
    });

    Route::group(['prefix' => 'notas'], function() {
        Route::get('/{a}', 'AdminController@indexNotasAno');
        Route::get('/', 'AdminController@indexNotas');
        Route::post('/gerar', 'AdminController@gerarNotas');
        Route::post('/editar/{id}', 'AdminController@editarNota');
        Route::get('/apagar/{id}', 'AdminController@apagarNota');
        Route::get('/painel/{n}/{t}', 'AdminController@painelNotas');
        Route::post('/lancar/{id}', 'AdminController@lancarNota');
        Route::get('/zerar/{id}', 'AdminController@zerarNota');
        Route::post('/pdf/{n}/{t}', 'AdminController@gerarPdfNota');
    });

    Route::group(['prefix' => 'planejamentos'], function() {
        Route::get('/{a}', 'AdminController@indexPlanejamentosAno');
        Route::get('/', 'AdminController@indexPlanejamentos');
        Route::get('/painel/{id}', 'AdminController@painelPlanejamentos');
        Route::post('/gerar', 'AdminController@gerarPlanejamentos');
        Route::post('/anexar/{id}', 'AdminController@anexarPlanejamento');
        Route::get('/download/{id}', 'AdminController@downloadPlanejamento');
        Route::get('/apagar/{id}', 'AdminController@apagarPlanejamento');
        Route::get('/apagarAnexo/{id}', 'AdminController@apagarAnexoPlanejamento');
        Route::post('/conferir', 'AdminController@conferirPlanejamento');
    });

    Route::group(['prefix' => 'documentos'], function() {
        Route::get('/', 'AdminController@painelDocumentos');
        Route::post('/', 'AdminController@novoDocumento');
        Route::get('/filtro', 'AdminController@filtroDocumento');
        Route::post('/editar/{id}', 'AdminController@editarDocumento');
        Route::get('/apagar/{id}', 'AdminController@apagarDocumento');
        Route::get('/download/{id}', 'AdminController@downloadDocumento');
    });

    Route::group(['prefix' => 'lembretes'], function() {
        Route::get('/', 'AdminController@painelLembretes');
        Route::post('/', 'AdminController@novoLembrete');
        Route::get('/filtro', 'AdminController@filtroLembrete');
        Route::post('/editar/{id}', 'AdminController@editarLembrete');
        Route::get('/apagar/{id}', 'AdminController@apagarLembrete');
    });
});

//PROF
Route::group(['prefix' => 'prof'], function() {
    Route::get('/login', 'Auth\ProfLoginController@index')->name('prof.login');
    Route::post('/login', 'Auth\ProfLoginController@login')->name('prof.login.submit');
    Route::get('/', 'ProfController@index')->name('prof.dashboard')->middleware('auth:prof');

    Route::get('/templates/download/{nome}', 'ProfController@templates');

    Route::group(['prefix' => 'atividade'], function() {
        Route::get('/disciplinas', 'ProfController@disciplinasAtividades');
        Route::get('/{id}', 'ProfController@painelAtividades');
        Route::post('/', 'ProfController@novaAtividade');
        Route::get('/filtro/{id}', 'ProfController@filtroAtividades');
        Route::get('/download/{id}', 'ProfController@downloadAtividade');
        Route::post('/editar/{id}', 'ProfController@editarAtividade');
        Route::get('/apagar/{id}', 'ProfController@apagarAtividade');
        Route::get('/retornos/{id}', 'ProfController@retornos');
        Route::get('/retorno/download/{id}', 'ProfController@downloadRetorno');
    });

    Route::group(['prefix' => 'atividadeDiaria'], function() {
        Route::get('/disciplinas/{t}', 'ProfController@disciplinasAtividadesDiarias');
        Route::get('/{id}/{t}', 'ProfController@painelAtividadesDiarias');
        Route::post('/', 'ProfController@novaAtividadeDiaria');
        Route::get('/filtro/{id}', 'ProfController@filtroAtividadeDiaria');
        Route::post('/editar/{id}', 'ProfController@editarAtividadeDiaria');
        Route::get('/apagar/{id}', 'ProfController@apagarAtividadeDiaria');
        Route::get('/download/{id}', 'ProfController@downloadAtividadeDiaria');
    });

    Route::group(['prefix' => 'atividadeComplementar'], function() {
        Route::get('/{a}', 'ProfController@indexAtividadesComplementaresAno');
        Route::get('/', 'ProfController@indexAtividadesComplementares');
        Route::get('/painel/{id}', 'ProfController@painelAtividadesComplementares');
        Route::post('/anexar/{id}', 'ProfController@anexarAtividadeComplementar');
        Route::get('/download/{id}', 'ProfController@downloadAtividadeComplementar');
        Route::get('/apagar/{id}', 'ProfController@apagarAtividadeComplementar');
    });

    Route::group(['prefix' => 'listaAtividade'], function() {
        Route::get('/{ano}', 'ProfController@indexLAsAno');
        Route::get('/', 'ProfController@indexLAs');
        Route::get('/painel/{data}', 'ProfController@painelListaAtividades');
        Route::post('/anexar/{id}', 'ProfController@anexarListaAtividade');
        Route::get('/download/{id}', 'ProfController@downloadListaAtividade');
        Route::get('/apagar/{id}', 'ProfController@apagarListaAtividade');
    });
    
    Route::group(['prefix' => 'ocorrencias'], function() {
        Route::get('/disciplinas', 'ProfController@disciplinasOcorrencias');
        Route::get('/{id}', 'ProfController@turmasOcorrencias');
        Route::get('/{disc}/{turma}', 'ProfController@indexOcorrencias');
        Route::post('/', 'ProfController@novasOcorrencias');
        Route::get('/filtro/{disc}/{turma}', 'ProfController@filtroOcorrencias');
        Route::post('/editar/{id}', 'ProfController@editarOcorrencia');
        Route::post('/apagar/{id}', 'ProfController@apagarOcorrencia');
    });
    
    Route::group(['prefix' => 'conteudos'], function() {
        Route::get('/', 'ProfController@painelConteudos');
        Route::get('/{a}', 'ProfController@painelConteudosAno');
        Route::get('/painel/{a}/{b}/{t}', 'ProfController@conteudos');
        Route::post('/anexar/{id}', 'ProfController@anexarConteudo');
        Route::get('/download/{id}', 'ProfController@downloadConteudo');
        Route::get('/apagar/{id}', 'ProfController@apagarConteudo');
    });

    Route::group(['prefix' => 'conteudosProvas'], function() {
        Route::get('/{a}', 'ProfController@indexConteudoProvasAno');
        Route::get('/', 'ProfController@indexConteudoProvas');
        Route::get('/painel/{id}', 'ProfController@painelConteudoProvas');
        Route::post('/anexar/{id}', 'ProfController@anexarConteudoProva');
        Route::get('/download/{id}', 'ProfController@downloadConteudoProva');
        Route::get('/apagar/{id}', 'ProfController@apagarConteudoProva');
    });

    Route::group(['prefix' => 'diario'], function() {
        Route::get('/disciplinas', 'ProfController@disciplinasDiario');
        Route::get('/{disc}', 'ProfController@turmasDiario');
        Route::get('/{disc}/{turma}', 'ProfController@diaDiario');
        Route::get('/', 'ProfController@indexDiario');
        Route::post('/', 'ProfController@editarDiario');
        Route::post('/apagar', 'ProfController@apagarDiario');
    });

    Route::group(['prefix' => 'provas'], function() {
        Route::get('/{a}', 'ProfController@indexSimuladosAno');
        Route::get('/', 'ProfController@indexSimulados');
        Route::get('/painel/{id}', 'ProfController@painelSimulados');
        Route::post('/anexar/{id}', 'ProfController@anexarSimulado');
        Route::get('/download/{id}', 'ProfController@downloadSimulado');
        Route::get('/apagar/{id}', 'ProfController@apagarSimulado');
    });

    Route::group(['prefix' => 'notas'], function() {
        Route::get('/{a}', 'ProfController@indexNotasAno');
        Route::get('/', 'ProfController@indexNotas');
        Route::get('/painel/{n}/{t}', 'ProfController@painelNotas');
        Route::post('/lancar/{id}', 'ProfController@lancarNota');
        Route::get('/zerar/{id}', 'ProfController@zerarNota');
    });

    Route::group(['prefix' => 'planejamentos'], function() {
        Route::get('/{a}', 'ProfController@indexPlanejamentosAno');
        Route::get('/', 'ProfController@indexPlanejamentos');
        Route::get('/painel/{id}', 'ProfController@painelPlanejamentos');
        Route::post('/anexar/{id}', 'ProfController@anexarPlanejamento');
        Route::get('/download/{id}', 'ProfController@downloadPlanejamento');
    });
});

//ALUNO
Route::group(['prefix' => 'aluno'], function() {
    Route::get('/login', 'Auth\AlunoLoginController@index')->name('aluno.login');
    Route::post('/login', 'Auth\AlunoLoginController@login')->name('aluno.login.submit');
    Route::get('/', 'AlunoController@index')->name('aluno.dashboard');
    
    Route::group(['prefix' => 'atividade'], function() {
        Route::get('/disciplinas', 'AlunoController@disciplinasAtividades');
        Route::get('/{d}', 'AlunoController@painelAtividades');
        Route::get('/filtro/{id}', 'AlunoController@filtroAtividades');
        Route::get('/download/{id}', 'AlunoController@downloadAtividade');
        Route::post('/retorno/{id}', 'AlunoController@retornoAtividade');
        Route::post('/retorno/editar/{id}', 'AlunoController@editarRetornoAtividade');
    });

    Route::group(['prefix' => 'conteudos'], function() {
        Route::get('/{a}', 'AlunoController@indexConteudos');
        Route::get('/painel/{a}/{b}/{t}', 'AlunoController@painelConteudos');
        Route::get('/download/{id}', 'AlunoController@downloadConteudo');
    });
});

//RESPONSAVEL
Route::group(['prefix' => 'responsavel'], function() {
    Route::get('/login', 'Auth\ResponsavelLoginController@index')->name('responsavel.login');
    Route::post('/login', 'Auth\ResponsavelLoginController@login')->name('responsavel.login.submit');
    Route::get('/', 'ResponsavelController@index')->name('responsavel.dashboard')->middleware('auth:responsavel');
    Route::get('/ocorrencias', 'ResponsavelController@ocorrencias')->middleware('auth:responsavel');
    Route::get('/ocorrencias/ciente/{id}', 'ResponsavelController@cienteOcorrencia')->middleware('auth:responsavel');
    Route::get('/recados', 'ResponsavelController@recados')->middleware('auth:responsavel');
});

//OUTRO
Route::group(['prefix' => 'outro'], function() {
    Route::get('/login', 'Auth\OutroLoginController@index')->name('outro.login');
    Route::post('/login', 'Auth\OutroLoginController@login')->name('outro.login.submit');
    Route::get('/', 'OutroController@index')->name('outro.dashboard');
    Route::get('/estoque', function () { return view('outros.home_estoque'); })->middleware('auth:outro');
    Route::get('/pedagogico', function () { return view('outros.home_pedagogico'); })->middleware('auth:outro');

    Route::group(['prefix' => 'categorias'], function() {
        Route::get('/', 'OutroController@indexCategorias');
        Route::post('/', 'OutroController@novaCategoria');
        Route::post('/editar/{id}', 'OutroController@editarCategoria');
        Route::get('/apagar/{id}', 'OutroController@apagarCategoria');
    });

    Route::group(['prefix' => 'produtos'], function() {
        Route::get('/', 'OutroController@indexProdutos');
        Route::post('/', 'OutroController@novoProduto');
        Route::get('/filtro', 'OutroController@filtroProdutos');
        Route::post('/editar/{id}', 'OutroController@editarProduto');
        Route::get('/apagar/{id}', 'OutroController@apagarProduto');
    });
    
    Route::group(['prefix' => 'entradaSaida'], function() {
        Route::get('/', 'OutroController@indexEntradaSaidas');
        Route::post('/', 'OutroController@novaEntradaSaida');
        Route::get('/filtro', 'OutroController@filtroEntradaSaidas');
    });
    
    Route::group(['prefix' => 'listaCompras'], function() {
        Route::get('/', 'OutroController@indexListaCompras');
        Route::post('/', 'OutroController@novaListaCompra');
        Route::get('/nova', 'OutroController@selecionarListaCompra');
        Route::get('/pdf/{id}', 'OutroController@gerarPdfListaCompra');
        Route::get('/removerItem/{p}/{d}', 'OutroController@removerItem');
        Route::get('/removerItemExtra/{p}/{d}', 'OutroController@removerItemExtra');
    });

    Route::group(['prefix' => 'diario'], function() {
        Route::get('/', 'OutroController@indexDiario');
        Route::get('/consulta', 'OutroController@consultaDiario');
        Route::get('/relatorio', 'OutroController@relatorioDiario');
        Route::post('/relatorio', 'OutroController@relatorioTurma');
    });


    Route::group(['prefix' => 'provas'], function() {
        Route::get('/{a}', 'OutroController@indexSimuladosAno');
        Route::get('/', 'OutroController@indexSimulados');
        Route::get('/painel/{id}', 'OutroController@painelSimulados');
        Route::get('/download/{id}', 'OutroController@downloadSimulado');
        Route::post('/conferir', 'OutroController@conferirSimulado');
    });

    Route::group(['prefix' => 'notas'], function() {
        Route::get('/{a}', 'OutroController@indexNotasAno');
        Route::get('/', 'OutroController@indexNotas');
        Route::get('/painel/{n}/{t}', 'OutroController@painelNotas');
    });

    Route::group(['prefix' => 'conteudosProvas'], function() {
        Route::get('/painel/{id}', 'OutroController@painelConteudoProvas');
        Route::post('/pdf/{prova}/{serie}', 'OutroController@gerarPdfConteudo');
    });

    Route::group(['prefix' => 'documentos'], function() {
        Route::get('/', 'OutroController@painelDocumentos');
        Route::get('/filtro', 'OutroController@filtroDocumento');
        Route::get('/download/{id}', 'OutroController@downloadDocumento');
    });

    Route::group(['prefix' => 'lembretes'], function() {
        Route::get('/', 'OutroController@painelLembretes');
        Route::get('/filtro', 'OutroController@filtroLembrete');
    });

    Route::group(['prefix' => 'atividadeComplementar'], function() {
        Route::get('/{a}', 'OutroController@indexAtividadesComplementaresAno');
        Route::get('/', 'OutroController@indexAtividadesComplementares');
        Route::get('/painel/{id}', 'OutroController@painelAtividadesComplementares');
        Route::get('/download/{id}', 'OutroController@downloadAtividadeComplementar');
        Route::get('/impresso/{id}', 'OutroController@imprimirAtividadeComplementar');
    });

    Route::group(['prefix' => 'atividadeDiaria'], function() {
        Route::get('/{t}', 'OutroController@painelAtividadesDiarias');
        Route::get('/filtro', 'OutroController@filtroAtividadeDiaria');
        Route::get('/download/{id}', 'OutroController@downloadAtividadeDiaria');
        Route::get('/impresso/{id}', 'OutroController@imprimirAtividadeDiaria');
    });

    Route::group(['prefix' => 'planejamentos'], function() {
        Route::get('/{a}', 'OutroController@indexPlanejamentosAno');
        Route::get('/', 'OutroController@indexPlanejamentos');
        Route::get('/painel/{id}', 'OutroController@painelPlanejamentos');
        Route::get('/download/{id}', 'OutroController@downloadPlanejamento');
        Route::post('/conferir', 'OutroController@conferirPlanejamento');
    });
});

