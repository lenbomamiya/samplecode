// node.js ./logger.js

var http = require('http');
var fs = require('fs');
var documentRoot = './';

var server= http.createServer(function(req,res){
    var url = req.url; 
    var date = new Date();
    var hourString = (date.getHours() < 10 ? "0":"") + date.getHours();
    var minutesString = (date.getMinutes() < 10 ? "0":"") + date.getMinutes();
    var secondString = (date.getSeconds() < 10 ? "0":"") + date.getSeconds();
    console.log(hourString +":"+minutesString+":"+secondString + "    " + decodeURI(url.substr(2)));
    
    res.writeHeader(200,{
        "Access-Control-Allow-Origin" : "*",
    });

    res.write("OK");
    res.end();
}).listen(8878);