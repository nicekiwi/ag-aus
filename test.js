var portfinder = require('portfinder');

  portfinder.getPort(function (err, port) {
    //
    // `port` is guarenteed to be a free port 
    // in this scope.
    //
	console.log(port);
  });
