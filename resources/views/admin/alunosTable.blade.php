<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Login</th>
            <th>Turma(s)</th>
            <th>Ativo</th>
            <th>Criação</th>
            <th>Última Atualização</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($alunos as $aluno)
        <tr>
            <td>{{$aluno->id}}</td>
            <td>{{$aluno->name}}</td>
            <td>{{$aluno->email}}</td>
            <td>
                @foreach ($aluno->turmas as $turma)
                <b @if($turma->ativo==false) style="color: red;" @endif>- {{$turma->serie}}º{{$turma->turma}}{{$turma->turno}} </b>
                @endforeach
            </td>
            <td>@if($aluno->ativo==1)Sim @else Não @endif</td>
            <td>{{$aluno->created_at->format('d/m/Y H:i') }}</td>
            <td>{{$aluno->updated_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>