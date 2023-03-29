<div id="loader"></div>
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="loader"></div>
        </div>
    </div>
</div>

<script>
    function loaderStart() {
        $("#loader").css({
            'display': 'block'
        });
        $("body").css({
            'pointer-events': 'none',
            'opacity': '0.6'
        });
        $(".modal-content").css({
            'pointer-events': 'none'
        });
    }

    function loaderEnd() {
        $("#loader").css({
            'display': 'none'
        });
        $("body").css({
            'pointer-events': 'all',
            'opacity': '1'
        });
        $(".modal-content").css({
            'pointer-events': 'all'
        });
    }
</script>
