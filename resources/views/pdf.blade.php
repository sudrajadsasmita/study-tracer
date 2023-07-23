<!DOCTYPE html>
<html>

<head>
    <title>User Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .table-container {
            overflow-x: auto;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        @media only screen and (max-width: 600px) {

            th,
            td {
                padding: 5px;
            }

            .table-container {
                overflow-x: scroll;
            }
        }
    </style>
</head>

<body>

    <h1>{{ $title }}</h1>

    <p>{{ $date }}</p>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Email</th>
            <th>IPK</th>
            <th>Tahun Masuk</th>
            <th>Tahun Lulus</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->nim }}</td>
                <td>{{ $user->users[0]->email }}</td>
                <td>{{ $user->ipk }}</td>
                <td>{{ $user->tahun_masuk }}</td>
                <td>{{ $user->tahun_lulus }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
