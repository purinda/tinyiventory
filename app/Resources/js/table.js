// Initialise a dataTable
$(document).ready(function() {
    if ($('table#inventory')) {
        $('table#inventory').dataTable({
            "pageLength": 100
        });
    }

    // Button edit
    $('button.btn-edit').on('click', function(evt) {
        var $tr = $(evt.target).parents('tr');

        var id             = $tr.data('supplier-item-id');
        var name           = $tr.find('td.first').html();
        var description    = $tr.find('td.second').html();
        var suppliers      = $tr.find('td.supplier');
        var hospital_stock = $(suppliers[0]).find('span.label').html();
        var private_stock  = $(suppliers[1]).find('span.label').html();

        var $dialog = $('div#newItemModal');
        $dialog.find('#form_id').val(id);
        $dialog.find('#form_name').val(name);
        $dialog.find('#form_description').val(description);
        $dialog.find('#form_stock_hospital').val(hospital_stock);
        $dialog.find('#form_stock_private').val(private_stock);
    });

    // Button delete
    $('button.btn-delete').on('click', function(evt) {
        var $tr = $(evt.target).parents('tr');

        var id   = $tr.data('supplier-item-id');
        var name = $tr.find('td.first').html();

        bootbox.confirm(
            "Do you want to remove <strong>" + name + "</strong>? this action cannot be undone.",
            function(result) {
                if (false == result) {
                    return;
                }

                window.location.href = '/delete/' + id;
            }
        );

    });
});
