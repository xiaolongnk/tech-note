var http = require("http")
var url = require("url")
var util = require("util")
var querystring = require('querystring')

var postHTML = 
    '<html><head><meta charset="utf-8"><title>菜鸟教程 Node.js 实例</title></head>' +
    '<body>' +
    '<form method="post">' +
    '网站名： <input name="name"><br>' +
    '网站 URL： <input name="url"><br>' +
    '<input type="submit">' +
    '</form>' +
    '</body></html>';


http.createServer(function (req , res){
    res.writeHead(200 , {'Content-Type':'text/plain'})

    //var params = url.parse(req.url , true).query
    //res.write("site name:" + params.name)
    //res.write("\n")
    //res.write("site url:"  + params.url)


    //var post = '';
    //req.on('data' , function(chunk){
    //    post += chunk
    //})

    //req.on('end' , function(){
    //    post = querystring.parse(post)
    //    res.end(util.inspect(post))
    var body = ""
    req.on("data" , function(chunk){ body+=chunk})
    req.on("end" , function(){
        body = querystring.parse(body)
        res.writeHead(200 , {'Content-Type' : 'text/html; charset=utf8'})
        if(body.name && body.url) {
            res.write("site name:" + body.name)
            res.write("<br>")
            res.write("site url :" + body.url)
        } else {
            res.write(postHTML)
        }
        res.end()
    })
}).listen(3000)
