// import '../../../css/admin/admin_layout.css'
import $ from 'jquery';
import Routing from "../../route/routing.js";

$(document).ready(function() {
    let gridRow = $("table > tbody > tr");
    gridRow.click(function(e) {
        let entityId = $(this).data('entity-id');
        let routeName = $(this).data('route-name');
        window.location.replace(Routing.generate(routeName, {id: entityId}));
    });
    gridRow.hover(function() {
        $(this).css('cursor', 'pointer');
    }, function () {
        $(this).css('cursor', 'default');
    });
});
