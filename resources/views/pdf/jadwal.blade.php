<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Kuliah - PengingatKuliah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }

        .header { text-align: center; margin-bottom: 24px; padding-bottom: 14px; border-bottom: 2px solid #F97316; }
        .header h1 { font-size: 20px; font-weight: 700; color: #F97316; margin-bottom: 4px; }
        .header h2 { font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 10px; }
        .meta { font-size: 10px; color: #64748b; line-height: 1.7; }
        .meta span { display: inline-block; margin: 0 8px; }

        table { width: 100%; border-collapse: collapse; margin-top: 6px; }
        thead th {
            background-color: #F97316;
            color: #ffffff;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
            border: none;
        }
        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            vertical-align: top;
        }
        tbody tr:nth-child(even) { background-color: #f8fafc; }

        .footer { margin-top: 28px; text-align: right; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }

        .empty { text-align: center; padding: 40px; color: #94a3b8; font-style: italic; }
    </style>
</head>
<body>

<div class="header">
    <h1>PengingatKuliah</h1>
    <h2>Jadwal Kuliah</h2>
    <div class="meta">
        <span><strong>Nama:</strong> {{ $user->nama }}</span>
        <span><strong>Prodi:</strong> {{ $user->prodi ?? '-' }}</span>
        <span><strong>Semester:</strong> {{ $user->semester ?? '-' }}</span>
        <br>
        <span><strong>Tanggal Export:</strong> {{ $tanggal }}</span>
    </div>
</div>

@if($jadwal->count() > 0)
<table>
    <thead>
        <tr>
            <th style="width:5%">No</th>
            <th style="width:22%">Mata Kuliah</th>
            <th style="width:12%">Hari</th>
            <th style="width:16%">Waktu</th>
            <th style="width:22%">Dosen</th>
            <th style="width:23%">Ruangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jadwal as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $item->mata_kuliah }}</strong></td>
            <td>{{ $item->hari }}</td>
            <td>{{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}</td>
            <td>{{ $item->dosen }}</td>
            <td>{{ $item->ruangan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty">Tidak ada data jadwal.</div>
@endif

<div class="footer">
    Dicetak otomatis oleh PengingatKuliah &mdash; {{ $tanggal }}
</div>

</body>
</html>
