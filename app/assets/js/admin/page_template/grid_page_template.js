import '../../../css/admin/site/show_site.css'
import $ from 'jquery';

const Routing = require('../../route/routing.js');

$(document).ready(function() {
    $('#create-page-template-button').click(function() {
        window.location.replace(Routing.generate('admin_page_template_create'));
    });
});
