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
            <th>IPK</th>
            <th>Tahun Masuk</th>
            <th>Tahun Lulus</th>
            <th>Status Bekerja</th>
            <th>Saran Prodi</th>
            <th>Alamat Perusahaan</th>
            <th>Jabatan</th>
            <th>Lama Bekerja</th>
            <th>Gaji</th>
            <th>Deskripsi</th>
            <th>Sesuai Jurusan</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->nim }}</td>
                <td>{{ $user->ipk }}</td>
                <td>{{ $user->tahun_masuk }}</td>
                <td>{{ $user->tahun_lulus }}</td>
                <td>{{ $user->status_bekerja }}</td>
                <td>{{ isset($user->saran_prodi) ? $user->saran_prodi : '-' }}</td>
                <td>{{ isset($user->alamat_perusahaan) ? $user->alamat_perusahaan : '-' }}</td>
                <td>{{ isset($user->jabatan) ? $user->jabatan : '-' }}</td>
                <td>{{ isset($user->lama_bekerja) ? $user->lama_bekerja : '-' }}</td>
                <td>{{ isset($user->gaji) ? $user->gaji : '-' }}</td>
                <td>{{ isset($user->deskripsi) ? $user->deskripsi : '-' }}</td>
                <td>{{ isset($user->is_sesuai) ? $user->is_sesuai : '-' }}</td>
            </tr>
        @endforeach
    </table>

</body>

</html>
