// Initialise a dataTable
$(document).ready(function() {
    if ($('table#inventory')) {
        $('table#inventory').dataTable({
            "pageLength": 100
        });
    }
});
