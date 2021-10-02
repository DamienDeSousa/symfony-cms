import '../../../css/admin/site/show_site.css'
import $ from 'jquery';

const Routing = require('../../route/routing.js');


$(document).ready(function() {
    $('.card').hover(function() {
        $(this).addClass('shadow rounded');
        $(this).css('cursor', 'pointer');
    }, function() {
        $(this).removeClass('shadow rounded');
        $(this).css('cursor', 'default');
    });

    $('.card').click(function() {
        window.location.replace(Routing.generate('admin_site_update'));
    })
});