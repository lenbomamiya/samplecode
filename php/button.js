//*********************************************************************
// JavaScript Document
//
// Description: 
// Programmer : lenbo
// History    : 20121101 - Release.
//              20130725 - To add comments and change function name.
//**********************************************************************

function button_color ( color ) {
	var obj = event.srcElement;
	if ( obj.tagName == "INPUT" && obj.type == "button" ) event.srcElement.style.backgroundColor = color;
}

function button_url ( url ) {
	window.location = url;
}