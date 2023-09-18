@extends("user.layouts.master")
@section("content")
    <table class="table text-center table-bordered">
        <thead>
        <tr>
            <th>Id</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>
                <a href="{{ route('order.download', ['id' => $orderDetails[0]->id]) }}" class="btn-primary btn btn-sm">PDF</a>
            </th>
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
@endsection
