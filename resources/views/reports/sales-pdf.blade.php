<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan — {{ $store->store_name }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #191c3c; 
            margin: 0; 
            padding: 0;
            background-color: #ffffff;
        }
        .header { 
            background: #191c3c; 
            color: #fbfbe2; 
            padding: 40px 50px; 
            position: relative;
        }
        .header h1 { 
            font-size: 28px; 
            margin: 0; 
            font-weight: 900; 
            letter-spacing: -1px;
            font-style: italic;
        }
        .header .subtitle { 
            font-size: 12px; 
            color: #c58c2b; 
            text-transform: uppercase; 
            letter-spacing: 3px; 
            margin-top: 5px;
            font-weight: bold;
        }
        .header .store-info {
            position: absolute;
            right: 50px;
            top: 40px;
            text-align: right;
        }
        .content { padding: 40px 50px; }
        .summary-grid { margin-bottom: 40px; width: 100%; border-collapse: collapse; }
        .summary-card { 
            background: #fbfbe2; 
            padding: 20px; 
            border-left: 4px solid #c58c2b; 
        }
        .summary-label { 
            font-size: 10px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: #934b19; 
            margin-bottom: 5px;
            font-weight: bold;
        }
        .summary-value { font-size: 20px; font-weight: bold; color: #191c3c; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { 
            background: #f8f8f8; 
            text-align: left; 
            padding: 12px 15px; 
            font-size: 9px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: #934b19; 
            border-bottom: 2px solid #191c3c;
        }
        td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; }
        .text-right { text-align: right; }
        
        .total-row { 
            background: #191c3c; 
            color: #ffffff; 
            font-weight: bold; 
        }
        .total-row td { border: none; padding: 15px; font-size: 14px; }
        .total-label { color: #c58c2b; text-transform: uppercase; letter-spacing: 2px; font-size: 10px; }

        .footer { 
            position: fixed; 
            bottom: 40px; 
            width: 100%; 
            text-align: center; 
            color: #934b19; 
            font-size: 9px; 
            letter-spacing: 1px;
            opacity: 0.6;
        }
        .stamp {
            margin-top: 50px;
            float: right;
            text-align: center;
            border: 2px solid #c58c2b;
            color: #c58c2b;
            padding: 10px 20px;
            transform: rotate(-5deg);
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>AksaraLoka</h1>
        <div class="subtitle">Official Sales Report</div>
        <div class="store-info">
            <div style="font-size: 16px; font-weight: bold; margin-bottom: 4px;">{{ $store->store_name }}</div>
            <div style="font-size: 10px; opacity: 0.8;">{{ $store->address ?? 'Banyumas, Jawa Tengah' }}</div>
        </div>
    </div>

    <div class="content">
        <table class="summary-grid">
            <tr>
                <td style="width: 50%; padding: 0 10px 0 0;">
                    <div class="summary-card">
                        <div class="summary-label">Periode Laporan</div>
                        <div class="summary-value" style="font-size: 14px;">
                            {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                        </div>
                    </div>
                </td>
                <td style="width: 50%; padding: 0 0 0 10px;">
                    <div class="summary-card" style="border-left-color: #191c3c;">
                        <div class="summary-label">Total Pendapatan</div>
                        <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <h3 style="text-transform: uppercase; letter-spacing: 2px; color: #191c3c; font-size: 12px; margin-bottom: 10px;">Rincian Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>Kode Order</th>
                    <th>Nama Produk</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $item)
                <tr>
                    <td style="font-weight: bold; font-family: monospace;">#{{ $item->order->order_code }}</td>
                    <td>{{ $item->product->name ?? 'Produk Tidak Tersedia' }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" style="vertical-align: middle;">
                        <span class="total-label">Ringkasan Akhir</span>
                    </td>
                    <td class="text-right total-label" style="vertical-align: middle;">Total Bersih</td>
                    <td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="stamp">
            VERIFIED BY AKSARALOKA
        </div>
    </div>

    <div class="footer">
        © {{ date('Y') }} AksaraLoka Artisan Marketplace. Dicetak pada {{ now()->format('d F Y, H:i') }}.
    </div>
</body>
</html>
