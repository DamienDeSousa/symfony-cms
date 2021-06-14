const routes = require("../../../public/js/fos_js_routes.json");

// do not forget to dump your assets `symfony console assets:install --symlink public`
const Routing = require("../../../public/bundles/fosjsrouting/js/router.min.js");

Routing.setRoutingData(routes);

module.exports = Routing;