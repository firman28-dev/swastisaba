<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Swastisaba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            word-wrap: break-word;
        }

        th {
            vertical-align: middle !important
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>
        User Kab/Kota
    </h1>
    <table>
        <thead>
            <tr >
                <th>No.</th>
                <th>Kab/Kota</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $data)
            <tr>
                <td class="border border-1 text-center">{{ $loop->iteration }}</td>
                <td class="text-capitalize border border-1">{{ $data->_zona->name ?? '-' }}</td>
                <td class="text-capitalize border border-1">{{ $data->username }}</td>
                <td class="text-capitalize border border-1">sumbarprov</td>

            </tr>
            
            @endforeach
        </tbody>
    </table>
</body>
</html>