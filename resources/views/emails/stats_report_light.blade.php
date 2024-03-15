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
    <h2>Top 20 Sprzedaży Dziennej - {{ $date->format('Y-m-d') }}</h2>
    <table class="gmail-table">
        <thead>
            <tr>
                <th>EAN</th>
                <th>Nazwa Indeksu</th>
                <th>Ilość</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyTop20 as $stat)
                <tr>
                    <td>{{ $stat->ean }}</td>
                    <td>{{ $stat->nazwa_indeksu }}</td>
                    <td>{{ $stat->ilość }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
