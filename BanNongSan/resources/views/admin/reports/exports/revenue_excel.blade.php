<table>
    <thead>
        <tr>
            <th colspan="2">Báo cáo doanh thu tháng {{ $currentMonth->format('m/Y') }}</th>
        </tr>
        <tr>
            <th>Ngày</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach($revenueData as $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($data->Ngay)->format('d/m/Y') }}</td>
                <td>{{ number_format($data->TongTien, 0, ',', '.') }} VND</td>
            </tr>
        @endforeach
    </tbody>
</table>
