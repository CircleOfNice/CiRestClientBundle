var http = require("http");

http.createServer(function(request, response) {
	var contentType = request.headers['content-type'] ? request.headers['content-type'] : "text/plain";
	response.writeHead(request.url === '/' ? 200 : 404, {"Content-Type": contentType});
	response.write(request.method);
	response.end();
}).listen(8888);