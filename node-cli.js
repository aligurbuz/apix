#!/usr/bin/env '+this.argv['dir']+'

/**
 * boardDir is path that in external/public,that is admin directory
 * widgetFile is path that in external/public/boardDir/widgets,that is admin widgets
 * boardFile is path that in external/public/boardDir/board,that is admin board -- dashboard
 * partChangeAble starts with @@@ --- it is for boardFile
 *
 */
//using : node node-cli board --app boardDir --widgets widgetFile --board boardFile --change partChangeAble

"use strict";

var path = require('path');
var appDir = path.dirname(require.main.filename);

var Cli = new require("n-cli");
var cli = new Cli({
  silent: false,
  handleUncaughtException : true
});

cli.on("board", function(){

  var fs = require('fs');
  fs = require('fs');

  var app=this.argv['app'];
  var widget=this.argv['widgets'];
  var board=this.argv['board'];
  var change=this.argv['change'];

  var boardFile='./external/public/'+app+'/board/'+board;
  var widgetFile='./external/public/'+app+'/widgets/'+widget;

  fs.readFile(widgetFile, 'utf8', function (err,data) {
    if (err) {
      return console.log(err);
    }

    fs.readFile(boardFile, 'utf8', function (err,boardData) {
      if (err) {
        return console.log(err);
      }

      var changeData=boardData.replace(new RegExp("@@@"+change, "g"),data);


      fs.writeFile(boardFile, changeData, function (err) {
        if (err) return console.log(err);
        console.log('board ok');

      });

    });


  });

});
