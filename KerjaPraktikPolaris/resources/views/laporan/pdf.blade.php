<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; background: #fff; }

        /* Header */
        .header { background: #1e3a5f; color: white; padding: 20px 24px; margin-bottom: 20px; }
        .header-top { display: flex; justify-content: space-between; align-items: flex-start; }
        .company-name { font-size: 20px; font-weight: 700; letter-spacing: 2px; color: #60a5fa; }
        .company-sub { font-size: 9px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }
        .report-title { text-align: right; }
        .report-title h2 { font-size: 14px; font-weight: 700; color: white; }
        .report-title p { font-size: 10px; color: #94a3b8; margin-top: 2px; }
        .period-bar { margin-top: 12px; background: rgba(255,255,255,0.1); border-radius: 6px; padding: 8px 12px; font-size: 11px; color: #e2e8f0; }

        /* Content */
        .content { padding: 0 24px; }

        /* Stat grid */
        .stat-grid { display: flex; gap: 10px; margin-bottom: 20px; }
        .stat-card { flex: 1; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; background: #f8fafc; }
        .stat-label { font-size: 9px; text-transform: uppercase; color: #64748b; font-weight: 600; margin-bottom: 4px; }
        .stat-value { font-size: 14px; font-weight: 700; color: #1e293b; }
        .stat-value.green { color: #16a34a; }
        .stat-value.blue { color: #2563eb; }
        .stat-value.emerald { color: #059669; }
        .stat-sub { font-size: 9px; color: #94a3b8; margin-top: 2px; }

        /* Section */
        .section { margin-bottom: 22px; }
        .section-title { font-size: 12px; font-weight: 700; color: #1e293b; padding: 8px 10px; background: #f1f5f9; border-left: 3px solid #2563eb; border-radius: 0 4px 4px 0; margin-bottom: 8px; }
        .section-title.green-bar { border-left-color: #16a34a; }
        .section-title.blue-bar { border-left-color: #2563eb; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        thead tr { background: #1e3a5f; color: white; }
        thead th { padding: 7px 8px; text-align: left; font-weight: 600; font-size: 9px; text-transform: uppercase; }
        thead th.text-right { text-align: right; }
        thead th.text-center { text-align: center; }
        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; }
        tbody td.text-right { text-align: right; }
        tbody td.text-center { text-align: center; }
        tfoot tr { background: #1e293b; color: white; font-weight: 700; }
        tfoot td { padding: 7px 8px; }
        tfoot td.text-right { text-align: right; }

        /* Badge */
        .badge { display: inline-block; padding: 2px 7px; border-radius: 99px; font-size: 9px; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-blue { background: #dbeafe; color: #1d4ed8; }
        .badge-yellow { background: #fef9c3; color: #854d0e; }

        /* Summary pengiriman */
        .ship-summary { display: flex; gap: 8px; margin-bottom: 10px; }
        .ship-badge { padding: 5px 12px; border-radius: 6px; font-size: 9px; font-weight: 600; }

        /* Footer */
        .footer { margin-top: 24px; padding: 14px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; font-size: 9px; color: #94a3b8; }
        .sign-area { text-align: center; }
        .sign-line { border-top: 1px solid #1e293b; margin-top: 40px; padding-top: 4px; font-size: 9px; color: #1e293b; width: 140px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-top">
            <div>
                <div class="company-name">POLARIS</div>
                <div class="company-sub">Inovasindo Furniture</div>
            </div>
            <div class="report-title">
                <h2>LAPORAN BULANAN</h2>
                <p>Rekap Operasional untuk Kantor Pusat</p>
            </div>
        </div>
        <div class="period-bar">
            📅 Periode: <strong>{{ $namaBulan }} {{ $tahun }}</strong> &nbsp;|&nbsp;
            Dicetak: {{ date('d/m/Y H:i') }} &nbsp;|&nbsp;
            Dibuat oleh: {{ auth()->user()->name ?? 'Admin' }}
        </div>
    </div>

    <div class="content">

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value green">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-sub">{{ $totalTransaksi }} nota transaksi</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Item Terjual</div>
                <div class="stat-value blue">{{ number_format($totalItemTerjual, 0, ',', '.') }} pcs</div>
                <div class="stat-sub">Total unit keluar</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Pengiriman</div>
                <div class="stat-value">{{ $totalPengiriman }}</div>
                <div class="stat-sub">Pengiriman bulan ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Sampai Tujuan</div>
                <div class="stat-value emerald">{{ $pengirimanSampai }}</div>
                <div class="stat-sub">Dari {{ $totalPengiriman }} pengiriman</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title green-bar">📋 Detail Transaksi — {{ $namaBulan }} {{ $tahun }}</div>
            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Toko</th>
                        <th>Produk</th>
                        <th class="text-center">Jml</th>
                        <th class="text-right">Total Harga</th>
                        <th class="text-right">Bayar</th>
                        <th class="text-right">Kembalian</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                    <tr>
                        <td style="font-family: monospace; font-size:9px;">{{ $t->nomor_invoice }}</td>
                        <td>{{ $t->nama_toko ?? '-' }}</td>
                        <td>{{ optional($t->produk)->nama_produk ?? '-' }}</td>
                        <td class="text-center">{{ $t->jumlah_jual }}</td>
                        <td class="text-right">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($t->bayar, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($t->kembalian, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $t->tanggal_pembayaran }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" style="text-align:center; padding:12px; color:#94a3b8;">Tidak ada transaksi bulan ini.</td></tr>
                    @endforelse
                </tbody>
                @if($transaksi->isNotEmpty())
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align:right;">TOTAL PENDAPATAN:</td>
                        <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        <div class="section">
            <div class="section-title blue-bar">🚚 Detail Pengiriman — {{ $namaBulan }} {{ $tahun }}</div>
            <div class="ship-summary">
                <span class="ship-badge badge-green">✅ Sampai: {{ $pengirimanSampai }}</span>
                <span class="ship-badge badge-blue">🚚 Perjalanan: {{ $pengirimanJalan }}</span>
                <span class="ship-badge badge-yellow">⏳ Menunggu: {{ $pengirimanMenunggu }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No. Resi</th>
                        <th>Penerima</th>
                        <th>Toko / Alamat</th>
                        <th>Produk</th>
                        <th class="text-center">Jml</th>
                        <th class="text-center">Tgl Kirim</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengiriman as $pg)
                    <tr>
                        <td style="font-family: monospace; font-size:9px;">{{ $pg->nomor_resi }}</td>
                        <td>{{ $pg->nama_penerima }}</td>
                        <td>{{ $pg->nama_toko ?? $pg->alamat_tujuan }}</td>
                        <td>{{ optional($pg->produk)->nama_produk ?? '-' }}</td>
                        <td class="text-center">{{ $pg->jumlah }}</td>
                        <td class="text-center">{{ $pg->tanggal_kirim }}</td>
                        <td class="text-center">
                            @php
                                $cls = ['Sampai' => 'badge-green', 'Perjalanan' => 'badge-blue', 'Menunggu' => 'badge-yellow'][$pg->status] ?? '';
                            @endphp
                            <span class="badge {{ $cls }}">{{ $pg->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center; padding:12px; color:#94a3b8;">Tidak ada pengiriman bulan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

       <div style="margin-top:24px; padding-right:24px; text-align:right;">
    <p style="font-size:10px; color:#64748b;">{{ $namaBulan }} {{ $tahun }}</p>
    <p style="font-size:10px; font-weight:700; color:#1e293b; margin-top:2px;">Mengetahui,</p>
    <p style="font-size:10px; color:#1e293b;">Kepala Cabang</p>
    <div style="margin-top:40px; border-top:1px solid #1e293b; padding-top:4px; display:inline-block; min-width:160px;">
        <p style="font-size:9px; color:#1e293b;">( _________________________ )</p>
    </div>
</div>

    </div>

    <div class="footer">
        <span>PT. Polaris Inovasindo Furniture</span>
        <span>Laporan ini digenerate otomatis oleh Sistem Inventaris v1.0</span>
        <span>{{ date('d/m/Y H:i') }}</span>
    </div>

</body>
</html>