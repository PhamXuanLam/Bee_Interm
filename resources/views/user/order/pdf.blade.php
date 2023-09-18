@php
    use Carbon\Carbon;
@endphp
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
<h1 class="text-center">Danh Sách Chi Tiết Đơn Hàng</h1>
<h2>Thời gian: {{ Carbon::now('Asia/Ho_Chi_Minh') }}</h2>

<table class="table text-center table-bordered">
    <thead>
    <tr>
        <th>Id</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderDetails as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
