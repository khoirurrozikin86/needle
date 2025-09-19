<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transactions Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        header {
            text-align: center;
            padding: 1px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 10px;
        }
        .company-address {
            font-style: italic;
        }
        .logo {
            max-width: 150px;
        }
    </style>
</head>
<body>

    <header>
        <div class="company-info">
            {{-- <img src="{{ public_path('path_to_your_logo.png') }}" alt="Company Logo" class="logo"> --}}
            <div class="company-name text-primary">TIMW</div>
            <div class="company-address">
                Jl. Raya Tegalpanas – Jimbaran RT. 01/RW.01 Dusun Secang, Desa Samban
                <br>
                Kecamatan Bawen, Kabupaten Semarang, Provinsi Jawa tengah
                <br>
                50661
                <br>
                Tel: +62 0298-523720
            </div>
        </div>
    </header>



    <h1>Transactions Report</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Transaction Number</th>
                <th>NIK</th>
                <th>Employee Name</th>
                <th>Type1</th>
                <th>Type2</th>
                <th>Remark</th>
                <th>IN At</th>
                <th>OUT At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->no_trx }}</td>
                <td>{{ $transaction->employee->nik ?? 'N/A' }}</td>
                <td>{{ $transaction->employee->name ?? 'N/A' }}</td>
                <td>{{ $transaction->type1 }}</td>
                <td>{{ $transaction->type2 }}</td>
                <td>{{ $transaction->remark }}</td>
                <td>{{ $transaction->created_at }}</td>
                <td>{{ $transaction->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
