"use strict";

var page = require('webpage').create(),
    system = require('system'),
    args = system.args;

if (args.length === 1) {
    console.log('no url provided!');
    phantom.exit();
} else {
    // do not load pictures in order to optimize the performance.
    page.onResourceRequested = function (requestData, request) {
        if ((/https?:\/\/.+?\.(css|jpg|jpeg|png|gif)/gi).test(requestData['url'])) {
            request.abort();
        }
    };

    setTimeout(function () {
        phantom.exit();
    }, 30000)

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
                // page.render('test.png');
                phantom.exit();
            }, (args[2] === undefined) ? 0 : args[2]);
        }
    });
}
