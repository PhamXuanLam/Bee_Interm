@extends("user.layouts.master")
@section("content")
    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('statistical.index') }}" class="row">
        <div class="d-flex col-4 offset-4 justify-content-between">
            <div class="form-group">
                <label for="start">Start</label>
                <input type="date" id="start" name="start" class="" value="{{ request()->get('start') }}">
                @if ($errors->has('start'))
                    <p class="text-danger">{{ $errors->first('start') }}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="end">End</label>
                <input type="date" id="start" name="end" class="" value="{{ request()->get('end') }}">
                @if ($errors->has('end'))
                    <p class="text-danger">{{ $errors->first('end') }}</p>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-sm btn-primary">Thống kê</button>
            </div>
        </div>
    </form>
    @if($products->isNotEmpty())
        <table class="table text-center table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>
                        <img
                            src="{{ route("product.image", ['id' => $product->product_id, "avatar" => $product->product->avatar]) }}"
                            alt="{{ $product->name }}"
                            title="{{ $product->name }}"
                            style="width:100px; height :70px;">
                    </td>
                    <td>{{ $product->product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->product->price }}</td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="{{ route("statistical.customer", ['id' => $product->product_id]) }}">
                            Customers
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        Dữ liệu không tồn tại
    @endif
    <form class="form-inline" action="{{ route("statistical.index") }}">
        <button class="btn btn-primary" type="submit">
            reset
        </button>
    </form>
    <a class="btn btn-sm btn-primary" href="{{ route('statistical.chart') }}">
        Chart
    </a>
@endsection
