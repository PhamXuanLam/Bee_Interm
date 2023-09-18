@extends("user.layouts.master")
@section("content")
    <div class="container">
        <section class="content">
            <div class="row">
                <div class="col-md-6 offset-3">
                    <form action="{{ route("product.update", ["id" => $product->id]) }}" method="post" enctype="multipart/form-data">
                        @include("user.product.preview")
                        @csrf
                        @method("PUT")
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Product</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="avatar">Avatar</label>
                                    <div class="text-center imagePreview"><img
                                            style="width:100px; height :100px;"
                                            @if($product->avatar == null)
                                                src="{{ asset("vendor/adminlte/dist/img/avatar.png") }}"
                                            @else
                                                src="{{ route("product.image", ["id" => $product->id, "avatar" => $product->avatar]) }}"
                                            @endif>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="file" name="avatar" id="avatar" class="form-control-file">
                                    @if ($errors->has('avatar'))
                                        <p class="text-danger">{{ $errors->first('avatar') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $product->name }}">
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" id="stock" name="stock" class="form-control" value="{{ $product->stock }}">
                                    @if ($errors->has('stock'))
                                        <p class="text-danger">{{ $errors->first('stock') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="sku">Sku</label>
                                    <input id="sku" class="form-control" name="sku" value="{{ $product->sku }}">
                                    @if ($errors->has('sku'))
                                        <p class="text-danger">{{ $errors->first('sku') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="expired_at">Expired at</label>
                                    <input type="date" id="expired_at" name="expired_at" class="form-control" value="{{ $product->expired_at }}">
                                    @if ($errors->has('expired_at'))
                                        <p class="text-danger">{{ $errors->first('expired_at') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Select product category</label>
                                    <select id="category_id" name="category_id" class="form-control custom-select">
                                        <option value="{{ $product->category_id }}">{{$product->category->name}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{$category->name}}</option>
                                            @if($categoriesLv2[$category->id] != null)
                                                @foreach($categoriesLv2[$category->id] as $item)
                                                    <option class="text-center" value="{{ $item->id }}">{{$item->name}}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <p class="text-danger">{{ $errors->first('category_id') }}</p>
                                    @endif
                                </div>
                                <div class="form-group d-flex justify-content-between">
                                    <button type="button" class="btn btn-primary btn-pre" data-toggle="modal" data-target="#exampleModal">
                                        Preview
                                    </button>
                                    <button type="submit" class="btn-submit btn-sm btn btn-success">Update Product</button>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </section>
    </div>
@endsection
