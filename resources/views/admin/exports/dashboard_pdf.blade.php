<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dashboard Admin</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>Laporan Dashboard Admin</h1>

    <p><strong>Total Ide:</strong> {{ $totalIdeas }}</p>
    <p><strong>Total Proyek:</strong> {{ $totalProjects }}</p>
    <p><strong>Total Produk UMKM:</strong> {{ $totalProducts }}</p>
    <p><strong>Total Komentar:</strong> {{ $totalComments }}</p>
    <p><strong>Total Pengguna:</strong> {{ $totalUsers }}</p>

    <h2>Aktivitas Terbaru</h2>
    <table>
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Aksi</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentActivities as $act)
            <tr>
                <td>{{ $act->user->name ?? 'N/A' }}</td>
                <td>{{ $act->action }}</td>
                <td>{{ $act->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Pengguna Terbaru</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latestUsers as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h2>📊 Laporan Aktivitas</h2>
<p>Periode: {{ $startDate }} - {{ $endDate }}</p>

<img src="{{ $chartPath }}" alt="Grafik Aktivitas" style="width:100%; margin-top:20px;">

<table border="1" cellpadding="5" cellspacing="0" width="100%" style="margin-top:20px;">
    <thead>
        <tr>
            <th>User</th>
            <th>Aksi</th>
            <th>Waktu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $act)
        <tr>
            <td>{{ $act->user->name ?? 'User' }}</td>
            <td>{{ $act->description }}</td>
            <td>{{ $act->created_at->format('d M Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
