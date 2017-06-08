
/*define(["block_world_clock/moment-timezone-with-data"],
    function (moment) {
        return {
            initialise: function () {
                moment().tz("America/Los_Angeles").format();
            }
        };
});*/

define(["jquery","moment"],
    function (jquery,moment) {
        return {
            initialise: function () {
                console.log(moment().tz("America/Los_Angeles").format());
            }
        };
    });