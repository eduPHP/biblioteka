<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Livros mais emprestados</title>
    <style>
        body{
            color: #1f1f1f;
            font-family: sans-serif;
        }
        .page-break {
            page-break-after : always;
        }
        .is-fullwidth{
            width: 100%;
        }
        .has-text-right{
            text-align: right;
        }
        .has-text-left{
            text-align: left;
        }
        .is-1{
            width: 12%;
        }
        .is-3{
            width: 30%;
        }

        td{
            padding: 5px;
        }

        tr:nth-child(even) {
            background-color : #e7e7e7;
        }
        .table {
            border-spacing: 0;
        }
        .container {
            max-width: 49.6rem;
            margin : 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Livros mais emprestados</h1>
        <table class="table is-fullwidth">
            <thead>
            <tr>
                <th class="is-1 has-text-right"># Emp.</th>
                <th class="has-text-left">Título</th>
                <th class="is-3 has-text-right">Entre</th>
            </tr>
            </thead>
            <tbody>
            @forelse($livros as $livro)
                <tr>
                    <td class="has-text-right">{{$livro->emprestimos_count}}</td>
                    <td class="has-text-left">
                        [{{$livro->isbn}}]
                        {{$livro->titulo}}
                    </td>
                    <td class="has-text-right">
                        {{\Carbon\Carbon::parse($livro->primeiro_emprestimo)->format('d/m/Y')}}
                        -
                        {{\Carbon\Carbon::parse($livro->ultimo_emprestimo)->format('d/m/Y')}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="espaco">Nenhum Livro encontrado</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font(\'DejaVu Sans, Arial, Helvetica, sans-serif\', \'normal\');
                $pageText = $PAGE_NUM . \' / \' . $PAGE_COUNT;
                $y = 770;
                $x = 290;
                $size = 7;
                if ($PAGE_NUM > 1) $pdf->text($x, $y, $pageText, $font, $size);
            ');
        }
    </script>
</body>
</html>
