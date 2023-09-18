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
<h1 class="text-center">Danh Sách Sản Phẩm Có Số Lượng Nhỏ Hơn 10</h1>

<table class="table text-center table-bordered">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Category Name</th>
        <th>Stock</th>
        <th>Expired at</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr id="product-{{ $loop->index }}">
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name}}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->expired_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
