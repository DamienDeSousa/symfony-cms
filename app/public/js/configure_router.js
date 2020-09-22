$(document).ready(function() {
    $.getJSON('/js/fos_js_routes.json', function(data) {
        Routing.setRoutingData(data);
    });
});