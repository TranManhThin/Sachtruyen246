$(function() {
    $(document).on('click', '#actionDelete', actionDelete)
});

function actionDelete(event) {
    let dataUrl = $(this).data('url');
    let thisBu = $(this);
    event.preventDefault();
    Swal.fire({
        title: "Xác nhận?",
        text: "Bạn chắc chắn xóa!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Xóa!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                url: dataUrl,
                success: function(data) {
                    if (data.code == 200) {

                        // window.location.href = "settings";

                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "success"
                        });
                        location.reload(true);
                    }
                },
                error: function() {

                }
            });

        }
    });
}
