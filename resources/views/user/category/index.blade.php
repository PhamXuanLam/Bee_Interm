@extends("user.layouts.master")
@section("content")
    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif
    <a href="{{ route("category.create") }}" class="btn btn-success btn-sm">
        Create Category
    </a>
    @if($categories->isNotEmpty())
        <table class="table text-center table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Parent ID</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->user_id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->getParentId() }}</td>
                    <td>
                        <form method="post" action="{{ route("category.destroy", ["id" => $category->id]) }}">
                            @method("DELETE")
                            @csrf
                            <a href="#" class="btn btn-primary btn-sm">
                                Show
                            </a>
                            <a href="{{ route("category.edit", ["id" => $category->id]) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <button type="submit" class="btn btn-danger btn-sm">DELETE</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            {{ $categories->links() }}
        </div>
    @else
        Dữ liệu không tồn tại
    @endif
@endsection
