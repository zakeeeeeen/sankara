<div style="font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, 'Apple Color Emoji', 'Segoe UI Emoji'; line-height: 1.6; color: #0f172a;">
    <div style="max-width: 640px; margin: 0 auto; padding: 24px;">
        <h2 style="margin: 0 0 12px; font-size: 18px;">Pesan Kontak Baru</h2>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 16px;">
            <div><strong>Nama:</strong> {{ $row->name }}</div>
            <div><strong>Email:</strong> {{ $row->email }}</div>
            @if ($row->phone)
                <div><strong>No. Telp:</strong> {{ $row->phone }}</div>
            @endif
            <div><strong>Tanggal:</strong> {{ $row->created_at }}</div>
        </div>

        <div style="margin-top: 16px;">
            <div style="font-weight: 700; margin-bottom: 8px;">Pesan</div>
            <div style="white-space: pre-line; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 16px;">{{ $row->message }}</div>
        </div>
    </div>
</div>

