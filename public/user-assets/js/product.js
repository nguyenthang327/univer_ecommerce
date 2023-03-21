$(document).ready(function () {
    /** convert name to slug */
    function slugify(text) {
        // Thay thế các ký tự có dấu thành ký tự không dấu
        text = text.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        // Chuyển đổi các ký tự viết hoa thành ký tự viết thường
        text = text.toLowerCase();
        // Loại bỏ các ký tự không phải chữ cái và số
        text = text.replace(/[^a-z0-9\s]/g, "");
        // Thay thế khoảng trắng bằng dấu gạch ngang
        text = text.replace(/[\s]+/g, "-");
        return text;
    }

    document
        .getElementById("product_name")
        .addEventListener("input", function () {
            var text = this.value;
            var slug = slugify(text);
            document.getElementById("slug").value = slug;
        });

    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false;

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone("#upfile", {
        // Make the whole body a dropzone
        url: "#",
        maxFilesize: 2,
        thumbnailMethod: "crop",
        paramName: "gallery",
        autoProcessQueue: false,
        uploadMultiple: true,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
        parallelUploads: 100,
        maxFiles: 20,
        previewTemplate: previewTemplate,
        autoQueue: false,
        previewsContainer: "#previews",
        clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
    });

    myDropzone.on("addedfile", function (file) {
        var filePreview = file.previewTemplate;
        var fd = new FormData();
        fd.append("file", file);
        let token = $('meta[name="csrf-token"]').length ? $('meta[name="csrf-token"]').attr('content') : '';

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": token,
            },
            url: "/files/uploadTemp",
            cache: false,
            type: "POST",
            data: fd,
            processData: false, ///required to upload file
            contentType: false, /// required
            success: function (response) {
                $(filePreview).find("input").val(JSON.stringify(response.data));
            },
            error: function(){
                dropzone.removeFile(file);
                toastr.error('Có lỗi xảy ra', {timeOut: 5000});
            }
        });
    }),

    $(document).on("click", ".delete_gallery", function () {
    //     var $ele = $(this).parent().parent().parent();
    //     var file_name = $(this).closest(".file-row").find("input").val();
    //     $ele.fadeOut().remove();
    // });
    // $.on("removedfile", function (file) {
        let document_value = $(file.previewElement).find('input').val();
        let file_path = JSON.parse(document_value).file_path;
        let html = `<input type="hidden" name="gallery_remove[]" value="${file_path}"></input>`;
        $('#form_product').append(html);
        // $.ajax({
        //     headers: {
        //         "X-CSRF-TOKEN": token,
        //     },
        //     url: "/files/removeFile?" + $.param({
        //         'file_path': file_path
        //     }),
        //     cache: false,
        //     type: "DELETE",
        //     processData: false, ///required to upload file
        //     contentType: false, /// required
        //     success: function (response) {
        //         // console.log(response);
        //     },
        //     error: function(xhr){
        //         // console.log(xhr);
        //         // toastr.error('Có lỗi xảy ra', {timeOut: 5000});
        //     }
        // });
    })

    // DropzoneJS Demo Code End
});
