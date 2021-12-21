<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Categoria;
use App\Models\CompraProduto;
use App\Models\ConteudoProva;
use App\Models\Ocorrencia;
use App\Models\Diario;
use App\Models\Disciplina;
use App\Models\Documento;
use App\Models\EntradaSaida;
use App\Models\Lembrete;
use App\Models\ListaCompra;
use App\Models\Produto;
use App\Models\ProdutoExtra;
use App\Models\Prof;
use App\Models\ProfDisciplina;
use App\Models\ProfTurma;
use App\Models\Questao;
use App\Models\Simulado;
use App\Models\TurmaDisciplina;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OutroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:outro');
    }
    
    public function index(){
        return view('outros.home_outro');
    }

    //CATEGORIAS
    public function indexCategorias()
    {
        $cats = Categoria::all();
        return view('outros.categorias',compact('cats'));
    }

    public function novaCategoria(Request $request)
    {
        $cat = new Categoria();
        $cat->nome = $request->input('nomeCategoria');
        $cat->save();
        return back();
    }

    public function editarCategoria(Request $request, $id)
    {
        $cat = Categoria::find($id);
        if(isset($cat)){
            $cat->nome = $request->input('nomeCategoria');
            $cat->save();
        }
        return back();
    }

    public function apagarCategoria($id)
    {
        $cat = Categoria::find($id);

        if(isset($cat)){
            if($cat->ativo==1){
                $cat->ativo = false;
                $cat->save();
                return back()->with('mensagem', 'Categoria Inativada com Sucesso!');
            } else {
                $cat->ativo = true;
                $cat->save();
                return back()->with('mensagem', 'Categoria Ativada com Sucesso!');
            }
        }
        
        return back();
    }

    //PRODUTOS
    public function indexProdutos()
    {
        $cats = Categoria::orderBy('nome')->get();
        $prods = Produto::orderBy('nome')->paginate(10);
        $view = "inicial";
        return view('outros.produtos', compact('view','cats','prods'));
    }

    public function novoProduto(Request $request)
    {
        $prod = new Produto();
        $prod->nome = $request->input('nomeProduto');
        $prod->estoque = $request->input('estoqueProduto');
        $prod->categoria_id = $request->input('categoriaProduto');
        $prod->save();
        return back();
    }

    public function filtroProdutos(Request $request)
    {
        $nomeProd = $request->input('nomeProduto');
        $cat = $request->input('categoria');
        $ativo = $request->input('ativo');
        if(isset($nomeProd)){
            if(isset($cat)){
                $prods = Produto::where('nome','like',"%$nomeProd%")->where('categoria_id',"$cat")->orderBy('nome')->paginate(100);
            } else {
                $prods = Produto::where('nome','like',"%$nomeProd%")->orderBy('nome')->paginate(100);
            }
        } else {
            if(isset($cat)){
                $prods = Produto::where('categoria_id',"$cat")->orderBy('nome')->paginate(100);
            } else {
                $prods = Produto::orderBy('nome')->paginate(100);
            }
        }
        $cats = Categoria::orderBy('nome')->get();
        $view = "filtro";
        return view('outros.produtos', compact('view','cats','prods'));
    }

    public function editarProduto(Request $request, $id)
    {
        $prod = Produto::find($id);
        if(isset($prod)){
            $prod->nome =$request->input('nomeProduto');
            $prod->categoria_id =$request->input('categoriaProduto');
            $prod->save();
        }
        return back();
    }

    public function apagarProduto($id)
    {
        $prod = Produto::find($id);

        if(isset($prod)){
            if($prod->ativo==1){
                $prod->ativo = false;
                $prod->save();
                return back()->with('mensagem', 'Produto Inativado com Sucesso!');
            } else {
                $prod->ativo = true;
                $prod->save();
                return back()->with('mensagem', 'Produto Ativado com Sucesso!');
            }
        }
        
        return back();
    }

    //ENTRADAS & SAIDAS
    public function indexEntradaSaidas()
    {
        $rels = EntradaSaida::orderBy('created_at', 'desc')->paginate(10);
        $prods = Produto::where('ativo',true)->orderBy('nome')->get();
        $view = "inicial";
        return view('outros.entrada_saida', compact('view','rels','prods'));
    }

    public function novaEntradaSaida(Request $request)
    {

        $tipo = $request->input('tipo');
        $qtd = $request->input('qtd');
        $prod = Produto::find($request->input('produto'));
        $es = new EntradaSaida();
        $es->tipo = $tipo;
        $es->produto_id = $request->input('produto');
        $es->produto_nome = $prod->nome;
        $es->quantidade = $qtd;
        $es->requisitante = $request->input('req');
        $es->usuario = Auth::user()->name;
        $es->data = $request->input('data');
        $es->save();
        if(isset($prod)){
            if($tipo=="entrada"){
                $prod->estoque += $qtd;
            }
            if($tipo=="saida"){
                $prod->estoque -= $qtd;
            }
            $prod->save();
        }
        return back();
    }

    public function filtroEntradaSaidas(Request $request)
    {
        $tipo = $request->input('tipo');
        $produto = $request->input('produto');
        $dataInicio = $request->input('dataInicio');
        $dataFim = $request->input('dataFim');
        if(isset($tipo)){
            if(isset($produto)){
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->where('produto_id',"$produto")->whereBetween('data',["$dataInicio", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->where('produto_id',"$produto")->whereBetween('data',["$dataInicio", date("Y/m/d")])->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->where('produto_id',"$produto")->whereBetween('data',["", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->where('produto_id',"$produto")->paginate(100);
                    }
                }
            } else {
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->whereBetween('data',["$dataInicio", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->whereBetween('data',["$dataInicio", date("Y/m/d")])->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->whereBetween('data',["", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::where('tipo','like',"%$tipo%")->paginate(100);
                    }
                }
            }
        } else {
            if(isset($produto)){
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $rels = EntradaSaida::where('produto_id',"$produto")->whereBetween('data',["$dataInicio", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::where('produto_id',"$produto")->whereBetween('data',["$dataInicio", date("Y/m/d")])->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $rels = EntradaSaida::where('produto_id',"$produto")->whereBetween('data',["", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::where('produto_id',"$produto")->paginate(100);
                    }
                }
            } else {
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $rels = EntradaSaida::whereBetween('data',["$dataInicio", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::whereBetween('data',["$dataInicio", date("Y/m/d")])->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $rels = EntradaSaida::whereBetween('data',["", "$dataFim"])->paginate(100);
                    } else {
                        $rels = EntradaSaida::paginate(10);
                    }
                }
            }
        }
        $prods = Produto::where('ativo',true)->orderBy('nome')->get();
        $view = "filtro";
        return view('outros.entrada_saida', compact('view','rels','prods'));
    }

    //LISTAS DE COMPRAS
    public function indexListaCompras(){
        $listaProds = ListaCompra::with('produtos')->orderBy('created_at','desc')->paginate(10);
        return view('outros.lista_compra', compact('listaProds'));
    }

    public function selecionarListaCompra(){
        $prods = Produto::where('ativo',true)->orderBy('nome')->get();
        return view('outros.lista_compra_selecionar', compact('prods'));
    }

    public function novaListaCompra(Request $request){
        $prods = $request->input('produtos');
        $prodExtras = $request->input('produtosExtras');
        if($prods=="" && $prodExtras==""){
            return redirect('/outro/listaCompras')->with('mensagem', 'Lista não criada, nenhum item foi selecionado!');
        } else {
            $user = Auth::user()->name;
            $dataAtual = date("Y/m/d");
            $lista = new ListaCompra();
            $lista->data = $dataAtual;
            $lista->usuario = $user;
            $lista->save();
            if($prods!=""){
                foreach($prods as $prod){
                    $cp = new CompraProduto();
                    $cp->lista_compra_id = $lista->id;
                    $cp->produto_id = $prod;
                    $produto = Produto::find($prod);
                    $cp->estoque = $produto->estoque;
                    $cp->save();
                }
            }
            if($prodExtras!=""){
                foreach($prodExtras as $prodEx){
                    $pe = new ProdutoExtra();
                    $pe->lista_compra_id = $lista->id;
                    $pe->nome = $prodEx;
                    $pe->save();
                }
            }
        }   
        return redirect('/outro/listaCompras')->with('mensagem', 'Lista criada com Sucesso!');
    }

    public function gerarPdfListaCompra($lista_id)
    {
        $lista = ListaCompra::find($lista_id);
        $produtos = CompraProduto::where('lista_compra_id',"$lista_id")->get();
        $produtoExtras = ProdutoExtra::where('lista_compra_id',"$lista_id")->get();
        $pdf = \PDF::loadView('outros.compras_pdf', compact('lista','produtos','produtoExtras'));
        return $pdf->setPaper('a4')->stream('ListaCompra'.date("d-m-Y", strtotime($lista->data)).'.pdf');
    }

    public function removerItem($lista_id, $produto_id)
    {
        CompraProduto::where('lista_compra_id',"$lista_id")->where('produto_id',"$produto_id")->delete();
        return back()->with('mensagem', 'Item removido com Sucesso!');
    }

    public function removerItemExtra($lista_id, $produto)
    {
        ProdutoExtra::where('lista_compra_id',"$lista_id")->where('nome',"$produto")->delete();
        return back()->with('mensagem', 'Item removido com Sucesso!');
    }

    //DIÁRIO
    public function indexDiario(){
        $turmas = Turma::where('ativo',true)->orderBy('ensino')->orderBy('serie')->get();
        return view('outros.home_diario', compact('turmas'));
    }

    public function consultaDiario(Request $request){
        $turmaId = $request->input('turma');
        $dia = $request->input('data');
        $turma = Turma::find($turmaId);
        $diarios = Diario::where('turma_id',"$turmaId")->where('dia', "$dia")->orderBy('tempo')->get();
        $ocorrencias = Ocorrencia::where('data',"$dia")->get();
        return view('outros.diario_outro', compact('dia','turma','diarios','ocorrencias'));
    }

    public function relatorioDiario(){
        $turmas = Turma::orderBy('ensino')->orderBy('serie')->get();
        $discs = Disciplina::orderBy('nome')->orderBy('ensino')->get();
        $profs = Prof::orderBy('name')->get();
        return view('outros.diario_relatorio', compact('turmas','discs','profs'));
    }

    public function relatorioTurma(Request $request){
        $campos = $request->input('campos');
        $turma = Turma::find($request->turma);
        $query = Diario::query();
        if(isset($request->dataInicio)) {
            if(isset($request->dataFim)) {
                $query->whereBetween('dia',["$request->dataInicio", "$request->dataFim"]);
            } else {
                $query->whereBetween('dia',["$request->dataInicio", date("Y/m/d")]);
            }
        } else {
            if(isset($request->dataFim)) {
                $query->where('dia','<=', "$request->dataFim");
            }
        }
        if(isset($request->turma)) {
            $query->where('turma_id', "$request->turma");
        }
        if(isset($request->disciplina)) {
            $query->where('disciplina_id', "$request->disciplina");
        }
        if(isset($request->prof)) {
            $query->where('prof_id', "$request->prof");
        }
        if (isset($request->conferido)) {
            $query->where('conferido', $request->conferido);
        }
        $diarios = $query->orderBy('dia')->orderBy('tempo')->get();
        $pdf = \PDF::loadView('outros.diario_relatorio_pdf', ['diarios'=>$diarios, 'turma'=>$turma, 'campos'=>$campos]);
        return $pdf->setPaper('a4')->stream('Relatório Diários - '.$turma->serie.'º Ano '.$turma->turma.'.pdf');
    }

    //SIMULADOS
    public function indexSimulados(Request $request){
        $ano = $request->input('ano');
        $turmas = Turma::where('ativo',true)->orderBy('serie')->get();
        $anos = DB::table('simulados')->select(DB::raw("ano"))->groupBy('ano')->get();
        $provas = Simulado::where('ano',"$ano")->orderBy('prazo', 'desc')->get();
        return view('outros.home_provas',compact('ano','turmas','anos','provas'));
    }

    public function indexSimuladosAno($ano){
        if($ano==""){
            $ano = date("Y");
        }
        $turmas = Turma::where('ativo',true)->orderBy('serie')->get();
        $anos = DB::table('simulados')->select(DB::raw("ano"))->groupBy('ano')->get();
        $provas = Simulado::where('ano',"$ano")->orderBy('prazo', 'desc')->get();
        return view('outros.home_provas',compact('ano','turmas','anos','provas'));
    }
    //DB::table('questao_simulados')->select(DB::raw('id, descricao, bimestre, ano'))->groupByRaw('id, descricao, bimestre, ano')->get();
    
    public function gerarSimulados(Request $request){
        $prova = new Simulado();
        $prova->prazo = $request->input('prazo');
        $prova->descricao = $request->input('descricao');
        $prova->ano = $request->input('ano');
        $prova->bimestre = $request->input('bimestre');
        $prova->save();
        $turmas = $request->input('turmas');
        $discs = Disciplina::where('ativo',true)->get();
        foreach($turmas as $turmaId){
            $turma = Turma::find($turmaId);
            foreach($discs as $disc){
                if($disc->ensino=="fund" && $turma->ensino=="fund"){
                    $validador = Questao::where('simulado_id', "$prova->id")->where('turma_id', "$turmaId")->where('disciplina_id', "$disc->id")->count();
                    if($validador == 0){
                        $quest = new Questao();
                        $quest->simulado_id = $prova->id;
                        $quest->turma_id = $turmaId;
                        $quest->disciplina_id = $disc->id;
                        $quest->save();

                        $quest = new ConteudoProva();
                        $quest->simulado_id = $prova->id;
                        $quest->turma_id = $turmaId;
                        $quest->disciplina_id = $disc->id;
                        $quest->save();
                    }
                } else if($disc->ensino=="medio" && $turma->ensino=="medio"){
                    $validador = Questao::where('simulado_id', "$prova->id")->where('turma_id', "$turmaId")->where('disciplina_id', "$disc->id")->count();
                    if($validador == 0){
                        $quest = new Questao();
                        $quest->simulado_id = $prova->id;
                        $quest->turma_id = $turmaId;
                        $quest->disciplina_id = $disc->id;
                        $quest->save();

                        $quest = new ConteudoProva();
                        $quest->simulado_id = $prova->id;
                        $quest->turma_id = $turmaId;
                        $quest->disciplina_id = $disc->id;
                        $quest->save();
                    }
                }
            }
        }
        return back()->with('mensagem', 'Campos para anexar os conteúdos e questões gerados com sucesso!')->with('type', 'success');
    }

    public function painelSimulados($provaId){
        $prova = Simulado::find($provaId);
        $ano = $prova->ano;
        $fundTurmas = "";
        $fundDiscs = "";
        $contFunds = "";
        $medioTurmas = "";
        $medioDiscs = "";
        $contMedios = "";
        $ensino = "";
        $fundTurmas = Turma::where('ensino','fund')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        $turmaIdsFund = array();
        foreach($fundTurmas as $fundTurma){
            $turmaIdsFund[] = $fundTurma->id;
        }
        $validadorFund = Questao::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsFund)->count();
        if($validadorFund!=0){
            $ensino = "fund";
            $anexosFund = Questao::where('simulado_id',"$provaId")->whereIn('turma_id', $turmaIdsFund)->distinct('disciplina_id')->get();
            $discIdsFund = array();
            foreach($anexosFund as $anexo){
                $discIdsFund[] = $anexo->disciplina_id;
            }
            $fundSeries = Turma::whereIn('id', $turmaIdsFund)->select(DB::raw("serie"))->groupBy('serie')->get();
            $fundDiscs = Disciplina::orWhereIn('id', $discIdsFund)->where('ativo',true)->with('turmas')->orderBy('nome')->get();
            $contFunds = Questao::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsFund)->orderBy('disciplina_id')->get();
        }
        $medioTurmas = Turma::where('ensino','medio')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        $turmaIdsMedio = array();
        foreach($medioTurmas as $medioTurma){
            $turmaIdsMedio[] = $medioTurma->id;
        }
        $validadorMedio = Questao::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsMedio)->count();
        if($validadorMedio!=0){
            $ensino = "medio";
            $anexosMed = Questao::where('simulado_id',"$provaId")->whereIn('turma_id', $turmaIdsMedio)->distinct('disciplina_id')->get();
            $discIdsMed = array();
            foreach($anexosMed as $anexo){
                $discIdsMed[] = $anexo->disciplina_id;
            }
            $medioSeries = Turma::whereIn('id', $turmaIdsMedio)->select(DB::raw("serie"))->groupBy('serie')->get();
            $medioDiscs = Disciplina::orWhereIn('id', $discIdsMed)->where('ativo',true)->with('turmas')->orderBy('nome')->get();
            $contMedios = Questao::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsMedio)->orderBy('disciplina_id')->get();
        }
        if($validadorFund!=0 && $validadorMedio!=0){
            $ensino = "todos";
        }
        if($validadorFund==0 && $validadorMedio==0){
            return back()->with('mensagem', 'Não foram criados campos de conteúdos para essa prova!')->with('type', 'warning');
        }
        return view('outros.provas',compact('ensino','prova','ano','fundSeries','fundTurmas','medioSeries','medioTurmas','fundDiscs','medioDiscs','contFunds','contMedios'));
    }

    public function anexarSimulado(Request $request, $id)
    {
        $path = $request->file('arquivo')->store('questoesSimulados','public');
        $cont = Questao::find($id);
        if($cont->arquivo=="" || $cont->arquivo==null){
            $cont->arquivo = $path;
            $cont->save();
        } else {
            $arquivo = $cont->arquivo;
            Storage::disk('public')->delete($arquivo);
            $cont->arquivo = $path;
            $cont->save();
        }
        return back();
    }

    public function downloadSimulado($id)
    {
        $cont = Questao::find($id);
        $discId = $cont->disciplina_id;
        $disciplina = Disciplina::find($discId);
        $prova = Simulado::find($cont->simulado_id);
        $nameFile = $cont->turma->serie."º ANO ".$cont->turma->turma." - Questões ".$prova->descricao." ".$prova->bimestre."º Bim - ".$disciplina->nome;
        if(isset($cont)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($cont->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    public function conferirSimulado(Request $request)
    {
        $id = $request->id;
        $cont = Questao::find($id);
        $cont->comentario = $request->comentario;
        $cont->conferido = true;
        $cont->save();
        return back();
    }

    //CONTEUDOS DE PROVAS
    public function painelConteudoProvas($provaId){
        $prova = Simulado::find($provaId);
        $ano = $prova->ano;
        $fundSeries = "";
        $fundTurmas = "";
        $fundDiscs = "";
        $contFunds = "";
        $medioSeries = "";
        $medioTurmas = "";
        $medioDiscs = "";
        $contMedios = "";
        $ensino = "";
        $fundTurmas = Turma::where('ensino','fund')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        $turmaIdsFund = array();
        foreach($fundTurmas as $fundTurma){
            $turmaIdsFund[] = $fundTurma->id;
        }
        $validadorFund = ConteudoProva::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsFund)->count();
        if($validadorFund!=0){
            $ensino = "fund";
            $anexosFund = ConteudoProva::where('simulado_id',"$provaId")->whereIn('turma_id', $turmaIdsFund)->distinct('disciplina_id')->get();
            $discIdsFund = array();
            foreach($anexosFund as $anexo){
                $discIdsFund[] = $anexo->disciplina_id;
            }
            $fundSeries = Turma::whereIn('id', $turmaIdsFund)->select(DB::raw("serie"))->groupBy('serie')->get();
            $fundDiscs = Disciplina::orWhereIn('id', $discIdsFund)->where('ativo',true)->with('turmas')->orderBy('nome')->get();
            $contFunds = ConteudoProva::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsFund)->orderBy('disciplina_id')->get();
        }
        $medioTurmas = Turma::where('ensino','medio')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        $turmaIdsMedio = array();
        foreach($medioTurmas as $medioTurma){
            $turmaIdsMedio[] = $medioTurma->id;
        }
        $validadorMedio = ConteudoProva::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsMedio)->count();
        if($validadorMedio!=0){
            $ensino = "medio";
            $anexosMed = ConteudoProva::where('simulado_id',"$provaId")->whereIn('turma_id', $turmaIdsMedio)->distinct('disciplina_id')->get();
            $discIdsMed = array();
            foreach($anexosMed as $anexo){
                $discIdsMed[] = $anexo->disciplina_id;
            }
            $medioSeries = Turma::whereIn('id', $turmaIdsMedio)->select(DB::raw("serie"))->groupBy('serie')->get();
            $medioDiscs = Disciplina::orWhereIn('id', $discIdsMed)->where('ativo',true)->with('turmas')->orderBy('nome')->get();
            $contMedios = ConteudoProva::where('simulado_id', "$provaId")->whereIn('turma_id', $turmaIdsMedio)->orderBy('disciplina_id')->get();
        }
        if($validadorFund!=0 && $validadorMedio!=0){
            $ensino = "todos";
        } 
        if($validadorFund==0 && $validadorMedio==0){
            return back()->with('mensagem', 'Não foram criados campos de conteúdos para essa prova!')->with('type', 'warning');
        }
        return view('outros.conteudos_provas',compact('ensino','prova','ano','fundSeries','fundTurmas','medioSeries','medioTurmas','fundDiscs','medioDiscs','contFunds','contMedios'));
    }

    public function gerarPdfConteudo($provaId, $turmaId, Request $request)
    {
        $turma = Turma::find($turmaId);
        $prova = Simulado::find($provaId);
        $turmaDiscs = TurmaDisciplina::where('turma_id',"$turmaId")->get();
        if(isset($request->disciplinas)){
            $discIds = $request->disciplinas;
        } else{
            $discIds = array();
            foreach($turmaDiscs as $turmaDisc){
                $discIds[] = $turmaDisc->disciplina_id;
            }
        }
        $discs = Disciplina::whereIn('id', $discIds)->where('ativo',true)->orderBy('nome')->get();
        $profTurmas = ProfTurma::where('turma_id',"$turmaId")->get();
        $profIds = array();
            foreach($profTurmas as $profTurma){
                 $profDisc = ProfDisciplina::find($profTurma->prof_disciplina_id);
                 $profIds[] = $profDisc->prof_id;
            }
        $profs = Prof::whereIn('id', $profIds)->where('ativo',true)->get();
        $conteudos = ConteudoProva::where('simulado_id',"$provaId")->where('turma_id',"$turmaId")->get();
        $pdf = \PDF::loadView('outros.conteudos_pdf', compact('turma','prova','discs','profs','conteudos'));
        return $pdf->setPaper('a4')->stream($turma->serie.'º'. $turma->turma .' - Conteúdos '.$prova->descricao.' - '.$prova->bimestre.'º Bimestre'.'.pdf');
    }

    //DOCUMENTOS
    public function painelDocumentos(){
        $documentos = Documento::orderBy('id','desc')->paginate(10);
        $view = "inicial";
        return view('outros.documentos_outro', compact('view','documentos'));
    }

    public function filtroDocumento(Request $request)
    {
        $titulo = $request->input('titulo');
        if(isset($titulo)){
            $documentos = Documento::where('titulo',"%$titulo%")->orderBy('id','desc')->paginate(50);
        } else {
            return redirect('/outro/documento');
        }
        $view = "filtro";
        return view('outros.documentos_outro', compact('view','documentos'));
    }

    public function downloadDocumento($id)
    {
        $documento = Documento::find($id);
        $nameFile = $documento->titulo;
        if(isset($documento)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($documento->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    //LEMBRETES
    public function painelLembretes(){
        $lembretes = Lembrete::orderBy('id','desc')->paginate(10);
        $view = "inicial";
        return view('outros.lembretes_outro', compact('view','lembretes'));
    }


    public function filtroLembrete(Request $request)
    {
        $titulo = $request->input('titulo');
        if(isset($titulo)){
            $lembretes = Lembrete::where('titulo',"%$titulo%")->orderBy('id','desc')->paginate(50);
        } else {
            return redirect('/outro/lembrete');
        }
        $view = "filtro";
        return view('outros.lembretes_outro', compact('view','lembretes'));
    }
}
