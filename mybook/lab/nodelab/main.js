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

//process.on("exit" , function(code) {
//    setTimeout(function() {
//        console.log("this code will not execute")
//    } , 0)
//    console.log("exit code:" , code)
//})
//// super global variables in nodejs.
//console.log("program exit")
//
//process.stdout.write("Hello world!\n")
//
//process.argv.forEach(function(val , index , array){
//    console.log(index + ": " + val)
//})
//
//console.log(process.execPath)
//console.log(process.platform)
//console.log("current dir:" + process.cwd())
//
//console.log("current node version: " + process.version)
//console.log(process.memoryUsage())
//

function test_util() {
    function test1() {
        var utils = require("util")

        function Base() {
            this.name = "base"
            this.base = 1991
            this.sayHello =  function() {
                console.log("Hello " + this.name)
            }
        }

        Base.prototype.showName = function() {
            console.log(this.name)
        }

        function Sub() {
            this.name = 'sub'
        }

        utils.inherits(Sub , Base)

        var objBase = new Base()
        objBase.showName()
        objBase.sayHello()
        console.log(objBase)
        var objSub = new Sub()

        objSub.showName()
        console.log(objSub)
    }

    function test2 () {
        var util = require("util") 
        function Person() {
            this.name = 'byvoid'
            this.toString = function() {
                return this.name
            }
        }

        var obj = new Person()
        console.log(util.inspect(obj))
        console.log(util.inspect(obj , true))
    }

    function test3() {
        var util = require('util')
        util.isArray([])
        util.isArray({})
    }
    var util = require('util')
    util.isRegExp(/some regex/)
    util.isRegExp(new RegExp('another regexp'))
    util.isRegExp({})
}

function test_fs() {
    function open_test() {
        var fs = require("fs")
        console.log("before open the file")
        fs.stat("input.txt" , function(err ,stats) {
            if(err) {
                return console.error(err)
            }
            console.log(stats)
        })
    }

    function write_test() {
        var fs = require("fs")
        console.log("before write something")
        write_content = "this is content I want to wirte to this file"
        file_name = "input.txt"
        fs.writeFile(file_name , write_content , function(err){
            if(err) {
                return console.error(err)
            }

            console.log("data write success")
            console.log("--------------------")
            console.log("read data that your wrote to file")
            
            fs.readFile(file_name , function(err , data) {
                if(err) {
                    return console.error(err)
                }
                console.log("read from file: " + data.toString())
            })
        })
    } 

    function ulink_file() {
        var fs = require("fs")
        fs.unlink("input.txt" , function(err){
            if (err) {
                return console.error(err)
            }
            console.log("file delete success")
        })
    }

    function read_dir() {
        var fs = require("fs")
        console.log("see your current dir")

        fs.readdir("../" , function(err , files){
            if(err) {
                return console.error(err)
            }
            files.forEach(function(file){
                console.log(file)
            })
        })
    }
    read_dir()
}
test_fs()
