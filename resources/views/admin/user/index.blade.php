@extends('admin.layouts.master')
@section("content")
    <div class="d-flex justify-content-between">
        <a href="{{ route("admin.users.create") }}" class="btn btn-success btn-sm">
            {{ trans('user.create') }}
        </a>
        <form class="form-inline" action="{{ route("admin.users.index") }}">
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" value="{{ request()->get('keyword') }}" type="search" name="keyword" placeholder="Tìm kiếm theo tên" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <form class="form-inline" action="{{ route("admin.users.index") }}">
            <button class="btn btn-primary" type="submit">
                {{ trans('user.reset') }}
            </button>
        </form>
        <div>
            <a href="{{ route('change-language', ['en']) }}" class="btn btn-primary btn-sm">
                English
            </a>
            <a href="{{ route('change-language', ['vi']) }}" class="btn btn-primary btn-sm">
                Tiếng Việt
            </a>
        </div>
    </div>
    @if($users->isNotEmpty())
        <table class="table text-center table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ trans('user.avatar') }}</th>
                <th>{{ trans('user.user_name') }}</th>
                <th>Email</th>
                <th>{{ trans('user.address') }}</th>
                <th>{{ trans('user.birthday') }}</th>
                <th>{{ trans('user.status') }}</th>
                <th>{{ trans('user.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="user">
                    <td>{{ $user->id }}</td>
                    <td>
                        <img src="{{ route("users.image", ['id' => $user->id, 'avatar' => $user->avatar]) }}"
                             alt="{{ $user->user_name }}"
                             title="{{ $user->user_name }}"
                             style="width:70px; height :70px;">
                    </td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->address }}</td>
                    <td>{{ $user->birthday }}</td>
                    <td>{{ $user->getStatusLabel() }}</td>
                    <td>
                        <form method="post" action="{{ route("admin.users.delete", ['id' => $user->id]) }}">
                            @method("DELETE")
                            @csrf
                            <a href="{{ route("admin.users.edit", ['id' => $user->id]) }}" class="btn btn-warning btn-sm">
                                {{ trans('user.edit') }}
                            </a>
                            <button type="button" data-id="{{ $user->id }}" class="btn btn-delete btn-danger btn-sm">{{ trans('user.delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex align-items-center justify-content-center">
            {{ $users->links() }}
        </div>
    @else
        {{ trans('user.data_not_found') }}
    @endif
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
    @include('admin.user.sweetDelete')
@endsection
