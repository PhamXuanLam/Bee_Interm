<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xem lại thông tin sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="preview">
                    <table class="table text-center table-bordered">
                        <tr>
                            <th>Avatar</th>
                            <td>
                                @if(isset($product) && $product->avatar)
                                    <div class="imagePreview">
                                        <img src="{{ route("product.image", ["avatar" => $product->avatar, 'id' => $product->id]) }}"
                                             style="width: 100px; height: 100px">
                                    </div>
                                @else
                                    <div class="imagePreview">
                                        <img src="{{ asset("vendor/adminlte/dist/img/avatar.png") }}" style="width: 100px; height: 100px">
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>User ID</th>
                            <td id="pre-user_id"></td>
                        </tr>
                        <tr>
                            <th>Sku</th>
                            <td id="pre-sku"></td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td id="pre-name"></td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td id="pre-stock"></td>
                        </tr>
                        <tr>
                            <th>Expired at</th>
                            <td id="pre-expired_at"></td>
                        </tr>
                        <tr>
                            <th>Category id</th>
                            <td id="pre-category_id"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn-submit btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // xử lý avatar
        $("#avatar").on("change", function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var imgSrc = e.target.result;

                // Kiểm tra xem có phần tử <img> trong #imagePreview hay không
                if ($('.imagePreview').find('img').length) {
                    // Nếu có, cập nhật nguồn ảnh của nó
                    $('.imagePreview img').attr('src', imgSrc);
                }
                var img = $('<img>').attr('src', imgSrc).attr('style', 'width: 70px; height: 70px;');
                $('.imagePreview').html(img);
            }

            reader.readAsDataURL(file);
        });

        $(".btn-pre").on("click", function () {
            let user_id = null;
            @if(isset($product))
                user_id = {{ $product->user_id }};
            @elseif(\Illuminate\Support\Facades\Auth::check())
                user_id = {{ \Illuminate\Support\Facades\Auth::user()->getAuthIdentifier() }};
            @endif
            $("#pre-user_id").html(user_id);

            let sku = $("#sku").val();
            $("#pre-sku").html(sku);

            let name = $("#name").val();
            $("#pre-name").html(name);

            let stock = $("#stock").val();
            $("#pre-stock").html(stock);

            let expired_at = $("#expired_at").val();
            $("#pre-expired_at").html(expired_at);

            let category_id = $("#category_id").val();
            $("#pre-category_id").html(category_id);
        });
    });
</script>
