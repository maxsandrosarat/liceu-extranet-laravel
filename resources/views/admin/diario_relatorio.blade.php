@extends('layouts.app', ["current"=>"pedagogico"])

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border">
                <div class="card-body">
                    <div class="row">
                        <div class="col" style="text-align: left">
                        <a href="/admin/diario" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Voltar"><i class="material-icons white">reply</i></a>
                        </div>
                    </div>
                    <br/>
                    <h5 class="card-title">Relatório de Diários</h5><span><b>**Selecione no mínimo a turma**</b></span>
                    @if(session('mensagem'))
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">x</button>
                                    <p>{{session('mensagem')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <form class="row g-3" id="form-relatorio" method="POST" action="/admin/diario/relatorio">
                        @csrf
                        <div class="col-auto form-floating"> 
                            <input class="form-control" type="date" id="dataInicio" name="dataInicio" required>
                            <label for="dataInicio">Entre / A partir</label>
                        </div>
                        <div class="col-auto form-floating">
                            <input class="form-control" type="date" placeholder="E / Até" id="dataFim" name="dataFim">
                            <label for="dataFim">E / Até</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select mr-sm-2" id="turma" name="turma" required>
                                <option value="">Selecione</option>
                                    @foreach ($turmas as $turma)
                                    <option @if($turma->ativo==false) style="color: red;" @endif value="{{$turma->id}}">{{$turma->serie}}º{{$turma->turma}}{{$turma->turno}}</option>
                                    @endforeach
                            </select>
                            <label for="turma">Turma</label>
                        </div>
                        <div class="col-auto form-floating">
                        <select class="form-select" id="disciplina" name="disciplina">
                                <option value="">Selecione</option>
                                @foreach ($discs as $disc)
                                    <option @if($disc->ativo==false) style="color: red;" @endif value="{{$disc->id}}">{{$disc->nome}} (@if($disc->ensino=="fund") Fundamental @else Médio @endif)</option>
                                @endforeach
                            </select>
                            <label for="disciplina">Disciplina</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="prof" name="prof">
                                <option value="">Selecione</option>
                                    @foreach ($profs as $prof)
                                    <option @if($prof->ativo==false) style="color: red;" @endif value="{{$prof->id}}">{{$prof->name}}</option>
                                    @endforeach
                            </select>
                            <label for="prof">Professor(a)</label>
                        </div>
                        <div class="col-auto form-floating">
                            <select class="form-select" id="conferido" name="conferido">
                                <option value="">Selecione</option>
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                            <label for="conferido">Conferido</label>
                        </div>
                        <hr/>
                            <div>
                                <h3>Campos do Relatório</h3>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="disciplina" name="campos[]" value="disciplina" checked>
                                    <label class="form-check-label" for="disciplina">Disciplina</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="prof" name="campos[]" value="prof" checked>
                                    <label class="form-check-label" for="prof">Professor(a)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tema" name="campos[]" value="tema" checked>
                                    <label class="form-check-label" for="tema">Tema</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="conteudo" name="campos[]" value="conteudo" checked>
                                    <label class="form-check-label" for="conteudo">Conteúdo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="referencia" name="campos[]" value="referencia" checked>
                                    <label class="form-check-label" for="referencia">Referências</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tarefa" name="campos[]" value="tarefa" checked>
                                    <label class="form-check-label" for="tarefa">Tarefa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tempos" name="campos[]" value="tempos">
                                    <label class="form-check-label" for="tempos">Tempos</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="tipoTarefa" name="campos[]" value="tipoTarefa">
                                    <label class="form-check-label" for="tipoTarefa">Tipo de Tarefa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="entregaTarefa" name="campos[]" value="entregaTarefa">
                                    <label class="form-check-label" for="entregaTarefa">Entrega da Tarefa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="conferido" name="campos[]" value="conferido">
                                    <label class="form-check-label" for="conferido">Conferido</label>
                                </div>
                                <hr/>
                                <div class="modal-footer" id="processamento">
                                    <button id="btn-submit" type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection