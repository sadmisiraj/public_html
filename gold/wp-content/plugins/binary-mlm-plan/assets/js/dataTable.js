var $ = jQuery.noConflict();
$(document).ready(function () {
    $('#leftDownlines, #rightDownlines, #payoutsList, #runPayouts, #payoutReferral, #frontpayoutsList').DataTable({
        "searching": true,
        "responsive": true,
        "autoWidth": false,
        "paging": false,
        "lengthChange": false,
        "columnDefs": [
            { "className": "text-center", "targets": "_all" } // Center columns 0, 1, 2
        ],
    });
});
