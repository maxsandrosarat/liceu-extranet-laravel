<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Disciplina;
use App\Models\Turma;
use App\Models\Atividade;
use App\Models\Aluno;
use App\Models\AnexoPlanejamento;
use App\Models\AtividadeComplementar;
use App\Models\AtividadeExtra;
use App\Models\AtividadeRetorno;
use App\Models\Categoria;
use App\Models\CompraProduto;
use App\Models\TipoOcorrencia;
use App\Models\Ocorrencia;
use App\Models\Conteudo;
use App\Models\ConteudoProva;
use App\Models\Diario;
use App\Models\Documento;
use App\Models\EntradaSaida;
use App\Models\La;
use App\Models\Lembrete;
use App\Models\ListaAtividade;
use App\Models\ListaCompra;
use App\Models\Outro;
use App\Models\Planejamento;
use App\Models\Produto;
use App\Models\ProdutoExtra;
use App\Models\Prof;
use App\Models\ProfDisciplina;
use App\Models\ProfTurma;
use App\Models\Questao;
use App\Models\Recado;
use App\Models\Responsavel;
use App\Models\ResponsavelAluno;
use App\Models\Simulado;
use App\Models\TurmaDisciplina;
use App\Exports\AlunoExport;
use App\Exports\AlunoExportView;
use Excel;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(){
        return view('admin.home_admin');
    }

    public function cadastroAdmin()
    {
        return view('auth.admin-register');
    }

    public function novoAdmin(Request $request)
    {
        $adm = new Admin();
        $adm->name = $request->input('name');
        $adm->email = $request->input('email');
        $adm->password = Hash::make($request->input('password'));
        $adm->save();
        return back()->with('mensagem', 'Novo Administrador(a) cadastrado com Sucesso!')->with('type', 'success');
    }

    //DISCIPLINAS
    public function indexDisciplinas()
    {
        $discs = Disciplina::orderBy('nome')->get();
        return view('admin.disciplinas',compact('discs'));
    }

    public function novaDisciplina(Request $request)
    {
        $disc = new Disciplina();
        $disc->nome = $request->input('nome');
        $disc->ensino = $request->input('ensino');
        $disc->save();
        return back();
    }

    public function apagarDisciplina($id)
    {
        $disc = Disciplina::find($id);

        if(isset($disc)){
            if($disc->ativo==1){
                $disc->ativo = false;
                $disc->save();
                return back()->with('mensagem', 'Disciplina Inativada com Sucesso!')->with('type', 'success');
            } else {
                $disc->ativo = true;
                $disc->save();
                return back()->with('mensagem', 'Disciplina Ativada com Sucesso!')->with('type', 'success');
            }
        }
        
        return back();
    }

    public function buscarDisciplina(Request $request)
    {
        $nome = $request->input('busca');
        return Disciplina::where('nome','like',"%$nome%")->get();
    }

    public function selecionarDisciplina(Request $request)
    {
        $id = $request->input('id');
        return Disciplina::find($id );
    }

    //TURMAS
    public function indexTurmas()
    {
        $turmas = Turma::all();
        $discs = Disciplina::orderBy('nome')->get();
        return view('admin.turmas',compact('turmas','discs'));
    }

    public function novaTurma(Request $request)
    {
        $turma = new Turma();
        $turma->serie = $request->input('serie');
        $turma->turma = $request->input('turma');
        $turma->turno = $request->input('turno');
        $turma->ensino = $request->input('ensino');
        $turma->save();
        return back()->with('mensagem', 'Turma Cadastrada com Sucesso!')->with('type', 'success');
    }

    public function turmasDisciplinas(Request $request)
    {
        TurmaDisciplina::where('turma_id',"$request->turma")->delete();
        if(isset($request->disciplinas)){
            foreach($request->disciplinas as $disc){
                $turmaDisc = new TurmaDisciplina();
                $turmaDisc->turma_id = $request->turma;
                $turmaDisc->disciplina_id = $disc;
                $turmaDisc->save();
            }
        }
        return back()->with('mensagem', 'Disciplinas Cadastradas para Turma com Sucesso!')->with('type', 'success');
    }

    public function apagarTurma($id)
    {
        $turma = Turma::find($id);

        if(isset($turma)){
            if($turma->ativo==1){
                $turma->ativo = false;
                $turma->save();
                return back()->with('mensagem', 'Turma Inativada com Sucesso!')->with('type', 'success');
            } else {
                $turma->ativo = true;
                $turma->save();
                return back()->with('mensagem', 'Turma Ativada com Sucesso!')->with('type', 'success');
            }
        }
        
        return back();
    }

    public function buscarTurmas(Request $request)
    {
        $discTurmas = TurmaDisciplina::where('disciplina_id',"$request->disc")->get();
        $turmasIds = array();
        foreach($discTurmas as $discTurma){
                $turmasIds[] = $discTurma->turma_id;
        }
        $turmas = Turma::whereIn('id', $turmasIds)->orderBy('serie')->get();
        return $turmas;
    }

    //TURMAS & DISCIPLINAS
    public function indexTurmaDiscs()
    {
        $turmaDiscs = Turma::where('ativo',true)->with('disciplinas')->get();
        $turmas = Turma::where('ativo',true)->get();
        $discs = Disciplina::where('ativo',true)->orderBy('nome')->get();
        return view('admin.turmas_disciplinas',compact('turmaDiscs','turmas','discs'));
    }

    public function novaTurmaDisc(Request $request)
    {
        if($request->input('disciplina')=="todasFund"){
            $discFunds = Disciplina::where('ativo',true)->where('ensino','fund')->get();
            foreach($discFunds as $discFund){
                $turmaDisc = new TurmaDisciplina();
                $turmaDisc->turma_id = $request->input('turma');
                $turmaDisc->disciplina_id = $discFund->id;
                $turmaDisc->save();
            }
        } elseif($request->input('disciplina')=="todasMedio"){
            $discs = Disciplina::where('ativo',true)->where('ensino','medio')->get();
            foreach($discs as $disc){
                $turmaDisc = new TurmaDisciplina();
                $turmaDisc->turma_id = $request->input('turma');
                $turmaDisc->disciplina_id = $disc->id;
                $turmaDisc->save();
            }
        } elseif($request->input('disciplina')==""){
            if($request->input('disciplinas')==""){
                return redirect('/turmasDiscs');
            } else {
                $disciplinas = $request->input('disciplinas');
                foreach($disciplinas as $disciplina){
                    $turmaDisc = new TurmaDisciplina();
                    $turmaDisc->turma_id = $request->input('turma');
                    $turmaDisc->disciplina_id = $disciplina;
                    $turmaDisc->save();
                }
            }
        }
        return back()->with('mensagem', 'Disciplinas Cadastradas para Turma com Sucesso!')->with('type', 'success');
    }

    public function apagarTurmaDisc($turma_id, $disciplina_id)
    {
        TurmaDisciplina::where('turma_id',"$turma_id")->where('disciplina_id',"$disciplina_id")->delete();
        return back()->with('mensagem', 'Disciplina Desvinculada da Turma com Sucesso!')->with('type', 'success');
    }

    //TIPOS DE OCORRENCIAS
    public function indexTiposOcorrencia()
    {
        $tipos = TipoOcorrencia::orderBy('codigo')->get();
        return view('admin.tipo_ocorrencia',compact('tipos'));
    }

    public function novoTipoOcorrencia(Request $request)
    {
        $tipo = new TipoOcorrencia();
        $tipo->codigo = $request->input('codigo');
        $tipo->descricao = $request->input('descricao');
        $tipo->tipo = $request->input('tipo');
        $tipo->pontuacao = $request->input('pontuacao');
        $tipo->save();
        return back()->with('mensagem', 'Tipo de Ocorrência Cadastrada com Sucesso!')->with('type', 'success');
    }

    public function editarTipoOcorrencia(Request $request, $id)
    {
        $tipo = TipoOcorrencia::find($id);
        if(isset($tipo)){
            if($request->input('codigo')!=""){
                $tipo->codigo = $request->input('codigo');
            }
            if($request->input('descricao')!=""){
                $tipo->descricao = $request->input('descricao');
            }
            if($request->input('tipo')!=""){
                $tipo->tipo = $request->input('tipo');
            }
            if($request->input('pontuacao')!=""){
                $tipo->pontuacao = $request->input('pontuacao');
            }
            $tipo->save();
        }
        return back()->with('mensagem', 'Tipo de Ocorrência Alterada com Sucesso!')->with('type', 'success');
    }

    public function apagarTipoOcorrencia($id)
    {
        $tipo = TipoOcorrencia::find($id);
        if(isset($tipo)){
            if($tipo->ativo==1){
                $tipo->ativo = false;
                $tipo->save();
                return back()->with('mensagem', 'Tipo de Ocorrência Inativada com Sucesso!')->with('type', 'success');
            } else {
                $tipo->ativo = true;
                $tipo->save();
                return back()->with('mensagem', 'Tipo de Ocorrência Ativada com Sucesso!')->with('type', 'success');
            }
        }
        return back();
    }

    //TEMPLATES    
	public function templates($nome){
        if($nome=="aluno"){
            $nameFile = "import_alunos";
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("templates/import_alunos.xlsx");
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        } else if($nome=="outro"){
            $nameFile = "import_outro";
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("templates/import_outro.xlsx");
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        } else if($nome=="mascara"){
            $nameFile = "mascara";
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix("templates/mascara.docx");
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        } else {
            return back();
        }
    }

    //PROFESSORES
    public function indexProfs()
    {
        $view = "inicial";
        $profs = Prof::with('disciplinas')->where('ativo',true)->orderBy('name')->paginate(10);
        $discs = Disciplina::all();
        $profDiscs = ProfDisciplina::all();
        $profTurmas = ProfTurma::all();
        return view('admin.profs', compact('view','profs','discs','profDiscs','profTurmas'));
    }

    public function novoProf(Request $request)
    {
        $prof = new Prof();
        $prof->name = $request->input('name');
        $prof->email = $request->input('email');
        $prof->password = Hash::make($request->input('password'));
        $prof->save();
        $disciplinas = $request->input('disciplinas');
                foreach($disciplinas as $disciplina){
                    $profDisc = new ProfDisciplina();
                    $profDisc->prof_id = $prof->id;
                    $profDisc->disciplina_id = $disciplina;
                    $profDisc->save();
                }
        return back()->with('mensagem', 'Professor(a) Cadastrado(a) com Sucesso!')->with('type', 'success');
    }

    public function filtroProfs(Request $request)
    {
        $nome = $request->input('nome');
        $disc = $request->input('disciplina');
        $ativo = $request->input('ativo');
        if($ativo==1){
            if(isset($nome)){
                if(isset($disc)){
                    $profDiscs = ProfDisciplina::where('disciplina_id',"$disc")->get();
                    $profIds = array();
                    foreach($profDiscs as $profDisc){
                        $profIds[] = $profDisc->prof_id;
                    }
                    $profs = Prof::whereIn('id', $profIds)->where('ativo',true)->where('name','like',"%$nome%")->orderBy('name')->paginate(100);
                } else {
                    $profs = Prof::where('name','like',"%$nome%")->where('ativo',true)->orderBy('name')->paginate(100);
                }
            } else {
                if(isset($disc)){
                    $profDiscs = DB::table('prof_disciplinas')->select(DB::raw("prof_id"))->where('disciplina_id',"$disc")->get();
                    $profIds = array();
                    foreach($profDiscs as $profDisc){
                        $profIds[] = $profDisc->prof_id;
                    }
                    $profs = Prof::whereIn('id', $profIds)->where('ativo',true)->orderBy('name')->paginate(100);
                } else {
                    $profs = Prof::where('ativo',true)->orderBy('name')->paginate(100);
                }
            }
        } else {
            if(isset($nome)){
                if(isset($disc)){
                    $profDiscs = ProfDisciplina::where('disciplina_id',"$disc")->get();
                    $profIds = array();
                    foreach($profDiscs as $profDisc){
                        $profIds[] = $profDisc->prof_id;
                    }
                    $profs = Prof::whereIn('id', $profIds)->where('ativo',false)->where('name','like',"%$nome%")->orderBy('name')->paginate(100);
                } else {
                    $profs = Prof::where('name','like',"%$nome%")->where('ativo',false)->orderBy('name')->paginate(100);
                }
            } else {
                if(isset($disc)){
                    $profDiscs = DB::table('prof_disciplinas')->select(DB::raw("prof_id"))->where('disciplina_id',"$disc")->get();
                    $profIds = array();
                    foreach($profDiscs as $profDisc){
                        $profIds[] = $profDisc->prof_id;
                    }
                    $profs = Prof::whereIn('id', $profIds)->where('ativo',false)->orderBy('name')->paginate(100);
                } else {
                    $profs = Prof::where('ativo',false)->orderBy('name')->paginate(100);
                }
            }
        }
        
        $discs = Disciplina::all();
        $profDiscs = ProfDisciplina::all();
        $profTurmas = ProfTurma::all();
        $view = "filtro";
        return view('admin.profs', compact('view','discs','profs','profDiscs','profTurmas'));
    }

    public function editarProf(Request $request, $id)
    {
        $prof = Prof::find($id);
        if(isset($prof)){
            $prof->name =$request->input('name');
            $prof->email =$request->input('email');
            if($request->input('password')!=""){
            $prof->password = Hash::make($request->input('password'));
            }
            $prof->save();
            $disciplinas = $request->input('disciplinas');
            ProfDisciplina::where('prof_id',"$id")->delete();
            foreach ($disciplinas as $disciplina) {
                $profDiscs = ProfDisciplina::where('prof_id',"$id")->where('disciplina_id',"$disciplina")->get();
                if($profDiscs->count()==0){
                    $profDisc = new ProfDisciplina();
                    $profDisc->prof_id = $id;
                    $profDisc->disciplina_id = $disciplina;
                    $profDisc->save();
                }
            }
        }
        return back()->with('mensagem', 'Professor(a) Alterado(a) com Sucesso!')->with('type', 'success');
    }

    public function apagarProf($id)
    {
        $prof = Prof::find($id);
        if(isset($prof)){
            if($prof->ativo==1){
                $prof->ativo = false;
                $prof->save();
                return back()->with('mensagem', 'Professor(a) Inativado(a) com Sucesso!')->with('type', 'success');
            } else {
                $prof->ativo = true;
                $prof->save();
                return back()->with('mensagem', 'Professor(a) Ativado(a) com Sucesso!')->with('type', 'success');
            }
        }
        return back();
    }

    public function desvincularDisciplinaProf($prof_id, $disciplina_id)
    {
        $profDisc = ProfDisciplina::where('prof_id',"$prof_id")->where('disciplina_id',"$disciplina_id")->first();
        ProfTurma::where('prof_disciplina_id',"$profDisc->id")->delete();
        $profDisc->delete();
        return back();
    }

    public function turmasProf(Request $request)
    {
        $turmas = $request->input('turmas');
        $profDisc = ProfDisciplina::where('prof_id',"$request->prof")->where('disciplina_id',"$request->disciplina")->first();
        ProfTurma::where('prof_disciplina_id',"$profDisc->id")->delete();
        if(isset($turmas)){
            foreach($turmas as $turma){
                $profTurma = new ProfTurma();
                $profTurma->prof_disciplina_id = $profDisc->id;
                $profTurma->turma_id = $turma;
                $profTurma->save();
            }
        }
        return back()->with('mensagem', 'Turma(s) do(a) Professor(a) Cadastrado(a) com Sucesso!')->with('type', 'success');
    }

    //ALUNOS
    public function indexAlunos()
    {
        $turmas = Turma::all();
        $alunos = Aluno::where('ativo',true)->orderBy('name')->paginate(10);
        $view = "inicial";
        return view('admin.alunos', compact('view','turmas','alunos'));
    }

    public function novoAluno(Request $request)
    {
        $request->validate([
            'email' => 'unique:alunos',
            'password' => 'min:8',
        ], $mensagens =[
            'email.unique' => 'Já existe um usuário com esse login!',
            'password.min' => 'A senha deve conter no mínimo 8 caracteres!',
        ]);

        $aluno = new Aluno();
        $aluno->name = $request->input('name');
        $aluno->email = $request->input('email');
        $aluno->password = Hash::make($request->input('password'));
        $aluno->turma_id = $request->input('turma');
        if($request->file('foto')!=""){
        $path = $request->file('foto')->store('fotos_perfil','public');
        $aluno->foto = $path;
        }
        $aluno->save();
        return back()->with('success', 'Aluno(a) Cadastrado(a) com Sucesso!')->with('type', 'success');
    }

    public function importarAlunoExcel(Request $request)
    {
        Excel::import(new \App\Imports\AlunoImport, $request->file('arquivo'));
        return back()->with('success', 'Dados importados do Excel com Sucesso!')->with('type', 'success');
    }

    public function exportarAlunoExcel() 
    {
        return Excel::download(new AlunoExport, 'alunos.xlsx');
    }

    public function exportarAlunoExcelView() 
    {
        return Excel::download(new AlunoExportView, 'alunos.xlsx');
    }

    public function filtroAluno(Request $request)
    {
        $nome = $request->input('nome');
        $turma = $request->input('turma');
        $ativo = $request->input('ativo');
        if(isset($nome)){
            if(isset($turma)){
                $alunos = Aluno::where('ativo',"$ativo")->where('name','like',"%$nome%")->where('turma_id',"$turma")->orderBy('name')->paginate(50);
            } else {
                $alunos = Aluno::where('ativo',"$ativo")->where('name','like',"%$nome%")->orderBy('name')->paginate(50);
            }
        } else {
            if(isset($turma)){
                $alunos = Aluno::where('ativo',"$ativo")->where('turma_id',"$turma")->orderBy('name')->paginate(50);
            } else {
                $alunos = Aluno::where('ativo',"$ativo")->orderBy('name')->paginate(50);
            }
        }
        $turmas = Turma::all();
        $view = "filtro";
        return view('admin.alunos', compact('view','turmas','alunos'));
    }

    public function editarAluno(Request $request, $id)
    {
        $aluno = Aluno::find($id);
        if(isset($aluno)){
            $aluno->name =$request->input('name');
            $aluno->email =$request->input('email');
            if($request->input('password')!=""){
            $aluno->password = Hash::make($request->input('password'));
            }
            $aluno->turma_id = $request->input('turma');
            if($request->file('foto')!=""){
                Storage::disk('public')->delete($aluno->foto);
                $path = $request->file('foto')->store('fotos_perfil','public');
                $aluno->foto = $path;
            }
            $aluno->save();
        }
        return back()->with('success', 'Aluno(a) Alterado(a) com Sucesso!')->with('type', 'success');
    }

    public function apagarAluno($id)
    {
        $aluno = Aluno::find($id);
        if(isset($aluno)){
            if($aluno->ativo==1){
                $aluno->ativo = false;
                $aluno->save();
                return back()->with('success', 'Aluno(a) Inativado(a) com Sucesso!')->with('type', 'success');
            } else {
                $aluno->ativo = true;
                $aluno->save();
                return back()->with('success', 'Aluno(a) Ativado(a) com Sucesso!')->with('type', 'success');
            }
        }
        return back();
    }

    //RESPONSAVEIS
    public function indexResps()
    {
        $resps = Responsavel::with('alunos')->orderBy('name')->paginate(10);
        $alunos = Aluno::orderBy('name')->get();
        $view = "inicial";
        return view('admin.responsavel', compact('view','resps','alunos'));
    }

    public function novoResp(Request $request)
    {
        $resp = new Responsavel();
        $resp->name = $request->input('name');
        $resp->email = $request->input('email');
        $resp->password = Hash::make($request->input('password'));
        $resp->save();
        return back()->with('mensagem', 'Responsável Cadastrado com Sucesso!')->with('type', 'success');
    }

    public function filtroResps(Request $request)
    {
        $nome = $request->input('nome');
        $aluno = $request->input('aluno');
        if(isset($nome)){
            if(isset($aluno)){
                $respAlunos = ResponsavelAluno::where('aluno_id',"$aluno")->get();
                $respIds = array();
                foreach($respAlunos as $respAluno){
                    $respIds[] = $respAluno->responsavel_id;
                }
                $resps = Responsavel::whereIn('id', $respIds)->where('name','like',"%$nome%")->orderBy('name')->paginate(100);
            } else {
                $resps = Responsavel::where('name','like',"%$nome%")->orderBy('name')->paginate(100);
            }
        } else {
            if(isset($aluno)){
                $respAlunos = ResponsavelAluno::where('aluno_id',"$aluno")->get();
                $respIds = array();
                foreach($respAlunos as $respAluno){
                    $respIds[] = $respAluno->responsavel_id;
                }
                $resps = Responsavel::whereIn('id', $respIds)->orderBy('name')->paginate(100);
            } else {
                return redirect('/admin/responsavel');
            }
        }
        $alunos = Aluno::orderBy('name')->get();
        $view = "filtro";
        return view('admin.responsavel', compact('view','resps','alunos'));
    }

    public function editarResp(Request $request, $id)
    {
        $resp = Responsavel::find($id);
        if(isset($resp)){
            $resp->name =$request->input('name');
            $resp->email =$request->input('email');
            if($request->input('password')!=""){
            $resp->password = Hash::make($request->input('password'));
            }
            $resp->save();
        }
        return back()->with('mensagem', 'Responsável Alterado com Sucesso!')->with('type', 'success');
    }

    public function apagarResp($id)
    {
        $resp = Responsavel::find($id);
        if(isset($resp)){
            if($resp->ativo==1){
                $resp->ativo = false;
                $resp->save();
                return back()->with('mensagem', 'Responsável Inativado com Sucesso!')->with('type', 'success');
            } else {
                $resp->ativo = true;
                $resp->save();
                return back()->with('mensagem', 'Responsável Ativado com Sucesso!')->with('type', 'success');
            }
        }
        return back();
    }

    public function vincularAlunoResp(Request $request, $id)
    {
        $respAluno = new ResponsavelAluno();
        $respAluno->responsavel_id = $id;
        $respAluno->aluno_id = $request->input('aluno');
        $respAluno->save();
        
        return back();
    }

    public function desvincularAlunoResp($resp_id, $aluno_id)
    {
        ResponsavelAluno::where('responsavel_id',"$resp_id")->where('aluno_id',"$aluno_id")->delete();
        return back();
    }

    //OUTROS(COLABORADOR)
    public function indexOutros()
    {
        $outros = Outro::orderBy('name')->paginate(10);
        $view = "inicial";
        return view('admin.outros', compact('view','outros'));
    }

    public function novoOutro(Request $request)
    {
        $outro = new Outro();
        $outro->name = $request->input('name');
        $outro->email = $request->input('email');
        $outro->password = Hash::make($request->input('password'));
        $outro->save();
        return back()->with('mensagem', 'Colaborador Cadastrado com Sucesso!')->with('type', 'success');
    }

    public function importarOutroExcel(Request $request)
    {
        Excel::import(new \App\Imports\OutroImport, $request->file('arquivo'));
        return back()->with('success', 'Dados importados do Excel com Sucesso!')->with('type', 'success');
    }

    public function filtroOutros(Request $request)
    {
        $nome = $request->input('nome');
        if(isset($nome)){
                $outros = Outro::where('name','like',"%$nome%")->orderBy('name')->paginate(10);
        } else {
            return back();
        }
        $view = "filtro";
        return view('outros.outros', compact('view','outros'));
    }

    public function editarOutro(Request $request, $id)
    {
        $outro = Outro::find($id);
        if(isset($outro)){
            $outro->name =$request->input('name');
            $outro->email =$request->input('email');
            if($request->input('password')!=""){
            $outro->password = Hash::make($request->input('password'));
            }
            $outro->save();
        }
        return back()->with('mensagem', 'Colaborador Alterado com Sucesso!')->with('type', 'success');
    }

    public function apagarOutro($id)
    {
        $outro = Outro::find($id);
        if(isset($outro)){
            if($outro->ativo==1){
                $outro->ativo = false;
                $outro->save();
                return back()->with('mensagem', 'Colaborador Inativado com Sucesso!')->with('type', 'success');
            } else {
                $outro->ativo = true;
                $outro->save();
                return back()->with('mensagem', 'Colaborador Ativado com Sucesso!')->with('type', 'success');
            }
        }
        return back();
    }

    //CATEGORIAS
    public function indexCategorias()
    {
        $cats = Categoria::all();
        return view('admin.categorias',compact('cats'));
    }

    public function novaCategoria(Request $request)
    {
        $cat = new Categoria();
        $cat->nome = $request->input('nomeCategoria');
        $cat->save();
        return back()->with('mensagem', 'Categoria Cadastrada com Sucesso!')->with('type', 'success');
    }

    public function editarCategoria(Request $request, $id)
    {
        $cat = Categoria::find($id);
        if(isset($cat)){
            $cat->nome = $request->input('nomeCategoria');
            $cat->save();
        }
        return back()->with('mensagem', 'Categoria Alterada com Sucesso!')->with('type', 'success');
    }

    public function apagarCategoria($id)
    {
        $cat = Categoria::find($id);

        if(isset($cat)){
            if($cat->ativo==1){
                $cat->ativo = false;
                $cat->save();
                return back()->with('mensagem', 'Categoria Inativada com Sucesso!')->with('type', 'success');
            } else {
                $cat->ativo = true;
                $cat->save();
                return back()->with('mensagem', 'Categoria Ativada com Sucesso!')->with('type', 'success');
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
        return view('admin.produtos', compact('view','cats','prods'));
    }

    public function novoProduto(Request $request)
    {
        $prod = new Produto();
        $prod->nome = $request->input('nomeProduto');
        $prod->estoque = $request->input('estoqueProduto');
        $prod->categoria_id = $request->input('categoriaProduto');
        $prod->save();
        return back()->with('mensagem', 'Produto Cadastrado com Sucesso!')->with('type', 'success');
    }

    public function filtroProdutos(Request $request)
    {
        $nomeProd = $request->input('nomeProduto');
        $cat = $request->input('categoria');
        $ativo = $request->input('ativo');
        if(isset($nomeProd)){
            if(isset($cat)){
                $prods = Produto::where('ativo',"$ativo")->where('nome','like',"%$nomeProd%")->where('categoria_id',"$cat")->orderBy('nome')->paginate(100);
            } else {
                $prods = Produto::where('ativo',"$ativo")->where('nome','like',"%$nomeProd%")->orderBy('nome')->paginate(100);
            }
        } else {
            if(isset($cat)){
                $prods = Produto::where('ativo',"$ativo")->where('categoria_id',"$cat")->orderBy('nome')->paginate(100);
            } else {
                $prods = Produto::where('ativo',"$ativo")->orderBy('nome')->paginate(100);
            }
        }
        $cats = Categoria::orderBy('nome')->get();
        $view = "filtro";
        return view('admin.produtos', compact('view','cats','prods'));
    }

    public function editarProduto(Request $request, $id)
    {
        $prod = Produto::find($id);
        if(isset($prod)){
            $prod->nome =$request->input('nomeProduto');
            $prod->categoria_id =$request->input('categoriaProduto');
            $prod->save();
        }
        return back()->with('mensagem', 'Produto Alterado com Sucesso!')->with('type', 'success');
    }

    public function apagarProduto($id)
    {
        $prod = Produto::find($id);

        if(isset($prod)){
            if($prod->ativo==1){
                $prod->ativo = false;
                $prod->save();
                return back()->with('mensagem', 'Produto Inativado com Sucesso!')->with('type', 'success');
            } else {
                $prod->ativo = true;
                $prod->save();
                return back()->with('mensagem', 'Produto Ativado com Sucesso!')->with('type', 'success');
            }
        }
        
        return back();
    }

    //ENTRADAS & SAIDAS
    public function indexEntradaSaidas()
    {
        $rels = EntradaSaida::orderBy('created_at', 'desc')->paginate(10);
        $prods = Produto::orderBy('nome')->get();
        $view = "inicial";
        return view('admin.entrada_saida', compact('view','rels','prods'));
    }

    public function novaEntradaSaida(Request $request)
    {
        $tipo = $request->input('tipo');
        $qtd = $request->input('qtd');
        $prod = Produto::find($request->input('produto'));
        $es = new EntradaSaida();
        $es->tipo = $request->input('tipo');
        $es->produto_id = $request->input('produto');
        $es->produto_nome = $prod->nome;
        $es->quantidade = $request->input('qtd');
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
        if($tipo=="entrada"){
            return back()->with('mensagem', 'Entrada efetuada com Sucesso!')->with('type', 'success');
        } else {
            return back()->with('mensagem', 'Saída efetuada com Sucesso!')->with('type', 'success');
        }
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
        $prods = Produto::orderBy('nome')->get();
        $view = "filtro";
        return view('admin.entrada_saida', compact('view','rels','prods'));
    }

    //LISTAS DE COMPRAS
    public function indexListaCompras(){
        $listaProds = ListaCompra::with('produtos')->orderBy('created_at','desc')->paginate(10);
        return view('admin.lista_compra', compact('listaProds'));
    }

    public function selecionarListaCompra(){
        $prods = Produto::where('ativo',true)->orderBy('nome')->get();
        return view('admin.lista_compra_selecionar', compact('prods'));
    }

    public function novaListaCompra(Request $request){
        $prods = $request->input('produtos');
        $prodExtras = $request->input('produtosExtras');
        if($prods=="" && $prodExtras==""){
            return redirect('/admin/listaCompras')->with('mensagem', 'Lista não criada, nenhum item foi selecionado!')->with('type', 'warning');
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
        return redirect('/admin/listaCompras')->with('mensagem', 'Lista criada com Sucesso!')->with('type', 'success');
    }

    public function gerarPdfListaCompra($lista_id)
    {
        $lista = ListaCompra::find($lista_id);
        $produtos = CompraProduto::where('lista_compra_id',"$lista_id")->get();
        $produtoExtras = ProdutoExtra::where('lista_compra_id',"$lista_id")->get();
        $pdf = \PDF::loadView('admin.compras_pdf', compact('lista','produtos','produtoExtras'));
        return $pdf->setPaper('a4')->stream('ListaCompra'.date("d-m-Y", strtotime($lista->data)).'.pdf');
    }

    public function apagarListaCompra($id)
    {
        $ocorrencia = ListaCompra::find($id);
        if(isset($ocorrencia)){
            CompraProduto::where('lista_compra_id',"$id")->delete();
            $ocorrencia->delete();
        }
        return back()->with('mensagem', 'Lista excluída com Sucesso!')->with('type', 'success');
    }

    public function removerItem($lista_id, $produto_id)
    {
        CompraProduto::where('lista_compra_id',"$lista_id")->where('produto_id',"$produto_id")->delete();
        return back()->with('mensagem', 'Item removido com Sucesso!')->with('type', 'success');
    }

    public function removerItemExtra($lista_id, $produto)
    {
        ProdutoExtra::where('lista_compra_id',"$lista_id")->where('nome',"$produto")->delete();
        return back()->with('mensagem', 'Item removido com Sucesso!')->with('type', 'success');
    }

    //ATIVIDADES
    public function painelAtividades(){
        $profs = Prof::where('ativo',true)->orderBy('name')->get();
        $discs = Disciplina::where('ativo',true)->orderBy('nome')->get();
        $turmas = Turma::where('ativo',true)->get();
        $atividades = Atividade::orderBy('id','desc')->paginate(10);
        $view = "inicial";
        return view('admin.atividade_admin', compact('view','profs','discs','turmas','atividades'));
    }

    public function novaAtividade(Request $request)
    {
        $discId = $request->input('disciplina');
        $profId = $request->input('prof');
        $path = $request->file('arquivo')->store('atividades','public');
        $atividade = new Atividade();
        $atividade->prof_id = $profId;
        $atividade->disciplina_id = $discId;
        $atividade->turma_id = $request->input('turma');
        if($request->input('dataPublicacao')!=""){
            $atividade->data_publicacao = $request->input('dataPublicacao').' '.$request->input('horaPublicacao');
        }
        if($request->input('dataRemocao')!=""){
            $atividade->data_remocao = $request->input('dataRemocao').' '.$request->input('horaRemocao');
        }
        if($request->input('dataEntrega')!=""){
            $atividade->data_entrega = $request->input('dataEntrega').' '.$request->input('horaEntrega');
        }
        $atividade->retorno = $request->input('retorno');
        $atividade->descricao = $request->input('descricao');
        $atividade->link = $request->input('link');
        $atividade->visualizacoes = 0;
        $atividade->usuario = Auth::user()->name;
        $atividade->arquivo = $path;
        $atividade->save();
        
        return redirect('/admin/atividade');
    }

    public function filtroAtividade(Request $request)
    {
        $turma = $request->input('turma');
        $disciplina = $request->input('disciplina');
        $descricao = $request->input('descricao');
        $data = $request->input('data');
        if(isset($turma)){
            if(isset($disciplina)){
                if(isset($descricao)){
                    if(isset($data)){
                        $atividades = Atividade::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->where('turma_id',"$turma")->whereBetween('created_at',["$data"." 00:00", "$data"." 23:59"])->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = Atividade::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->where('turma_id',"$turma")->orderBy('id','desc')->paginate(50);
                    }
                } else {
                    $atividades = Atividade::where('turma_id',"$turma")->where('disciplina_id',"$disciplina")->orderBy('id','desc')->paginate(50);
                }
            } else {
                $atividades = Atividade::where('turma_id',"$turma")->orderBy('id','desc')->paginate(50);
            }
        } else {
            if(isset($disciplina)){
                if(isset($descricao)){
                    if(isset($data)){
                        $atividades = Atividade::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->whereBetween('created_at',["$data"." 00:00", "$data"." 23:59"])->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = Atividade::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->orderBy('id','desc')->paginate(50);
                    }
                } else {
                    $atividades = Atividade::where('disciplina_id',"$disciplina")->orderBy('id','desc')->paginate(50);
                }
            } else {
                if(isset($descricao)){
                    if(isset($data)){
                        $atividades = Atividade::where('descricao','like',"%$descricao%")->whereBetween('created_at',["$data"." 00:00", "$data"." 23:59"])->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = Atividade::where('descricao','like',"%$descricao%")->orderBy('id','desc')->paginate(50);
                    }
                } else {
                    if(isset($data)){
                        $atividades = Atividade::whereBetween('created_at',["$data"." 00:00", "$data"." 23:59"])->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = Atividade::orderBy('id','desc')->paginate(10);
                    }
                }
            }
        }
        $profs = Prof::where('ativo',true)->orderBy('name')->get();
        $discs = Disciplina::where('ativo',true)->orderBy('nome')->get();
        $turmas = Turma::where('ativo',true)->get();
        $view = "filtro";
        return view('admin.atividade_admin', compact('view','profs','discs','turmas','atividades'));
    }

    public function editarAtividade(Request $request, $id)
    {
        $atividade = Atividade::find($id);
        if($request->file('arquivo')!=""){
            $arquivo = $atividade->arquivo;
            Storage::disk('public')->delete($arquivo);
            $path = $request->file('arquivo')->store('atividades','public');
        } else {
            $path = "";
        }
        if($request->input('turma')!=""){
            $atividade->turma_id = $request->input('turma');
        }
        if($request->input('dataPublicacao')!=""){
            $atividade->data_publicacao = $request->input('dataPublicacao').' '.$request->input('horaPublicacao');
        }
        if($request->input('dataRemocao')!=""){
            $atividade->data_remocao = $request->input('dataRemocao').' '.$request->input('horaRemocao');
        }
        if($request->input('dataEntrega')!=""){
            $atividade->data_entrega = $request->input('dataEntrega').' '.$request->input('horaEntrega');
        }
        if($request->input('descricao')!=""){
            $atividade->descricao = $request->input('descricao');
        }
        if($request->input('link')!=""){
            $atividade->link = $request->input('link');
        }
        if($path!=""){
            $atividade->arquivo = $path;
        }
        if($request->input('retorno')!=""){
            $atividade->retorno = $request->input('retorno');
        }
        $atividade->save();
        
        return redirect('/admin/atividade');
    }

    public function apagarAtividade($id){
        $atividade = Atividade::find($id);
        if(isset($atividade)){
            $retornos = AtividadeRetorno::where('atividade_id',"$id")->get();
            if(isset($retornos)){
                foreach ($retornos as $retorno) {
                    $retorno->delete();
                    Storage::disk('public')->delete($retorno->arquivo);
                }
            }
            $atividade->delete();
            Storage::disk('public')->delete($atividade->arquivo);
        }
        return redirect('/admin/atividade');
    }

    public function downloadAtividade($id)
    {
        $atividade = Atividade::find($id);
        $disc = Disciplina::find($atividade->disciplina_id);
        $turma = Turma::find($atividade->turma_id);
        $nameFile = $turma->serie."º - Atividade ".$atividade->descricao." - ".$disc->nome;
        if(isset($atividade)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($atividade->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    public function retornos($atividade_id){
        $retornos = AtividadeRetorno::where('atividade_id',"$atividade_id")->get();
        $atividade = Atividade::find($atividade_id);
        $descricao = $atividade->descricao;
        return view('admin.retornos', compact('descricao','retornos'));
    }

    public function downloadRetorno($id)
    {
        $retorno = AtividadeRetorno::find($id);
        $alunoId = $retorno->aluno_id;
        $atividadeId = $retorno->atividade_id;
        $aluno = Aluno::find($alunoId);
        $nomeAluno = $aluno->name;
        $atividade = Atividade::find($atividadeId);
        $descricaoAtividade = $atividade->descricao;
        $turma = Turma::find($atividade->turma_id);
        $nameFile = $turma->serie."º - ".$descricaoAtividade." - ".$nomeAluno;
        if(isset($retorno)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($retorno->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    //ATIVIDADES COMPLEMENTARES
    public function painelAtividadesComplementares(){
        $profs = Prof::where('ativo',true)->orderBy('name')->get();
        $discs = Disciplina::where('ativo',true)->orderBy('nome')->get();
        $turmas = Turma::where('ativo',true)->get();
        $atividades = AtividadeComplementar::orderBy('id','desc')->paginate(10);
        $view = "inicial";
        return view('admin.atividades_complementares_admin', compact('view','profs','discs','turmas','atividades'));
    }

    public function novaAtividadeComplementar(Request $request)
    {
        $discId = $request->input('disciplina');
        $profId = $request->input('prof');
        $path = $request->file('arquivo')->store('atividadesComplementares','public');
        $atividade = new AtividadeComplementar();
        $atividade->prof_id = $profId;
        $atividade->disciplina_id = $discId;
        $atividade->turma_id = $request->input('turma');
        $atividade->data = $request->input('data');
        $atividade->descricao = $request->input('descricao');
        $atividade->arquivo = $path;
        $atividade->save();
        
        return back();
    }

    public function filtroAtividadesComplementares(Request $request)
    {
        $turma = $request->input('turma');
        $disciplina = $request->input('disciplina');
        $descricao = $request->input('descricao');
        $data = $request->input('data');
        if(isset($turma)){
            if(isset($disciplina)){
                if(isset($descricao)){
                    if(isset($data)){
                        $atividades = AtividadeComplementar::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->where('turma_id',"$turma")->where('data',"$data")->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = AtividadeComplementar::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->where('turma_id',"$turma")->orderBy('id','desc')->paginate(50);
                    }
                } else {
                    $atividades = AtividadeComplementar::where('turma_id',"$turma")->where('disciplina_id',"$disciplina")->orderBy('id','desc')->paginate(50);
                }
            } else {
                $atividades = AtividadeComplementar::where('turma_id',"$turma")->orderBy('id','desc')->paginate(50);
            }
        } else {
            if(isset($disciplina)){
                if(isset($descricao)){
                    if(isset($data)){
                        $atividades = AtividadeComplementar::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->where('data',"$data")->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = AtividadeComplementar::where('descricao','like',"%$descricao%")->where('disciplina_id',"$disciplina")->orderBy('id','desc')->paginate(50);
                    }
                } else {
                    $atividades = AtividadeComplementar::where('disciplina_id',"$disciplina")->orderBy('id','desc')->paginate(50);
                }
            } else {
                if(isset($descricao)){
                    if(isset($data)){
                        $atividades = AtividadeComplementar::where('descricao','like',"%$descricao%")->where('data',"$data")->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = AtividadeComplementar::where('descricao','like',"%$descricao%")->orderBy('id','desc')->paginate(50);
                    }
                } else {
                    if(isset($data)){
                        $atividades = AtividadeComplementar::where('data',"$data")->orderBy('id','desc')->paginate(50);
                    } else {
                        $atividades = AtividadeComplementar::orderBy('id','desc')->paginate(10);
                    }
                }
            }
        }
        $profs = Prof::where('ativo',true)->orderBy('name')->get();
        $discs = Disciplina::where('ativo',true)->orderBy('nome')->get();
        $turmas = Turma::where('ativo',true)->get();
        $view = "filtro";
        return view('admin.atividades_complementares_admin', compact('view','profs','discs','turmas','atividades'));
    }

    public function editarAtividadeComplementar(Request $request, $id)
    {
        $atividade = AtividadeComplementar::find($id);
        if($request->file('arquivo')!=""){
            $arquivo = $atividade->arquivo;
            Storage::disk('public')->delete($arquivo);
            $path = $request->file('arquivo')->store('atividadesComplementares','public');
        } else {
            $path = "";
        }
        if($request->input('turma')!=""){
            $atividade->turma_id = $request->input('turma');
        }
        if($request->input('data')!=""){
            $atividade->data = $request->input('data');
        }
        if($request->input('descricao')!=""){
            $atividade->descricao = $request->input('descricao');
        }
        if($path!=""){
            $atividade->arquivo = $path;
        }
        $atividade->save();
        
        return back();
    }

    public function apagarAtividadeComplementar($id){
        $atividade = AtividadeComplementar::find($id);
        if(isset($atividade)){
            Storage::disk('public')->delete($atividade->arquivo);
            $atividade->delete();
        }
        return back();
    }

    public function downloadAtividadeComplementar($id)
    {
        $atividade = AtividadeComplementar::find($id);
        $disc = Disciplina::find($atividade->disciplina_id);
        $turma = Turma::find($atividade->turma_id);
        $nameFile = $turma->serie."º - Atividade Complementar ".$atividade->descricao." - ".$disc->nome;
        if(isset($atividade)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($atividade->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    public function imprimirAtividadeComplementar($id){
        $atividade = AtividadeComplementar::find($id);
        if(isset($atividade)){
            if($atividade->impresso==false){
                $atividade->impresso = true;
                $atividade->save();
            } else {
                $atividade->impresso = false;
                $atividade->save();
            }
        }
        return back();
    }


    //LISTAS DE ATIVIDADES
    public function indexLAs(Request $request){
        $ano = $request->ano;
        $meses = DB::table('las')->select(DB::raw("mes"))->groupBy('mes')->orderBy('mes')->get();
        $las = La::where('ano',"$ano")->get();
        $anos = DB::table('las')->select(DB::raw("ano"))->groupBy('ano')->get();
        return view('admin.home_las_admin', compact('ano','anos','meses','las'));
    }

    public function indexLAsAno($ano){
        if($ano==""){
            $ano = date("Y");
        }
        $las = La::where('ano',"$ano")->get();
        $meses = DB::table('las')->select(DB::raw("mes"))->groupBy('mes')->orderBy('mes')->get();
        $anos = DB::table('las')->select(DB::raw("ano"))->groupBy('ano')->get();
        return view('admin.home_las_admin',compact('ano','anos','meses','las'));
    }

    public function novaLA(Request $request){
        if($request->input('data1')!=""){
            $la = new La();
            $la->mes = $request->input('mes');
            $la->semana = 1;
            $la->data = $request->input('data1');
            $la->ano = $request->input('ano');
            $la->save();
        }
        if($request->input('data2')!=""){
            $la = new La();
            $la->mes = $request->input('mes');
            $la->semana = 2;
            $la->data = $request->input('data2');
            $la->ano = $request->input('ano');
            $la->save();
        }
        if($request->input('data3')!=""){
            $la = new La();
            $la->mes = $request->input('mes');
            $la->semana = 3;
            $la->data = $request->input('data3');
            $la->ano = $request->input('ano');
            $la->save();
        }
        if($request->input('data4')!=""){
            $la = new La();
            $la->mes = $request->input('mes');
            $la->semana = 4;
            $la->data = $request->input('data4');
            $la->ano = $request->input('ano');
            $la->save();
        }
        if($request->input('data5')!=""){
            $la = new La();
            $la->mes = $request->input('mes');
            $la->semana = 5;
            $la->data = $request->input('data5');
            $la->ano = $request->input('ano');
            $la->save();
        }
        return back();
    }

    public function painelLAs($data){
        $lafund = ListaAtividade::where('dia', "$data")->where('ensino','fund')->count();
        $lamedio = ListaAtividade::where('dia', "$data")->where('ensino','medio')->count();
        if($lafund==0){
            $discs = Disciplina::where('ativo',true)->where('ensino','fund')->get();
            $turmas = Turma::select('serie')->where('ativo',true)->where('ensino','fund')->groupby('serie')->get();
            foreach($turmas as $turma){
                foreach($discs as $disc){
                    $lf = new ListaAtividade();
                    $lf->dia = $data;
                    $lf->serie = $turma->serie;
                    $lf->ensino = "fund";
                    $lf->disciplina_id = $disc->id;
                    $lf->save();
                }
            }
        }
        if($lamedio==0){
            $discs = Disciplina::where('ativo',true)->where('ensino','medio')->get();
            $turmas = Turma::where('ativo',true)->where('ensino','medio')->distinct('turma')->get();
            foreach($turmas as $turma){
                foreach($discs as $disc){
                    $lm = new ListaAtividade();
                    $lm->dia = $data;
                    $lm->serie = $turma->serie;
                    $lm->ensino = "medio";
                    $lm->disciplina_id = $disc->id;
                    $lm->save();
                }
            }
        }
        $fundTurmas = Turma::select('serie')->where('ativo',true)->groupby('serie')->where('ensino','fund')->get();
        $medioTurmas = Turma::select('serie')->where('ativo',true)->groupby('serie')->where('ensino','medio')->get();

        $anexosFund = ListaAtividade::where('dia', "$data")->where('ensino','fund')->distinct('disciplina_id')->get();
        $discIdsFund = array();
        foreach($anexosFund as $anexo){
            $discIdsFund[] = $anexo->disciplina_id;
        }
        $fundDiscs = Disciplina::orWhereIn('id', $discIdsFund)->where('ativo',true)->with('turmas')->orderBy('nome')->get();

        $anexosMed = ListaAtividade::where('dia', "$data")->where('ensino','medio')->distinct('disciplina_id')->get();
        $discIdsMed = array();
        foreach($anexosMed as $anexo){
            $discIdsMed[] = $anexo->disciplina_id;
        }
        $medioDiscs = Disciplina::orWhereIn('id', $discIdsMed)->where('ativo',true)->with('turmas')->orderBy('nome')->get();
        $laFunds = ListaAtividade::orderBy('disciplina_id')->where('dia', "$data")->where('ensino','fund')->get();
        $laMedios = ListaAtividade::orderBy('disciplina_id')->where('dia', "$data")->where('ensino','medio')->get();
        return view('admin.lista_atividade_admin',compact('data','fundTurmas','medioTurmas','fundDiscs','medioDiscs','laFunds','laMedios'));
    }

    public function anexarLA($id, Request $request)
    {
        $la = ListaAtividade::find($id);
        $path = $request->file('arquivo')->store('las','public');
        if($la->arquivo==null || $la->arquivo==""){
            $la->arquivo = $path;
            $la->save();
        } else {
            $arquivo = $la->arquivo;
            Storage::disk('public')->delete($arquivo);
            $la->arquivo = $path;
            $la->save();
        }
        return back();
    }

    public function downloadLA($id)
    {
        $la = ListaAtividade::find($id);
        $serie = $la->serie;
        $discId = $la->disciplina_id;
        $disciplina = Disciplina::find($discId);
        $nameFile = $serie."º - LA ".date("d-m-Y", strtotime($la->dia))." - ".$disciplina->nome;
        if(isset($la)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($la->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    public function apagarLA($id){
        $la = ListaAtividade::find($id);
        $arquivo = $la->arquivo;
        Storage::disk('public')->delete($arquivo);
        $la->arquivo = "";
        $la->save();
        return back();
    }

    //DIÁRIO
    public function indexDiario(){
        $turmas = Turma::where('ativo',true)->orderBy('ensino')->orderBy('serie')->get();
        return view('admin.home_diario', compact('turmas'));
    }

    public function consultaDiario(Request $request){
        $turmaId = $request->input('turma');
        $dia = $request->input('data');
        $turma = Turma::find($turmaId);
        $validador = Diario::where('turma_id',"$turmaId")->where('dia', "$dia")->count();
        if($validador>0){
            $diarios = Diario::where('turma_id',"$turmaId")->where('dia', "$dia")->orderBy('tempo')->get();
            $ocorrencias = Ocorrencia::where('data',"$dia")->get();
            return view('admin.diario_admin', compact('dia','turma','diarios','ocorrencias'));
        } else {
            return back()->with('mensagem', 'Sem lançamentos até o momento!')->with('type', 'warning');
        }
        
    }

    public function editarDiario(Request $request, $id)
    {
        $diario = Diario::find($id);
        if(isset($diario)){
            if($request->input('tempo')!=""){
                $diario->tempo = $request->input('tempo');
            }
            if($request->input('segundoTempo')!=""){
                if($request->input('segundoTempo')==1){
                    $diario->segundo_tempo = true;
                    if($request->input('outroTempo')!=""){
                        $diario->outro_tempo = $request->input('outroTempo');
                    }
                } else {
                    $diario->segundo_tempo = false;
                    $diario->outro_tempo = NULL;
                }
            }
            if($request->input('tema')!=""){
                $diario->tema = $request->input('tema');
            }
            if($request->input('conteudo')!=""){
                $diario->conteudo = $request->input('conteudo');
            }
            if($request->input('referencias')!=""){
                $diario->referencias = $request->input('referencias');
            }
            if($request->input('tipoTarefa')!=""){
                $diario->tipo_tarefa = $request->input('tipoTarefa');
            }
            if($request->input('tarefa')!=""){
                $diario->tarefa = $request->input('tarefa');
            }
            if($request->input('entregaTarefa')!=""){
                $diario->entrega_tarefa = $request->input('entregaTarefa');
            }
            $diario->save();
        }
        return back()->with('mensagem', 'Diário atualizado com Sucesso!')->with('type', 'success');
    }

    public function conferirDiario($id){
        $diario = Diario::find($id);
        $diario->conferido = true;
        $diario->save();
        return back()->with('mensagem', 'Diário conferido com Sucesso!')->with('type', 'success');
    }

    public function apagarDiario($id){
        $diario = Diario::find($id);
        if(isset($diario)){
            $diario->delete();
        }
        return back()->with('mensagem', 'Diário excluído com Sucesso!')->with('type', 'success');
    }
	
	public function relatorioDiario(){
        $turmas = Turma::orderBy('ensino')->orderBy('serie')->get();
        $discs = Disciplina::orderBy('nome')->orderBy('ensino')->get();
        $profs = Prof::orderBy('name')->get();
        return view('admin.diario_relatorio', compact('turmas','discs','profs'));
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
        $pdf = \PDF::loadView('admin.diario_relatorio_pdf', ['diarios'=>$diarios, 'turma'=>$turma, 'campos'=>$campos]);
        return $pdf->setPaper('a4')->stream('Relatório Diários - '.$turma->serie.'º Ano '.$turma->turma.'.pdf');
    }

    //OCORRENCIAS
    public function indexOcorrencias(){
        $alunos = Aluno::where('ativo',true)->orderBy('name')->get();
        $tipos = TipoOcorrencia::where('ativo',true)->get();
        $ocorrencias = Ocorrencia::orderBy('data','desc')->paginate(10);
        $view = "inicial";
        return view('admin.ocorrencias_admin', compact('view','alunos','tipos','ocorrencias'));
    }

    public function filtroOcorrencias(Request $request)
    {
        $tipo = $request->input('tipo');
        $aluno = $request->input('aluno');
        $dataInicio = $request->input('dataInicio');
        $dataFim = $request->input('dataFim');
        if(isset($tipo)){
            if(isset($aluno)){
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->where('aluno_id',"$aluno")->whereBetween('data',["$dataInicio", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->where('aluno_id',"$aluno")->whereBetween('data',["$dataInicio", date("Y/m/d")])->orderBy('data','desc')->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->where('aluno_id',"$aluno")->whereBetween('data',["", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->where('aluno_id',"$aluno")->orderBy('data','desc')->paginate(100);
                    }
                }
            } else {
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->whereBetween('data',["$dataInicio", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->whereBetween('data',["$dataInicio", date("Y/m/d")])->orderBy('data','desc')->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->whereBetween('data',["", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        $ocorrencias = Ocorrencia::where('tipo_ocorrencia_id',"$tipo")->orderBy('data','desc')->paginate(100);
                    }
                }
            }
        } else {
            if(isset($aluno)){
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::where('aluno_id',"$aluno")->whereBetween('data',["$dataInicio", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        $ocorrencias = Ocorrencia::where('aluno_id',"$aluno")->whereBetween('data',["$dataInicio", date("Y/m/d")])->orderBy('data','desc')->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::where('aluno_id',"$aluno")->whereBetween('data',["", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        $ocorrencias = Ocorrencia::where('aluno_id',"$aluno")->orderBy('data','desc')->paginate(100);
                    }
                }
            } else {
                if(isset($dataInicio)){
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::whereBetween('data',["$dataInicio", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        $ocorrencias = Ocorrencia::whereBetween('data',["$dataInicio", date("Y/m/d")])->orderBy('data','desc')->paginate(100);
                    }
                } else {
                    if(isset($dataFim)){
                        $ocorrencias = Ocorrencia::whereBetween('data',["", "$dataFim"])->orderBy('data','desc')->paginate(100);
                    } else {
                        return redirect('/admin/ocorrencias');
                    }
                }
            }
        }
        $alunos = Aluno::where('ativo',true)->orderBy('name')->get();
        $tipos = TipoOcorrencia::where('ativo',true)->get();
        $view = "filtro";
        return view('admin.ocorrencias_admin', compact('view','alunos','tipos','ocorrencias'));
    }

    public function editarOcorrencia(Request $request, $id)
    {
        $ocorrencia = Ocorrencia::find($id);
        if(isset($ocorrencia)){
            if($request->input('observacao')==""){
                $ocorrencia->observacao = "";
            } else { 
                $ocorrencia->observacao = $request->input('observacao');
            }
            $ocorrencia->save();
        }
        return back()->with('mensagem', 'Ocorrência atualizada com Sucesso!')->with('type', 'success');
    }

    public function aprovarOcorrencia($id){
        $ocorrencia = Ocorrencia::find($id);
        $ocorrencia->aprovado = true;
        $ocorrencia->save();
        return back()->with('mensagem', 'Ocorrência aprovada com Sucesso!')->with('type', 'success');
    }

    public function reprovarOcorrencia($id){
        $ocorrencia = Ocorrencia::find($id);
        $ocorrencia->aprovado = false;
        $ocorrencia->save();
        return back()->with('mensagem', 'Ocorrência reprovada com Sucesso!')->with('type', 'success');
    }

    public function apagarOcorrencia($id)
    {
        $ocorrencia = Ocorrencia::find($id);
        if(isset($ocorrencia)){
            $ocorrencia->delete();
        }
        return back();
    }

    //CONTEUDOS
    public function indexConteudos(Request $request){
        $ano = $request->input('ano');
        $anos = DB::table('conteudos')->select(DB::raw("ano"))->groupBy('ano')->get();
        return view('admin.home_conteudos',compact('ano','anos'));
    }

    public function indexConteudosAno($ano){
        if($ano==""){
            $ano = date("Y");
        }
        $anos = DB::table('conteudos')->select(DB::raw("ano"))->groupBy('ano')->get();
        return view('admin.home_conteudos',compact('ano','anos'));
    }

    public function painelConteudos($ano, $bim, $tipo){
        $validador = Conteudo::where('tipo', "$tipo")->where('bimestre',"$bim")->where('ano',"$ano")->count();
        if($validador==0){
            return back()->with('mensagem', 'Os campos para anexar os Conteúdos não foram gerados, por favor gerar!')->with('type', 'warning');
        } else {
            $fundTurmas = Turma::select('serie')->where('ensino','fund')->groupby('serie')->get();
            $medioTurmas = Turma::select('serie')->where('ensino','medio')->groupby('serie')->get();
            $fundDiscs = Disciplina::where('ensino','fund')->get();
            $medioDiscs = Disciplina::where('ensino','medio')->get();
            $contFunds = Conteudo::orderBy('disciplina_id')->where('tipo', "$tipo")->where('bimestre',"$bim")->where('ensino','fund')->where('ano',"$ano")->get();
            $contMedios = Conteudo::orderBy('disciplina_id')->where('tipo', "$tipo")->where('bimestre',"$bim")->where('ensino','medio')->where('ano',"$ano")->get();
            return view('admin.conteudos',compact('tipo','bim','fundTurmas','medioTurmas','fundDiscs','medioDiscs','contFunds','contMedios','ano'));
        }
    }

    public function gerarConteudos(Request $request){
        $tipos = $request->input('tipos');
        $ano = $request->input('ano');
        $bimestre = $request->input('bimestre');
        $discs = Disciplina::where('ativo',true)->get();
        $turmas = Turma::distinct('turma')->get();
        foreach($tipos as $tipo){
            foreach($turmas as $turma){
                $serie = $turma->serie;
                $ensino = $turma->ensino;
                    foreach($discs as $disc){
                        if($disc->ensino=="fund" && $ensino=="fund"){
                            $validador = Conteudo::where('tipo',"$tipo")->where('bimestre', "$bimestre")->where('ano', "$ano")->where('serie', "$serie")->where('ensino', 'fund')->where('disciplina_id', "$disc->id")->count();
                            if($validador == 0){
                                $cont = new Conteudo();
                                $cont->tipo = $tipo;
                                $cont->bimestre = $bimestre;
                                $cont->ano = $ano;
                                $cont->serie = $serie;
                                $cont->ensino = "fund";
                                $cont->disciplina_id = $disc->id;
                                $cont->save();
                            }
                        } else if($disc->ensino=="medio" && $ensino=="medio"){
                            $validador = Conteudo::where('tipo',"$tipo")->where('bimestre', "$bimestre")->where('ano', "$ano")->where('serie', "$serie")->where('ensino', 'medio')->where('disciplina_id', "$disc->id")->count();
                            if($validador == 0){
                                $cont = new Conteudo();
                                $cont->tipo = $tipo;
                                $cont->bimestre = $bimestre;
                                $cont->ano = $ano;
                                $cont->serie = $serie;
                                $cont->ensino = "medio";
                                $cont->disciplina_id = $disc->id;
                                $cont->save();
                            }
                        }
                    }
            }
        }
        return back()->with('mensagem', 'Conteúdos gerados com sucesso!')->with('type', 'success');
    }

    public function anexarConteudo(Request $request, $id)
    {
        $path = $request->file('arquivo')->store('conteudos','public');
        $cont = Conteudo::find($id);
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

    public function downloadConteudo($id)
    {
        $cont = Conteudo::find($id);
        $discId = $cont->disciplina_id;
        $disciplina = Disciplina::find($discId);
        $nameFile = $cont->serie."º - Conteúdo ".$cont->tipo." ".$cont->bimestre."º Bim - ".$disciplina->nome;
        if(isset($cont)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($cont->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    public function apagarConteudo($id){
        $cont = Conteudo::find($id);
        $arquivo = $cont->arquivo;
        Storage::disk('public')->delete($arquivo);
        $cont->arquivo = "";
        $cont->save();
        return back();
    }

    //RECADOS
    public function indexRecados(){
        $recados = Recado::with(['turma', 'aluno'])->paginate(10);
        $turmas = Turma::where('ativo',true)->get();
        $alunos = Aluno::where('ativo',true)->orderBy('name')->get();
        $view = "inicial";
        return view('admin.recados_admin', compact('view','recados','turmas','alunos'));
    }

    public function novoRecado(Request $request){
        if($request->input('geral')!=""){
            if($request->input('geral')==true){
                $recado = new Recado();
                $recado->titulo = $request->input('titulo');
                $recado->descricao = $request->input('descricao');
                $recado->geral = true;
                $recado->save();
                return back();
            } else{
                if($request->input('turma')!=""){
                    $recado = new Recado();
                    $recado->titulo = $request->input('titulo');
                    $recado->descricao = $request->input('descricao');
                    $recado->geral = false;
                    $recado->turma_id = $request->input('turma');
                    $recado->save();
                    return back();
                } else{
                    $recado = new Recado();
                    $recado->titulo = $request->input('titulo');
                    $recado->descricao = $request->input('descricao');
                    $recado->geral = false;
                    $recado->aluno_id = $request->input('aluno');
                    $recado->save();
                    return back();
                }
            }
        }
        return back();
    }

    public function filtroRecados(Request $request)
    {
        $titulo = $request->input('titulo');
        $dataInicio = $request->input('dataInicio');
        $dataFim = $request->input('dataFim');
        if(isset($titulo)){
            if(isset($dataInicio)){
                if(isset($dataFim)){
                    $recados = Recado::where('titulo','like',"%$titulo%")->whereBetween('data',["$dataInicio", "$dataFim"])->paginate(100);
                } else {
                    $recados = Recado::where('titulo','like',"%$titulo%")->whereBetween('data',["$dataInicio", date("Y/m/d")])->paginate(100);
                }
            } else {
                if(isset($dataFim)){
                    $recados = Recado::where('titulo','like',"%$titulo%")->whereBetween('data',["", "$dataFim"])->paginate(100);
                } else {
                    $recados = Recado::where('titulo','like',"%$titulo%")->paginate(100);
                }
            }
        } else {
            if(isset($dataInicio)){
                if(isset($dataFim)){
                    $recados = Recado::whereBetween('data',["$dataInicio", "$dataFim"])->paginate(100);
                } else {
                    $recados = Recado::whereBetween('data',["$dataInicio", date("Y/m/d")])->paginate(100);
                }
            } else {
                if(isset($dataFim)){
                    $recados = Recado::whereBetween('data',["", "$dataFim"])->paginate(100);
                } else {
                    $recados = Recado::paginate(10);
                }
            }
        }
        $turmas = Turma::where('ativo',true)->get();
        $alunos = Aluno::where('ativo',true)->orderBy('name')->get();
        $view = "filtro";
        return view('admin.recados_admin', compact('view','recados','turmas','alunos'));
    }

    public function editarRecado(Request $request, $id)
    {
        $recado = Recado::find($id);
        if($request->input('geral')!=""){
            if($request->input('geral')==true){
                $recado->titulo = $request->input('titulo');
                $recado->descricao = $request->input('descricao');
                $recado->geral = true;
                $recado->turma_id = NULL;
                $recado->aluno_id = NULL;
                $recado->save();
                return back();
            } else{
                if($request->input('turma')!=""){
                    $recado->titulo = $request->input('titulo');
                    $recado->descricao = $request->input('descricao');
                    $recado->geral = false;
                    $recado->turma_id = $request->input('turma');
                    $recado->aluno_id = NULL;
                    $recado->save();
                    return back();
                } else{
                    $recado->titulo = $request->input('titulo');
                    $recado->descricao = $request->input('descricao');
                    $recado->geral = false;
                    $recado->aluno_id = $request->input('aluno');
                    $recado->turma_id = NULL;
                    $recado->save();
                    return back();
                }
            }
        }
        return back();
    }

    public function apagarRecado($id)
    {
        $recado = Recado::find($id);
        if(isset($recado)){
            $recado->delete();
        }
        return back();
    }

    //ATIVIDADES EXTRAS
    public function painelAEs($ano, $n, $bim){
        $validador = AtividadeExtra::where('numero', "$n")->where('bimestre',"$bim")->where('ano',"$ano")->count();
        if($validador==0){
            return back()->with('mensagem', 'Os campos para anexar as AEs não foram gerados, por favor gerar!')->with('type', 'warning');
        } else {
            $fundTurmas = Turma::select('serie')->where('ativo',true)->where('ensino','fund')->groupby('serie')->get();
            $medioTurmas = Turma::select('serie')->where('ativo',true)->where('ensino','medio')->groupby('serie')->get();
            $fundDiscs = Disciplina::where('ativo',true)->where('ensino','fund')->get();
            $medioDiscs = Disciplina::where('ativo',true)->where('ensino','medio')->get();
            $aeFunds = AtividadeExtra::orderBy('disciplina_id')->where('numero', "$n")->where('bimestre',"$bim")->where('ensino','fund')->get();
            $aeMedios = AtividadeExtra::orderBy('disciplina_id')->where('numero', "$n")->where('bimestre',"$bim")->where('ensino','medio')->get();
            return view('admin.atividade_extra',compact('fundTurmas','medioTurmas','fundDiscs','medioDiscs','aeFunds','aeMedios'));
        }
    }

    public function gerarAEs(Request $request){
        $bimestre = $request->input('bimestre');
        $qtd = $request->input('qtd');
        $discs = Disciplina::where('ativo',true)->get();
        $ano = date("Y");
        $turmas = Turma::distinct('turma')->get();
        for($i=1; $i<=$qtd; $i++){
                foreach($turmas as $turma){
                    $serie = $turma->serie;
                    $ensino = $turma->ensino;
                    foreach($discs as $disc){
                        if($disc->ensino=="fund" && $ensino=="fund"){
                            $validador = AtividadeExtra::where('numero',"$i")->where('bimestre', "$bimestre")->where('ano', "$ano")->where('serie', "$serie")->where('ensino', 'fund')->where('disciplina_id', "$disc->id")->count();
                            if($validador == 0){
                                $ae = new AtividadeExtra();
                                $ae->numero = $i;
                                $ae->bimestre = $bimestre;
                                $ae->ano = $ano;
                                $ae->serie = $serie;
                                $ae->ensino = "fund";
                                $ae->disciplina_id = $disc->id;
                                $ae->save();
                            }
                        } else if($disc->ensino=="medio" && $ensino=="medio"){
                            $validador = AtividadeExtra::where('numero',"$i")->where('bimestre', "$bimestre")->where('ano', "$ano")->where('serie', "$serie")->where('ensino', 'medio')->where('disciplina_id', "$disc->id")->count();
                            if($validador == 0){
                                $ae = new AtividadeExtra();
                                $ae->numero = $i;
                                $ae->bimestre = $bimestre;
                                $ae->ano = $ano;
                                $ae->serie = $serie;
                                $ae->ensino = "medio";
                                $ae->disciplina_id = $disc->id;
                                $ae->save();
                            }
                        }
                    }
                }
        }
        return back()->with('mensagem', 'AEs geradas com sucesso!')->with('type', 'success');
    }

    public function anexarAE(Request $request, $id)
    {
        $path = $request->file('arquivo')->store('aes','public');
        $ae = AtividadeExtra::find($id);
        if($ae->arquivo=="" || $ae->arquivo==null){
            $ae->arquivo = $path;
            $ae->save();
        } else {
            $arquivo = $ae->arquivo;
            Storage::disk('public')->delete($arquivo);
            $ae->arquivo = $path;
            $ae->save();
        }
        return back();
    }

    public function downloadAE($id)
    {
        $ae = AtividadeExtra::find($id);
        $discId = $ae->disciplina_id;
        $disciplina = Disciplina::find($discId);
        $nameFile = $ae->serie."º - AE 0".$ae->numero." ".$ae->bimestre."º Bim - ".$disciplina->nome;
        if(isset($ae)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($ae->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    public function apagarAE($id){
        $ae = AtividadeExtra::find($id);
        $arquivo = $ae->arquivo;
        Storage::disk('public')->delete($arquivo);
        $ae->arquivo = "";
        $ae->save();
        return back();
    }

    //SIMULADOS
    public function indexSimulados(Request $request){
        $ano = $request->input('ano');
        $turmas = Turma::where('ativo',true)->orderBy('serie')->get();
        $anos = DB::table('simulados')->select(DB::raw("ano"))->groupBy('ano')->get();
        $provas = Simulado::where('ano',"$ano")->orderBy('prazo', 'desc')->get();
        return view('admin.home_provas',compact('ano','turmas','anos','provas'));
    }

    public function indexSimuladosAno($ano){
        if($ano==""){
            $ano = date("Y");
        }
        $turmas = Turma::where('ativo',true)->orderBy('serie')->get();
        $anos = DB::table('simulados')->select(DB::raw("ano"))->groupBy('ano')->get();
        $provas = Simulado::where('ano',"$ano")->orderBy('prazo', 'desc')->get();
        return view('admin.home_provas',compact('ano','turmas','anos','provas'));
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

    public function editarSimulado(Request $request, $id){
        $prova = Simulado::find($id);
        $prova->prazo = $request->input('prazo');
        $prova->descricao = $request->input('descricao');
        $prova->save();
        return back();
    }

    public function painelSimulados($provaId){
        $prova = Simulado::find($provaId);
        $ano = $prova->ano;
        $fundSeries = "";
        $fundTurmas = "";
        $fundDiscs = "";
        $contFunds = "";
        $medioTurmas = "";
        $medioDiscs = "";
        $contMedios = "";
        $medioSeries = "";
        $ensino = "";
        $provaTurmas = array();
        $turmasSimulado = ConteudoProva::where('simulado_id', "$provaId")->select(DB::raw("turma_id"))->groupBy('turma_id')->get();
        foreach($turmasSimulado as $turma){
            $provaTurmas[] = $turma->turma_id;
        }
        $fundTurmas = Turma::whereIn('id',$provaTurmas)->where('ensino','fund')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        if(isset($fundTurmas)){
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
        }
        $medioTurmas = Turma::whereIn('id',$provaTurmas)->where('ensino','medio')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        if(isset($medioTurmas)){
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
        }
        if($validadorFund!=0 && $validadorMedio!=0){
            $ensino = "todos";
        }
        if($validadorFund==0 && $validadorMedio==0){
            return back()->with('mensagem', 'Não foram criados campos de conteúdos para essa prova!')->with('type', 'warning');
        }
        return view('admin.provas',compact('ensino','prova','ano','fundSeries','fundTurmas','medioSeries','medioTurmas','fundDiscs','medioDiscs','contFunds','contMedios'));
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

    public function apagarSimulado($id){
        $prova = Simulado::find($id);
        if(isset($prova)){
            $quests = Questao::where('simulado_id',"$id")->get();
            foreach($quests as $quest){
                $questao = Questao::find($quest->id);
                if($questao->arquivo!=""){
                    Storage::disk('public')->delete($questao->arquivo);
                }
                $questao->delete();
            }
            $prova->delete();
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
        $turmasSimulado = "";
        $fundSeries = "";
        $fundTurmas = "";
        $fundDiscs = "";
        $contFunds = "";
        $medioSeries = "";
        $medioTurmas = "";
        $medioDiscs = "";
        $contMedios = "";
        $ensino = "";
        $provaTurmas = array();
        $turmasSimulado = ConteudoProva::where('simulado_id', "$provaId")->select(DB::raw("turma_id"))->groupBy('turma_id')->get();
        foreach($turmasSimulado as $turma){
            $provaTurmas[] = $turma->turma_id;
        }
        $fundTurmas = Turma::whereIn('id',$provaTurmas)->where('ensino','fund')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        
        if(isset($fundTurmas)){
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
        }
        
        $medioTurmas = Turma::whereIn('id',$provaTurmas)->where('ensino','medio')->where('ativo',true)->orderBy('serie')->orderBy('turma')->get();
        if(isset($medioTurmas)){
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
        }
        if($validadorFund!=0 && $validadorMedio!=0){
            $ensino = "todos";
        } 
        if($validadorFund==0 && $validadorMedio==0){
            return back()->with('mensagem', 'Não foram criados campos de conteúdos para essa prova!')->with('type', 'warning');
        }
        return view('admin.conteudos_provas',compact('ensino','prova','ano','fundSeries','fundTurmas','medioSeries','medioTurmas','fundDiscs','medioDiscs','contFunds','contMedios'));
    }

    public function anexarConteudoProva(Request $request, $id)
    {
        $cont = ConteudoProva::find($id);
        $cont->descricao = $request->input('descricao');
        $cont->save();

        return back();
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
        $pdf = \PDF::loadView('admin.conteudos_pdf', compact('turma','prova','discs','profs','conteudos'));
        return $pdf->setPaper('a4')->stream($turma->serie.'º'. $turma->turma .' - Conteúdos '.$prova->descricao.' - '.$prova->bimestre.'º Bimestre'.'.pdf');
    }


    //PLANEJAMENTOS
    public function indexPlanejamentos(Request $request){
        $ano = $request->input('ano');
        $anos = DB::table('planejamentos')->select(DB::raw("ano"))->groupBy('ano')->get();
        $planejamentos = Planejamento::where('ano',"$ano")->get();
        return view('admin.home_planejamentos',compact('ano','anos','planejamentos'));
    }

    public function indexPlanejamentosAno($ano){
        if($ano==""){
            $ano = date("Y");
        }
        $anos = DB::table('planejamentos')->select(DB::raw("ano"))->groupBy('ano')->get();
        $planejamentos = Planejamento::where('ano',"$ano")->get();
        return view('admin.home_planejamentos',compact('ano','anos','planejamentos'));
    }
    //DB::table('questao_simulados')->select(DB::raw('id, descricao, bimestre, ano'))->groupByRaw('id, descricao, bimestre, ano')->get();
    
    public function gerarPlanejamentos(Request $request){
        $sim = new Planejamento();
        $sim->descricao = $request->input('descricao');
        $sim->ano = $request->input('ano');
        $sim->save();
        $turmas = Turma::where('ativo',true)->where('turma','A')->get();
        $discs = Disciplina::where('ativo',true)->get();
        foreach($turmas as $turma){
            $serie = $turma->serie;
            $ensino = $turma->ensino;
            foreach($discs as $disc){
                if($disc->ensino=="fund" && $ensino=="fund"){
                    $validador = AnexoPlanejamento::where('planejamento_id', "$sim->id")->where('serie', "$serie")->where('ensino', 'fund')->where('disciplina_id', "$disc->id")->count();
                    if($validador == 0){
                        $quest = new AnexoPlanejamento();
                        $quest->planejamento_id = $sim->id;
                        $quest->serie = $serie;
                        $quest->ensino = "fund";
                        $quest->disciplina_id = $disc->id;
                        $quest->save();
                    }
                } else if($disc->ensino=="medio" && $ensino=="medio"){
                    $validador = AnexoPlanejamento::where('planejamento_id', "$sim->id")->where('serie', "$serie")->where('ensino', 'medio')->where('disciplina_id', "$disc->id")->count();
                    if($validador == 0){
                        $quest = new AnexoPlanejamento();
                        $quest->planejamento_id = $sim->id;
                        $quest->serie = $serie;
                        $quest->ensino = "medio";
                        $quest->disciplina_id = $disc->id;
                        $quest->save();
                    }
                }
            }
        }
        return back()->with('mensagem', 'Campos para anexar os planejamentos gerados com sucesso!')->with('type', 'success');
    }

    public function painelPlanejamentos($simId){
        $planejamento = Planejamento::find($simId);
        $ano = $planejamento->ano;
        $fundTurmas = "";
        $fundDiscs = "";
        $contFunds = "";
        $medioTurmas = "";
        $medioDiscs = "";
        $contMedios = "";
        $ensino = "";
        $anexosFund = AnexoPlanejamento::where('planejamento_id',"$simId")->where('ensino','fund')->distinct('disciplina_id')->get();
        $discIdsFund = array();
        foreach($anexosFund as $anexo){
            $discIdsFund[] = $anexo->disciplina_id;
        }
        $fundTurmas = DB::table('anexo_planejamentos')->where('planejamento_id', "$simId")->where('ensino','fund')->select(DB::raw("serie"))->groupBy('serie')->get();
        $fundDiscs = Disciplina::orWhereIn('id', $discIdsFund)->where('ativo',true)->with('turmas')->orderBy('nome')->get();
        $contFunds = AnexoPlanejamento::where('planejamento_id', "$simId")->where('ensino','fund')->orderBy('disciplina_id')->get();

        $anexosMed = AnexoPlanejamento::where('planejamento_id',"$simId")->where('ensino','medio')->distinct('disciplina_id')->get();
        $discIdsMed = array();
        foreach($anexosMed as $anexo){
            $discIdsMed[] = $anexo->disciplina_id;
        }
        $medioTurmas = DB::table('anexo_planejamentos')->where('planejamento_id', "$simId")->where('ensino','medio')->select(DB::raw("serie"))->groupBy('serie')->get();
        $medioDiscs = Disciplina::orWhereIn('id', $discIdsMed)->where('ativo',true)->with('turmas')->orderBy('nome')->get();
        $contMedios = AnexoPlanejamento::where('planejamento_id', "$simId")->where('ensino','medio')->orderBy('disciplina_id')->get();
        return view('admin.planejamentos',compact('planejamento','ano','fundTurmas','medioTurmas','fundDiscs','medioDiscs','contFunds','contMedios'));
    }

    public function anexarPlanejamento(Request $request, $id)
    {
        $path = $request->file('arquivo')->store('anexosPlanejamentos','public');
        $cont = AnexoPlanejamento::find($id);
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

    public function downloadPlanejamento($id)
    {
        $cont = AnexoPlanejamento::find($id);
        $discId = $cont->disciplina_id;
        $disciplina = Disciplina::find($discId);
        $planejamento = Planejamento::find($cont->planejamento_id);
        $nameFile = $cont->serie."º - Planejamento ".$planejamento->descricao." - ".$disciplina->nome;
        if(isset($cont)){
            $path = Storage::disk('public')->getDriver()->getAdapter()->applyPathPrefix($cont->arquivo);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $name = $nameFile.".".$extension;
            return response()->download($path, $name);
        }
        return back();
    }

    public function apagarPlanejamento($id){
        $sim = Planejamento::find($id);
        if(isset($sim)){
            $quests = AnexoPlanejamento::where('planejamento_id',"$id")->get();
            foreach($quests as $quest){
                $questao = AnexoPlanejamento::find($quest->id);
                if($questao->arquivo!=""){
                    Storage::disk('public')->delete($questao->arquivo);
                }
                $questao->delete();
            }
            $sim->delete();
        }
        return back();
    }

    public function conferirPlanejamento(Request $request)
    {
        $id = $request->id;
        $cont = AnexoPlanejamento::find($id);
        $cont->comentario = $request->comentario;
        $cont->conferido = true;
        $cont->save();
        return back();
    }

    //DOCUMENTOS
    public function painelDocumentos(){
        $documentos = Documento::orderBy('id','desc')->paginate(10);
        $view = "inicial";
        return view('admin.documentos_admin', compact('view','documentos'));
    }

    public function novoDocumento(Request $request)
    {
        $path = $request->file('arquivo')->store('documentos','public');
        $atividade = new Documento();
        if($request->input('dataPublicacao')!=""){
            $atividade->data_publicacao = $request->input('dataPublicacao').' '.$request->input('horaPublicacao');
        }
        if($request->input('dataRemocao')!=""){
            $atividade->data_remocao = $request->input('dataRemocao').' '.$request->input('horaRemocao');
        }
        $atividade->titulo = $request->input('titulo');
        //$atividade->usuario = Auth::user()->name;
        $atividade->arquivo = $path;
        $atividade->save();
        
        return back()->with('mensagem', 'Documento adicionado com sucesso!')->with('type', 'success');
    }

    public function filtroDocumento(Request $request)
    {
        $titulo = $request->input('titulo');
        if(isset($titulo)){
            $documentos = Documento::where('titulo',"%$titulo%")->orderBy('id','desc')->paginate(50);
        } else {
            return redirect('/admin/documento');
        }
        $view = "filtro";
        return view('admin.documentos_admin', compact('view','documentos'));
    }

    public function editarDocumento(Request $request, $id)
    {
        $documento = Documento::find($id);
        if($request->file('arquivo')!=""){
            $arquivo = $documento->arquivo;
            Storage::disk('public')->delete($arquivo);
            $path = $request->file('arquivo')->store('documentos','public');
        } else {
            $path = "";
        }
        if($request->input('dataPublicacao')!=""){
            $documento->data_publicacao = $request->input('dataPublicacao').' '.$request->input('horaPublicacao');
        }
        if($request->input('dataRemocao')!=""){
            $documento->data_remocao = $request->input('dataRemocao').' '.$request->input('horaRemocao');
        }
        if($request->input('titulo')!=""){
            $documento->titulo = $request->input('titulo');
        }
        $documento->save();
        
        return back()->with('mensagem', 'Documento alterado com sucesso!')->with('type', 'success');
    }

    public function apagarDocumento($id){
        $documento = Documento::find($id);
        if(isset($documento)){
            $documento->delete();
            Storage::disk('public')->delete($documento->arquivo);
        }
        return back()->with('mensagem', 'Documento excluído com sucesso!')->with('type', 'success');
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
        return view('admin.lembretes_admin', compact('view','lembretes'));
    }

    public function novoLembrete(Request $request)
    {
        $lembrete = new Lembrete();
        if($request->input('dataPublicacao')!=""){
            $lembrete->data_publicacao = $request->input('dataPublicacao').' '.$request->input('horaPublicacao');
        }
        if($request->input('dataRemocao')!=""){
            $lembrete->data_remocao = $request->input('dataRemocao').' '.$request->input('horaRemocao');
        }
        $lembrete->titulo = $request->input('titulo');
        $lembrete->conteudo = $request->input('conteudo');
        //$atividade->usuario = Auth::user()->name;

        $lembrete->save();
        
        return back()->with('mensagem', 'Lembrete adicionado com sucesso!')->with('type', 'success');
    }

    public function filtroLembrete(Request $request)
    {
        $titulo = $request->input('titulo');
        if(isset($titulo)){
            $lembretes = Lembrete::where('titulo',"%$titulo%")->orderBy('id','desc')->paginate(50);
        } else {
            return redirect('/admin/lembrete');
        }
        $view = "filtro";
        return view('admin.lembretes_admin', compact('view','lembretes'));
    }

    public function editarLembrete(Request $request, $id)
    {
        $lembrete = Lembrete::find($id);
        if($request->input('dataPublicacao')!=""){
            $lembrete->data_publicacao = $request->input('dataPublicacao').' '.$request->input('horaPublicacao');
        }
        if($request->input('dataRemocao')!=""){
            $lembrete->data_remocao = $request->input('dataRemocao').' '.$request->input('horaRemocao');
        }
        if($request->input('titulo')!=""){
            $lembrete->titulo = $request->input('titulo');
        }
        if($request->input('conteudo')!=""){
            $lembrete->conteudo = $request->input('conteudo');
        }
        $lembrete->save();
        
        return back()->with('mensagem', 'Lembrete alterado com sucesso!')->with('type', 'success');
    }

    public function apagarLembrete($id){
        $lembrete = Lembrete::find($id);
        if(isset($lembrete)){
            $lembrete->delete();
        }
        return back()->with('mensagem', 'Lembrete excluído com sucesso!')->with('type', 'success');
    }
}
