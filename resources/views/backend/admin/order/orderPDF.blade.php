</html>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
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
    <h2>{{trans('language.order_title')}}</h2>
    <h2>{{trans('language.order_id')}}: {{$order->id}}</h2>
    <h4>{{trans('language.customer_id')}}: {{$order->customer_id}}</h4>
    <h4>{{trans('language.customer_account_name')}}: {{$order->customer_account_name}}</h4>
    <h4>{{trans('language.consignee_phone')}}: {{$order->phone}}</h4>
    <h4>{{trans('language.delivery_address')}}: {{$order->full_address}}</h4>
    <table>
        <tr>
            <th>{{ trans('language.ordinal_number') }}</th>
            <th>{{trans('language.product_name')}}</th>
            <th>{{trans('language.attribute')}}</th>
            <th>{{trans('language.price')}}</th>
            <th>{{trans('language.quantity')}}</th>
            <th>{{trans('language.subtotal')}}</th>
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
            <td>{{trans('language.subtotal')}}</td>
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
            <td>{{ trans('language.coupon') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $order->discount_percentage ? $order->discount_percentage . '%' : '_' }}
            </td>
        </tr>
        <tr>
            <td>{{ trans('language.total') }}</td>
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
