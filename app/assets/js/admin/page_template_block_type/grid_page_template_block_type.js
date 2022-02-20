import $ from 'jquery';

const Routing = require('../../route/routing.js');

$(document).ready(function() {
    $('#create-page-template-block-type-button').click(function() {
        window.location.replace(Routing.generate('admin_page_template_block_type_create'));
    });
});
