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

    function reduceQty(id, how_many, el) {
        // AJAX call to reduce items
        $.ajax({
            method : "GET",
            url    : "/reduce/" + id + "/" + how_many,
        }).done(function(v) {
            if (false == v.result) {
                bootbox.alert('Cannot reduce ' + how_many + ' due to not having required quantity in stock.');
            }

            if (v.hasOwnProperty('qty')) {
                el.html(v.qty);
            }
        });
    }

    // Button minus
    $('button.btn-minus').on('click', function(evt) {
        var $input   = $(evt.target).parents('div.input-group').find('input');
        var id       = $input.data('supplier-item-id');
        var user_val = $input.val();

        how_many = 1;
        if (isNaN(parseInt(user_val))) {
            $input.val(how_many);
        } else {
            how_many = parseInt(user_val);
        }

        if (how_many > 1) {
            bootbox.confirm(
                "Taking " + how_many + " item?",
                function(result) {
                    if (false == result) {
                        return;
                    }

                    reduceQty(id, how_many, $(evt.target).parents('td.supplier').find('span.label'));
                    $input.val(1);
                }
            );
        } else {
            reduceQty(id, how_many, $(evt.target).parents('td.supplier').find('span.label'));
            $input.val(1);
        }

    });
});
