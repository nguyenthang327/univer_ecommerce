$(document).ready(function(){

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

    document.getElementById("text").addEventListener("input", function() {
        var text = this.value;
        var slug = slugify(text);
        document.getElementById("slug").value = slug;
    });
});