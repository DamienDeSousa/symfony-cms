// import '../../../css/admin/admin_layout.css'
import $ from 'jquery';
import Routing from "../../route/routing.js";

$(document).ready(function() {
    let rowBtnInfo = $("table > tbody > tr > td > .btn-outline-info");
    rowBtnInfo.click(function(e) {
        let entityId = $(this).data('entity-id');
        let routeName = $(this).data('route-name');
        window.location.replace(Routing.generate(routeName, {id: entityId}));
    });

    let rowBtnEdit = $('table > tbody > tr > td > .btn-outline-warning');
    rowBtnEdit.click(function(e) {
        let entityId = $(this).data('entity-id');
        let routeName = $(this).data('route-name');
        window.location.replace(Routing.generate(routeName, {id: entityId}));
    });
});
