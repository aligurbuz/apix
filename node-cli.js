#!/usr/bin/env '+this.argv['dir']+'

//using : node node-cli board [--app board]

"use strict";

var path = require('path');
var appDir = path.dirname(require.main.filename);

var Cli = new require("n-cli");
var cli = new Cli({
  silent: false,
  handleUncaughtException : true
});

cli.on("board", function(){

  console.log(this.argv['app']);

});
