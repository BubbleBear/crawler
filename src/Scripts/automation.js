"use strict";

var page = require('webpage').create(),
    system = require('system'),
    args = system.args;

if (args.length === 1) {
    console.log('no url provided!');
} else {
    page.open(args[1], function (status) {
        var height = page.evaluate(function () {
            return document.height;
        });

        if (status === 'success') {
            page.viewportSize = {
                width: 1920,
                height: height, 
            };

            setTimeout(function () {
                console.log(page.content);
                phantom.exit();
            }, args[2] === undefined ? 0 : args[2]);
        }
    });
}
