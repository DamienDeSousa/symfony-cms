import '../../../css/admin/site/show_site.css'
import $ from 'jquery';

const Routing = require('../../route/routing.js');


$(document).ready(function() {
    $('.card').hover(function() {
        $(this).addClass('shadow rounded');
    }, function() {
        $(this).removeClass('shadow rounded');
    });

    $('.card').click(function() {
        window.location.replace(Routing.generate('admin_site_update'));
    })
});