import $ from 'jquery';

const Routing = require('../../route/routing.js');

$(document).ready(function() {
    $('#create-block-type-button').click(function() {
        window.location.replace(Routing.generate('admin_block_type_create'));
    });
});
