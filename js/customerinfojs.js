/**
 * Given a credit card number, it validates if it is 16 digits or not
 * @param input credit card number
 */
function validateCreditCard(input) {
    var pattern = new RegExp("^[0-9]{16}$");
    if (input.value.trim().length !== 16 || pattern.test(input.value.trim()) === false) {
        input.setCustomValidity("Enter a valid 16 digit credit card number.");
    }
    else {
        input.setCustomValidity("");
    }
}

/**
 * Give a credit card expiration date, it validates if it is in 
 * its proper format (MM/YY) and checks that it has not expired
 * yet
 * @param input credit card expiration
 */
function validateExpirationDate(input) {
    var pattern = new RegExp("^[0-9]{2}\/[0-9]{2}$");
    var inputTrim = input.value.trim();
    var valid = false;
    var notExpired = false;
    var month = inputTrim.substring(0, 2);
    var year = inputTrim.substring(3, 5);
    var date = new Date();

    if (pattern.test(inputTrim) === true
            && parseInt(month) > 0 && parseInt(year) >= 0) {
        valid = true;

        if (parseInt((date.getFullYear() + "").substring(2, 4)) < parseInt(year)
                || (parseInt((date.getFullYear() + "").substring(2, 4)) === parseInt(year)
                && (parseInt(date.getMonth()) + 1) <= parseInt(month))) {
            notExpired = true;
        }
    }

    if (valid && notExpired) {
        input.setCustomValidity("");
    }
    else if (valid && notExpired === false) {
        input.setCustomValidity("Credit card is expired.");
    }
    else {
        input.setCustomValidity("Enter a valid expiration date (MM/YY).");
    }
}
