<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-size: 1.4rem;
            /* text-transform: uppercase; */
            font-family: DejaVu Sans, sans-serif;
            padding-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
<h1 class="text-center">Danh sách customer</h1>

@foreach($customers as $customer)
    <div>Customer Name: {{ $customer->customer->full_name }}</div>
    <div>Quantity: {{ $customer->quantity }}</div>
    <div>Total: {{ $customer->total }}</div>
    <div>Danh sách sản phẩm:</div>
    <div>
        <table class="table text-center table-bordered">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data[$customer->customer->full_name] as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->product_id }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->price }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endforeach
</body>
