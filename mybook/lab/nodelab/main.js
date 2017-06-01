//var fs = require("fs") 
//var data = fs.readFileSync('input.txt')
//console.log(data.toString())
//console.log("ending")

//fs.readFile('input.txt' , function(err , data){
//    if(err) return console.error(err)
//    console.log(data.toString())
//})
//console.log("ending")


//s = [1,8,3,4]
//s = {}
//s["hello"] = 1
//s["world"] = 2
//
//for(var x in s) {
//    console.log(x + "  " + s[x])
//}
//

// first you should require some events

//var events = require('events')
//var eventEmitter = new events.EventEmitter()
//
//
//var connectHandler = function(arg1 , arg2 , arg3) {
//    console.log("connection finished!")
//    eventEmitter.emit("data_recieved")
//    console.log(arg1)
//    console.log(arg2)
//    console.log(arg3)
//}
//eventEmitter.on("connection" , connectHandler)
//
//eventEmitter.on("data_recieved" , function() {
//    console.log("data recieved!")
//})
//
//eventEmitter.removeListener("data_recieved" , function () {
//    console.log("data_recieved removed!")
//})
//// you can add some args for your functions.
//eventEmitter.emit("connection" , "hello" ,"world" ,"this")

//var buf1 = new Buffer(100)
//len = buf1.write("Hello world , welcome to nodejs.      ")
//console.log("buffer length is:" + buf1.length)
//var buf2 = new Buffer("would you like")
//
//var buf3 = Buffer.concat([buf1 , buf2])
//
//console.log("buf content: " + buf3.toString())
//var fs = require("fs")
//var data = ''
//var readerStream = fs.createReadStream("input.txt")
//readerStream.setEncoding("utf8")
//
//readerStream.on("data" , function(chunk){
//    data += chunk
//})
//
//readerStream.on("end" , function(){
//    console.log(data)
//})
//
//readerStream.on("error" , function(err){
//    console.log(err.stack)
//})
//
//console.log("program finished!")

//var fs = require("fs")
//var data = "this is a test text , you can write data into a text file"
//var writeStream = fs.createWriteStream("output.txt")
//writeStream.write(data , 'utf8')
//writeStream.end()
//writeStream.on('finish' , function() {
//    console.log("write finished")
//})
//
//writeStream.on("error" , function(err){
//    console.log(err.stack)
//})
//
//console.log("program finished")
//var fs = require("fs")
//var readerStream  = fs.createReadStream("input.txt")
//var writeStream   = fs.createWriteStream("xxxxx.txt")
//
//readerStream.pipe(writeStream)
//
//console.log("porgram finished")
//var fs = require("fs")
//var zlib = require("zlib")
//
//fs.createReadStream("input.txt").pipe(zlib.createGzip()).pipe(fs.createWriteStream('input.txt.gz'))
//
//console.log("compress finished")
//var fs = require("fs")
//var zlib = require("zlib")
//
//fs.createReadStream('input.txt.gz').pipe(zlib.createGunzip()).pipe(fs.createWriteStream('input.txt'))
//
//console.log("decompress finished")
//var hello = require('./hello')
//h = new hello()
//h.setName("Bvoid")
//h.sayHello()

var http = require("http")
var url = require("url")

function start() {
    function onRequest(request , response) {
        var pathname = url.parse(request.url).pathname;
        console.log("Request for " + pathname + "received")
        response.writeHead(200 ,{"Content-Type" + "text/plain"})
        response.write("Hello World")
        response.end()
    }
    http.creaetServer(onRequest).listen(8888);
    console.log("Server started")
}

exports.start = start
