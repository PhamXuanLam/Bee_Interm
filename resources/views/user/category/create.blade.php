@extends("user.layouts.master")
@section("content")
    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-md-6 offset-3">
                    <form action="{{ route("category.store") }}" method="post">
                        @csrf
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Category</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old("name") }}">
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="parent_id">Danh mục cha</label>
                                    <select id="parent_id" name="parent_id" class="form-control custom-select">
                                        <option value="">Danh mục cha</option>
                                        @foreach($productCategoryList as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('parent_id'))
                                        <p class="text-danger">{{ $errors->first('parent_id') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-sm btn btn-success">Create new Category</button>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('category.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </section>
    </div>
@endsection

