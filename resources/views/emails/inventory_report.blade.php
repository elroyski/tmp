<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
        <style>
      .gmail-table {
        border: solid 2px #DDEEEE;
        border-collapse: collapse;
        border-spacing: 0;
        font: normal 14px Roboto, sans-serif;
      }

      .gmail-table thead th {
        background-color: #DDEFEF;
        border: solid 1px #DDEEEE;
        color: #336B6B;
        padding: 10px;
        text-align: left;
        text-shadow: 1px 1px 1px #fff;
      }

      .gmail-table tbody td {
        border: solid 1px #DDEEEE;
        color: #333;
        padding: 10px;
        text-shadow: 1px 1px 1px #fff;
      }
    </style>
</head>
<body>
    <h2>Raport zapasu magazynowego </h2>
    <table class="gmail-table">
        <thead>
       <tr>
                <th>EAN</th>
                <th>Tytuł</th>
                <th>Zapas całkowity</th>
                <th>Magazyn centralny</th>
                <th>Salony</th>
            </tr>
        </thead>
        <tbody>
             @foreach($reportData as $item)
                 <tr>
                <td>{{ $item->ean }}</td>
                <td>{{ $item->nazwa_indeksu }}</td>
                <td>{{ $item->total_stock }}</td>
                <td>{{ $item->empik_stock }}</td>
                <td>{{ $item->salony_stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
