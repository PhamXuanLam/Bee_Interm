<script>
    $(document).ready(function () {

        function getAdministrative(id, str, dom, name) {
            $.ajax({
                url: "/admin/administrative/" + id + str,
                method: "GET",
                dataType: 'json',
                success: function(response) {
                    dom.removeAttr("disabled");
                    dom.empty();
                    dom.append('<option value="">' + name + '</option>');
                    $.each(response, function(key, val) {
                        dom.append('<option value="' + val.id +
                            '">' + val.name + '</option>');
                    });
                }
            });
        }

        @if(old("province") != null)
            $.ajax({
                url: "/admin/administrative/" + {{ old("province") }} + "/district",
                method: "GET",
                dataType: 'json',
                success: function(response) {
                    let district = $("#district");
                    district.removeAttr("disabled");
                    district.empty();
                    district.append('<option value="">Quận (Huyện)</option>');
                    $.each(response, function(key, val) {
                        district.append('<option value="' + val.id +
                            '">' + val.name + '</option>');
                    });
                    @if(old("district") != null)
                        district.find('option[value="{{ old('district') }}"]').prop('selected', true);
                        district.find('option[value=""]').remove();
                    @endif
                }
            });
        @endif

        @if(old("district") != null)
        $.ajax({
            url: "/admin/administrative/" + {{ old("district") }} + "/commune",
            method: "GET",
            dataType: 'json',
            success: function(response) {
                let commune = $("#commune");
                commune.removeAttr("disabled");
                commune.empty();
                commune.append('<option value="">Phường (Xã)</option>');
                $.each(response, function(key, val) {
                    commune.append('<option value="' + val.id +
                        '">' + val.name + '</option>');
                });
                @if(old("commune") != null)
                    commune.find('option[value="{{ old('district') }}"]').prop('selected', true);
                    commune.find('option[value=""]').remove();
                @endif
            }
        });
        @endif

        $('#province').change(function () {
            getAdministrative($('#province').val(), "/district", $('#district'), "Quận (Huyện)");
        });

        $('#district').change(function () {
            getAdministrative($('#district').val(), "/commune", $('#commune'), "Phường (Xã)");
        });

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

    });
</script>
