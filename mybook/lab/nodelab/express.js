/***
 * this script need express framework.
 */

var express = require('express')
var app = express()

app.get('/' , function(req , res) {
    res.send("Hello world")
})

app.post("/" , function(req , res) {
    console.log("main page request")
    res.send("Hello Post")
})

app.get("/del_user" , function(req , res) {
    console.log("/del_user response to delete request")
    res.send("del the page")
})

app.get("/list_user" , function(req , res){
    console.log("/list+user get request")
    res.send("user list page")
})

app.get("/ab*cd" , function(req , res){
    console.log("/ab*cd GET")
    res.send("regex")
})

var server = app.listen(8081 , function() {
    var host = server.address().address
    var port = server.address().port
    console.log("your host , your site is http://%s:%s" , host , port)
})
