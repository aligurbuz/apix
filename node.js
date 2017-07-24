'use strict';
/**
 * get path for main directory.
 *
 * @param {object} req
 * @public
 */

/**
 * get path for main directory.
 *
 * @param {object} req
 * @public
 */
global.path = require('path');
global.appDir = path.dirname(require.main.filename);

/**
 * Start express project.
 *
 * @param {object} req
 * @public
 */
var express=require("express");

/**
 * get express method--top level
 *
 * @param {object} req
 * @public
 */
var app=express();

/**
 * Get config for app settings.
 *
 * @param {object} req
 * @public config.js
 */
global.async = require("async");

var http = require('http').Server(app);

/**
 * express route body parser .
 *
 * @param {object} req
 * @public
 */
var bodyParser = require('body-parser');
app.use(bodyParser.json()); // support json encoded bodies
app.use(bodyParser.urlencoded({ extended: true })); // support encoded bodies

var favicon = require('serve-favicon');
app.use(favicon(__dirname + '/favicon.ico'));

/**
 * express route .
 *
 * @param {object} req
 * @public
 */
app.all("/:app/:node/:token",function (request,response,next){

  if(request.params.name=="favicon.ico")
  {
    response.send("favicon.ico")
  }

  /**
   * Get base config for app.
   *
   * @param {object} req
   * @public config.js
   */
  global.base = require("./src/app/"+request.params.app+"/kernel/node/app.js");

  response.setHeader('Content-Type', 'application/json');
  base.config(request,function(resultData){
    response.json(resultData);
  })
});

http.listen(3000);