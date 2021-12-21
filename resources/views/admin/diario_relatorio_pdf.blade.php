<html>
    <head>
        <title>Relatório Diários - Turma: {{$turma->serie}}º Ano {{$turma->turma}}</title>
        <link rel="shortcut icon" href="{{ base_path().'/public/storage/favicon.png' }}"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ base_path().'/public_html/css/pdf.css' }}">
    </head>
    <body>
    <div class="card border">
        <div class="card-body" style="text-align: center;">
            <header>
                <div id="logos">
                    <img src="{{ base_path().'/public_html/storage/logo_liceu.png' }}" width="150"/>
                </div>
                <div id="cabeçalho">
                    <p style="color: #191970;"><b>RELATÓRIO DE DIÁRIOS </b><br/>
                        Turma: {{$turma->serie}}º Ano {{$turma->turma}}
                    </p>
                </div>
            </header>
            <main>
                @php
                    $todos = false;
                    $tempos = false;
                    $disciplina = false;
                    $prof = false;
                    $tema = false;
                    $conteudo = false;
                    $referencia = false;
                    $tarefa = false;
                    $tipoTarefa = false;
                    $entregaTarefa = false;
                    $conferido = false;
                    foreach($campos as $campo){
                        if($campo=="tempos"){
                            $tempos = true;
                        } else if($campo=="disciplina"){
                            $disciplina = true;
                        } else if($campo=="prof"){
                            $prof = true;
                        } else if($campo=="tema"){
                            $tema = true;
                        } else if($campo=="conteudo"){
                            $conteudo = true;
                        } else if($campo=="referencia"){
                            $referencia = true;
                        } else if($campo=="tarefa"){
                            $tarefa = true;
                        } else if($campo=="tipoTarefa"){
                            $tipoTarefa = true;
                        } else if($campo=="entregaTarefa"){
                            $entregaTarefa = true;
                        } else if($campo=="conferido"){
                            $conferido = true;
                        } else {
                            $todos = true;
                        }
                    }
                @endphp
                @if(count($diarios)==0)
                    <div class="alert alert-warning" role="alert">
                    Sem diários lançados para os critérios escolhidos!
                    </div>
                @else
                <table class="table table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Dia</th>
                            <th>Diários</th>
                        </tr>
                    </thead>
                    @php
                        $trocouData = false;
                        $dataAtual = "";
                    @endphp
                    <tbody>
                        @foreach ($diarios as $diario)
                        @php
                            if($dataAtual!==$diario->dia){
                                $dataAtual = $diario->dia;
                                $trocouData = true;
                            } else {
                                $trocouData = false;
                            }
                        @endphp
                        <tr>
                            <td style="white-space: nowrap; width: 70px; @if($trocouData) border-top: 2px solid black; @endif">{{date("d/m/Y", strtotime($diario->dia))}}</td>
                            <td @if($trocouData) style="border-top: 2px solid black;" @endif>
                                @if($tempos) Tempo(s): {{$diario->tempo}}º @if($diario->segundo_tempo) & {{$diario->outro_tempo}}º @endif <br/> @endif
                                @if($disciplina) Disciplina: {{$diario->disciplina->nome}} <br/> @endif
                                @if($prof) Professor(a): {{$diario->prof->name}} <br/> @endif
                                @if($tema) Tema: {{$diario->tema}}<br/> @endif
                                @if($conteudo) Conteúdo: {{$diario->conteudo}}<br/> @endif
                                @if($referencia)  Referências: {{$diario->referencias}}<br/> @endif
                                @if($tarefa) Tarefa: {{$diario->tarefa}}<br/> @endif
                                @if($tipoTarefa) Tipo de Tarefa: @if($diario->tipo_tarefa=="AULA") VISTADA EM AULA @else ENVIADA NO SCULES @endif<br/> @endif
                                @if($entregaTarefa) Entrega da Tarefa: {{date("d/m/Y", strtotime($diario->entrega_tarefa))}}<br/> @endif
                                @if($conferido) Conferido: @if($diario->conferido) Sim @else Não @endif @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </main>
        </div>
    </div>
    </body>
</html>