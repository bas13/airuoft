<h3>Payment</h3> 
<h4>All fields are required</h4>
<?php
    // Customer info form validation
    echo form_open('customerinfo_controller/register');

    echo form_label('First name');
    echo "&nbsp";
    echo form_input('firstname', set_value('firstname'), 'required');
    echo form_error('firstname');

    echo '<br/>';
    echo '<br/>';

    echo form_label('Last name');
    echo "&nbsp";
    echo form_input('lastname', set_value('lastname'), 'required');
    echo form_error('lastname');

    echo '<br/>';
    echo '<br/>';

    echo form_label('Credit Card Number');
    echo "&nbsp";
    echo form_input('creditcard', set_value('creditcard'), 'required oninput="validateCreditCard(this);"');
    echo form_error('creditcard');

    echo '<br/>';
    echo '<br/>';

    echo form_label('Credit Card Expiration Date');
    echo "&nbsp";
    echo form_input('expirationdate', set_value('expirationdate'), 'required oninput="validateExpirationDate(this);"');
    echo form_error('expirationdate');

    echo '<br/>';
    echo '<br/>';

    echo form_submit('submit', 'Buy Ticket');
?>
