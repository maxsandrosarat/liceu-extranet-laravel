<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>{{$turma->serie}} º Ano {{$turma->turma}} - Conteúdos {{$prova->descricao}} - {{$prova->bimestre}}º Bimestre</title>
        <link rel="shortcut icon" href="/storage/favicon.png"/>
    </head>
    <body>
    <div class="card border">
        <div class="card-body" style="text-align: center;">
            <img src="storage/liceu.png" width="150"/>
            <h5 class="card-title">Turma: {{$turma->serie}} º Ano {{$turma->turma}}<br/>
            Conteúdos da Prova: {{$prova->descricao}} - {{$prova->bimestre}}º Bimestre</h5>
     
            <table class="table table-striped table-bordered table-sm">
                <thead class="thead-dark" style="font-size: 80%; text-align: center;">
                    <tr>
                        <th>Disciplina</th>
                        <th>Professor(a)</th>
                        <th>Conteúdo</th>
                    </tr>
                </thead>
                <tbody style="font-size: 65%;">
                    @foreach ($discs as $disc)
                        @foreach ($conteudos as $conteudo)
                            @if($conteudo->descricao!='')
                                @if($conteudo->disciplina->id==$disc->id)
                                <tr>
                                    <td style="text-align: center;">{{$conteudo->disciplina->nome}}</td>
                                    <td style="text-align: center;">
                                        @foreach ($profs as $prof)
                                            @foreach ($prof->disciplinas as $disciplina)
                                                @if($disciplina->id==$disc->id)<b>{{$prof->name}}</b>@endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>{!!nl2br($conteudo->descricao)!!}</td>
                                </tr>
                                @endif
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>