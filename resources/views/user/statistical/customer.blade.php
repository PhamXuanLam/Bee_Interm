@extends("user.layouts.master")
@section("content")
    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    @if($customers->isNotEmpty())
        <table class="table text-center table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Birthday</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->customer->email }}</td>
                    <td>{{ $customer->customer->full_name}}</td>
                    <td>{{ $customer->customer->address }}</td>
                    <td>{{ $customer->customer->phone }}</td>
                    <td>{{ $customer->customer->birthday }}</td>
                    <td>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            {{ $customers->links() }}
        </div>
    @else
        Dữ liệu không tồn tại
    @endif
@endsection
