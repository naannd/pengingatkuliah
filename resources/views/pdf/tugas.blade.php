<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tugas - PengingatKuliah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }

        .header { text-align: center; margin-bottom: 24px; padding-bottom: 14px; border-bottom: 2px solid #F97316; }
        .header h1 { font-size: 20px; font-weight: 700; color: #F97316; margin-bottom: 4px; }
        .header h2 { font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 10px; }
        .meta { font-size: 10px; color: #64748b; line-height: 1.7; }
        .meta span { display: inline-block; margin: 0 8px; }

        .summary { margin: 12px 0 18px; padding: 10px 14px; background: #f1f5f9; border-radius: 6px; font-size: 10px; color: #334155; }
        .summary span { display: inline-block; margin-right: 18px; }
        .summary strong { color: #0f172a; }

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

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 600;
        }
        .badge-selesai  { background: #d1fae5; color: #065f46; }
        .badge-belum    { background: #fef3c7; color: #92400e; }
        .badge-overdue  { background: #fee2e2; color: #991b1b; }

        .progress-bar { width: 60px; height: 6px; background: #e2e8f0; border-radius: 3px; display: inline-block; vertical-align: middle; margin-right: 4px; }
        .progress-fill { height: 100%; background: #F97316; border-radius: 3px; }

        .footer { margin-top: 28px; text-align: right; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
        .empty { text-align: center; padding: 40px; color: #94a3b8; font-style: italic; }
    </style>
</head>
<body>

<div class="header">
    <h1>PengingatKuliah</h1>
    <h2>Daftar Tugas</h2>
    <div class="meta">
        <span><strong>Nama:</strong> {{ $user->nama }}</span>
        <span><strong>Prodi:</strong> {{ $user->prodi ?? '-' }}</span>
        <span><strong>Semester:</strong> {{ $user->semester ?? '-' }}</span>
        <br>
        <span><strong>Tanggal Export:</strong> {{ $tanggal }}</span>
    </div>
</div>

@php
    $total    = $tugas->count();
    $selesai  = $tugas->where('status', 'Selesai')->count();
    $belum    = $total - $selesai;
@endphp

@if($total > 0)
<div class="summary">
    <span><strong>Total:</strong> {{ $total }} tugas</span>
    <span><strong>Selesai:</strong> {{ $selesai }}</span>
    <span><strong>Belum Selesai:</strong> {{ $belum }}</span>
</div>

<table>
    <thead>
        <tr>
            <th style="width:5%">No</th>
            <th style="width:24%">Judul</th>
            <th style="width:16%">Deadline</th>
            <th style="width:12%">Status</th>
            <th style="width:18%">Progress</th>
            <th style="width:25%">Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tugas as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $item->judul }}</strong></td>
            <td>{{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d M Y') }}</td>
            <td>
                @if($item->status === 'Selesai')
                    <span class="badge badge-selesai">Selesai</span>
                @elseif($item->isOverdue())
                    <span class="badge badge-overdue">Terlambat</span>
                @else
                    <span class="badge badge-belum">Belum Selesai</span>
                @endif
            </td>
            <td>
                <span class="progress-bar"><span class="progress-fill" style="width:{{ $item->progress }}%"></span></span>
                {{ $item->progress }}%
            </td>
            <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty">Tidak ada data tugas.</div>
@endif

<div class="footer">
    Dicetak otomatis oleh PengingatKuliah &mdash; {{ $tanggal }}
</div>

</body>
</html>
