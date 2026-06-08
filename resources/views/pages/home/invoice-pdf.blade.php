<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { display: table; width: 100%; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .brand { font-size: 28px; font-weight: bold; color: #111; }
        .info { display: table; width: 100%; margin-top: 20px; }
        .info-col { display: table-cell; width: 50%; vertical-align: top; }
        .section-title { font-size: 12px; font-weight: bold; text-transform: uppercase; color: #999; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th { background: #f9f9f9; text-align: left; padding: 12px; font-size: 12px; border-bottom: 1px solid #eee; }
        td { padding: 12px; font-size: 12px; border-bottom: 1px solid #eee; }
        .totals { margin-top: 20px; float: right; width: 300px; }
        .total-row { display: table; width: 100%; margin-bottom: 5px; }
        .total-label { display: table-cell; font-size: 12px; color: #666; }
        .total-value { display: table-cell; text-align: right; font-size: 12px; font-weight: bold; }
        .grand-total { border-top: 2px solid #eee; padding-top: 10px; margin-top: 10px; }
        .footer { margin-top: 50px; text-align: center; font-size: 10px; color: #aaa; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div style="display: table-cell;">
                <span class="brand">ZORIE</span>
            </div>
            <div style="display: table-cell; text-align: right;">
                <div style="font-size: 18px; font-weight: bold;">INVOICE</div>
                <div style="font-size: 12px; color: #666;">#{{ $order->order_number }}</div>
            </div>
        </div>

        <div class="info">
            <div class="info-col">
                <div class="section-title">Tagihan Untuk:</div>
                <div style="font-weight: bold;">{{ $customer->name }}</div>
                <div>{{ $customer->email }}</div>
                <div>{{ $customer->phone }}</div>
            </div>
            <div class="info-col" style="text-align: right;">
                <div class="section-title">Alamat Pengiriman:</div>
                <div>{{ $order->address }}</div>
                <div>{{ $order->city }}, {{ $order->postal_code }}</div>
                <div style="margin-top: 10px;">
                    <span class="section-title">Tanggal:</span> {{ $order->created_at->format('d M Y') }}
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div style="font-weight: bold;">{{ $item->product->name }}</div>
                        <div style="font-size: 10px; color: #888;">Size: {{ $item->size }}</div>
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <div class="total-label">Subtotal Produk</div>
                <div class="total-value">Rp {{ number_format($order->total - $order->shipping_cost, 0, ',', '.') }}</div>
            </div>
            <div class="total-row">
                <div class="total-label">Biaya Pengiriman</div>
                <div class="total-value">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
            </div>
            <div class="total-row grand-total">
                <div class="total-label" style="font-weight: bold; color: #111;">Total Pembayaran</div>
                <div class="total-value" style="font-size: 16px; color: #111;">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div style="margin-top: 40px; padding: 15px; background: #f9f9f9; border-radius: 8px;">
            <div class="section-title">Informasi Pembayaran:</div>
            <div style="font-size: 11px;">
                Metode Pembayaran: <strong>{{ $order->payment_method }}</strong><br>
                Status Pesanan: <strong>{{ $order->status }}</strong>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di Zorie.<br>Jika ada pertanyaan, silakan hubungi kami di support@zorie.com</p>
        </div>
    </div>
</body>
</html>