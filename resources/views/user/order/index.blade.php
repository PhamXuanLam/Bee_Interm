@extends("user.layouts.master")
@section("content")
    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif
    @if($orders->isNotEmpty())
        <table class="table text-center table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Customer Name</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->full_name }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ $order->total }}</td>
                    <td>
                        <a href="{{ route('order.show', ['id' => $order->id]) }}" class="btn btn-sm btn-primary">Show</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        Dữ liệu không tồn tại
    @endif
@endsection
