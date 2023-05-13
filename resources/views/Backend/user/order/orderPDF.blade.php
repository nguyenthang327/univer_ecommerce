</html>

<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        th {
            background-color: #646161;
            color: white;
        }
    </style>
</head>

<body>
    <h1>{{trans('language.website')}}</h1>
    <h2>Hoa don ban hang <span>Ma hoa don: {{$order->id}}<span></h2>
    <h4>Ma khach hang: {{$order->customer_id}} Ho ten: {{$order->customer_account_name}}</h4>
    <h4>SDT: {{$order->phone}}</h4>
    <h4>Dia chi giao hang: {{$order->full_address}}</h4>
    <table>
        <tr>
            <th>STT</th>
            <th>Ten San Pham</th>
            <th>Thuoc tinh</th>
            <th>Gia</th>
            <th>So luong</th>
            <th>Tong phu</th>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach ($order->orderDetail as $idx => $product)
            <tr>
                <td>{{ ++$idx }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->attribute }}</td>
                @php
                    $price = \App\Services\ProcessPriceService::regularPrice($product->price, 0);
                    $total += $product->subtotal;
                    $subtotal = \App\Services\ProcessPriceService::regularPrice($product->subtotal, 0);
                @endphp
                <td>{{ $price['new'] }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $subtotal['new'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td>Tong phu</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @php
                $subtotal = \App\Services\ProcessPriceService::regularPrice($total, 0);
            @endphp
            <td>{{ $subtotal['new'] }}</td>
        </tr>
        <tr>
            <td>Phieu giam gia</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $order->discount_percentage ? $order->discount_percentage . '%' : '_' }}
            </td>
        </tr>
        <tr>
            <td>Tong</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            @php
                $total = \App\Services\ProcessPriceService::regularPrice($total, $order->discount_percentage);
            @endphp
            <td>{{ $total['new'] }}</td>
        </tr>
    </table>

</body>

</html>
