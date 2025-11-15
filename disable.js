(function() {
    $('form > input').keyup(function() {

        var empty = false;
        $('form > input').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });

        if (empty) {
            $('#hold').attr('disabled', 'disabled');
        } else {
            $('#hold').removeAttr('disabled');
        }
    });
})()