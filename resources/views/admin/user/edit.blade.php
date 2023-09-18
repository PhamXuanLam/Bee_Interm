@extends("admin.layouts.master")
@section("content")
    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-md-6 offset-3">
                    <form action="{{ route("admin.users.update", ["id" => $user->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ trans('user.update') }}</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="avatar">{{ trans('user.avatar') }}</label>
                                    <div class="imagePreview text-center">
                                        <img
                                            style="width: 70px; height: 70px;"
                                            src="{{ route('users.image', ['id' => $user->id, 'avatar' => $user->avatar]) }}"
                                        >
                                    </div>
                                    <input type="file" name="avatar" id="avatar" class="form-control-file">
                                    @if ($errors->has('avatar'))
                                        <p class="text-danger">{{ $errors->first('avatar') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}">
                                    @if ($errors->has('email'))
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="userName">{{ trans('user.user_name') }}</label>
                                    <input type="text" id="userName" name="user_name" class="form-control"
                                           value="{{ $user->user_name }}">
                                    @if ($errors->has('user_name'))
                                        <p class="text-danger">{{ $errors->first('user_name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="firstName">{{ trans('user.first_name') }}</label>
                                    <input id="firstName" class="form-control" name="first_name"
                                           value="{{ $user->first_name }}">
                                    @if ($errors->has('first_name'))
                                        <p class="text-danger">{{ $errors->first('first_name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="lastName">{{ trans('user.last_name') }}</label>
                                    <input id="lastName" class="form-control" name="last_name"
                                           value="{{ $user->last_name }}">
                                    @if ($errors->has('last_name'))
                                        <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="birthday">{{ trans('user.birthday') }}</label>
                                    <input type="date" id="birthday" name="birthday" class="form-control"
                                           value="{{ $user->birthday }}">
                                    @if ($errors->has('birthday'))
                                        <p class="text-danger">{{ $errors->first('birthday') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus">{{ trans('user.status') }}</label>
                                    <select id="inputStatus" name="status" class="form-control custom-select">
                                        <option value="{{ \App\Models\User::STATUS_ACTIVE }}"
                                            {{ old('status') == \App\Models\User::STATUS_ACTIVE ? "selected" : ""}}>{{\App\Models\User::STATUS_ACTIVE_LABEL}}</option>
                                        <option value="{{ \App\Models\User::STATUS_INACTIVE }}"
                                            {{ old('status') == \App\Models\User::STATUS_INACTIVE ? "selected" : ""}}>{{\App\Models\User::STATUS_INACTIVE_LABEL}}</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <p class="text-danger">{{ $errors->first('status') }}</p>
                                    @endif
                                </div>
                                <label for="address">{{ trans('user.address') }}</label>
                                <div class="form-group d-flex" id="address">
                                    <select id="province" name="province" class="form-control custom-select">
                                        <option value="{{ $user->province_id }}">{{ $user->province->name }}</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('province'))
                                        <p class="text-danger">{{ $errors->first('province') }}</p>
                                    @endif
                                    <select id="district" name="district" class="form-control custom-select">
                                        <option value="{{ $user->district_id }}">{{ $user->district->name }}</option>
                                        @if($districts->isNotEmpty())
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('district'))
                                        <p class="text-danger">{{ $errors->first('district') }}</p>
                                    @endif
                                    <select id="commune" name="commune" class="form-control custom-select">
                                        <option value="{{ $user->commune_id }}">{{ $user->commune->name }}</option>
                                        @if($communes->isNotEmpty())
                                            @foreach($communes as $commune)
                                                <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('commune'))
                                        <p class="text-danger">{{ $errors->first('commune') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-sm btn btn-success">Update User</button>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </section>
    </div>
    @include("admin.user.address")
@endsection
