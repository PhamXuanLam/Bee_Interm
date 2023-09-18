@extends('user.layouts.master')
@section("content")
    <div class="d-flex justify-content-between">
        <a href="{{ route("product.create") }}" class="btn btn-success btn-sm" style="height: 35px">
            Create Product
        </a>
        <form class="form-inline" action="{{ route("product.index") }}">
            <div class="form-group">
                <select id="stock" name="stock" class="form-control custom-select form-control-sm">
                    <option value="">Tìm kiếm theo số lượng</option>
                    @foreach(\App\Models\Product::stockRange as $key => $value)
                        <option value="{{ $key }}" {{ request()->get('stock') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar py-3" value="{{ request()->get('name') }}" type="search" name="name" placeholder="Tìm kiếm theo tên" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <form class="form-inline" action="{{ route("product.index") }}">
            <button class="btn btn-primary" type="submit">
                reset
            </button>
        </form>
        <form action="{{ route("product.download") }}" method="post">
            @csrf
            <div class="form-group d-flex">
                <button type="submit" class="btn btn-sm btn-primary">Download</button>
                <select id="format" name="format" class="form-control custom-select">
                    <option value="csv">CSV</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
        </form>
    </div>
    @if($products->isNotEmpty())
        <table class="table text-center table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Sku</th>
                <th>Category Name</th>
                <th>Stock</th>
                <th>Expired at</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class="product">
                    <td>{{ $product->id }}</td>
                    <td>
                        <img
                            src="{{ route("product.image", ['id' => $product->id, "avatar" => $product->avatar]) }}"
                             alt="{{ $product->name }}"
                             title="{{ $product->name }}"
                             style="width:100px; height :70px;">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->expired_at }}</td>
                    <td>
                        <a href="{{ route("product.show", ["id" => $product->id]) }}"
                           class="btn btn-primary btn-sm">
                            Show
                        </a>
                        <a href="{{ route("product.edit", ['id' => $product->id]) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <button type="button" data-id="{{ $product->id }}" class="btn btn-delete btn-danger btn-sm">DELETE
                        </button>
                    </td>
                </tr>
                @include("user.product.sweetDelete")
            @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        Không có dữ liệu sản phẩm
    @endif
    {{--sweetalert--}}
    <script>
        $(document).ready(function () {
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: '{{ session('success') }}'
            });
            @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '{{session('error') }}'
            });
            @endif
        });
    </script>
@endsection
