define([
    'mage/translate'
], function ($t) {
    'use strict';

    return function (rules) {
        rules['validate-unicode'] = {
            handler: function (v) {
                return /^([A-z0-9\.\/_-])*/i.test(v);
            },
            message: $t('Please use only letters (a-z or A-Z), numbers (0-9), symbols (- _ . /) in this field. No spaces or other characters are allowed.')
        };

        return rules;
    };
});