<script>
    $(document).ready(function () {
        $(".btn-delete").on("click", function () {
            let that = this;
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa bản ghi?',
                showCancelButton: true,
                icon: "warning",
                confirmButtonText: 'Đồng ý',
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = parseInt($(this).attr('data-id'));
                    $.ajax({
                        url: "/product/" + id,
                        method: "DELETE",
                        success: function (response) {
                            // Xử lý phản hồi từ server
                            if (response.success) {
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'Đóng'
                                });
                                that.closest('.product').remove();
                            } else {
                                Swal.fire({
                                    title: 'Lỗi!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Đóng'
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error); // Xử lý lỗi nếu có
                        }
                    });
                }
            });
        });
    });
</script>
