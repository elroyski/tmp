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
       <h2>Raporty Empik - {{ $date->format('Y-m-d') }} - Dziennie: {{ $dailyTotal }}, Miesięcznie: {{ $monthlyTotal }}</h2>


    @if($isDataMissing)
        <p style="text-align: center; color: red; font-size: 14px;">Brak danych dla podanego okresu.</p>
    @else
        <table>
            <tr>
                <td valign="top">
                    <h3>Sprzedaż dzienna</h3>
                    <table class="gmail-table">
                        <thead>
                            <tr>
                                <th>EAN</th>
                                <th>Nazwa Indeksu</th>
                                <th>Ilość</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyStats as $stat)
                                <tr>
                                    <td>{{ $stat->ean }}</td>
                                    <td>{{ $stat->nazwa_indeksu }}</td>
                                    <td>{{ $stat->ilość }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td valign="top">
                    <h3>Sprzedaż miesięczna</h3>
                    <table class="gmail-table">
                        <thead>
                            <tr>
                                <th>EAN</th>
                                <th>Nazwa Indeksu</th>
                                <th>Ilość</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyStats as $stat)
                                <tr>
                                    <td>{{ $stat->ean }}</td>
                                    <td>{{ $stat->nazwa_indeksu }}</td>
                                    <td>{{ $stat->ilość }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    @endif
</body>
</html>
