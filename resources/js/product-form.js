/*global document, window */

(function () {
    "use strict";
    var productForm = document.querySelector('.meals__product-form');
    if (!productForm) {
        return;
    }


    var selectElt = productForm.querySelector('select[name=barcode]'),
        inputElt = productForm.querySelector('input[name=barcode]'),
        radioBtns = productForm.querySelectorAll('input[type=radio][name=barcode_source]'),
        i;

    var toggleSource = function (source) {
        if (source === 'select') {
            selectElt.disabled = false;
            inputElt.disabled = true;
        } else {
            selectElt.disabled = true;
            inputElt.disabled = false;
        }
    };

    for (i = 0; i < radioBtns.length; i += 1) {
        radioBtns[i].addEventListener('change', function () {
            toggleSource(this.value);
        });
    }

    toggleSource(radioBtns[0].value);
}());