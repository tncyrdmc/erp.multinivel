<style>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * CometChat 
 * Copyright (c) 2014 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-weight: inherit;
    font-style: inherit;
    font-size: 100%;
    font-family: inherit;
    vertical-align: baseline;
    text-align: center;
}

html {
    height: 100%;
    overflow: hidden; /* Hides scrollbar in IE */
}

body {
    background: #ffffff;
    margin: 0px;
}

#flashcontent {
    height: 100%;
}

#sketch {
    cursor: url(plugins/handwrite/images/pencil.png), auto;
}

.width-btn {
    border-left: 1px solid #000000;
    border-right: 1px solid #515353;
    color: #FFFFFF;
    display: inline-block;
    float: left;
    font-family: Tahoma;
    font-size: 8px;
    font-weight: bold;
    padding: 10px 5px;
    width: 65px;
}

.width-select {
    margin-left: 6px; 
}

.onepx {
    border-left: 1px solid #FFFFFF;
}

.twopx {
    border-left: 2px solid #FFFFFF;
}

.threepx {
    border-left: 3px solid #FFFFFF;
}

.fourpx {
    border-left: 4px solid #FFFFFF;
}

.color-btn > img {
    border-bottom: 4px solid red;
    padding-bottom:3px;
}

.color-btn {
    background-repeat: no-repeat;
    border-left: 1px solid #000000;
    border-right: 1px solid #515353;
    display: inline-block;
    float: left;
    padding: 3px 4px;
    width: 20px;
    cursor: pointer;
}

.selected {
    -moz-box-shadow:   0 0 4px 2px #FF0000;
    -webkit-box-shadow: 0 0 4px 2px #FF0000;
    box-shadow:         0 0 4px 2px #FF0000;
}

.pencil-btn, .eraser-btn {
    display: inline-block;
    padding: 7px 4px;
    width: 20px;
    float: left;
    border-left: 1px solid #000000;
    border-right: 1px solid #515353;
    cursor: pointer;
}

.send-btn {
    float: right;
    height: 18px;
    padding: 7px;
    text-align: center;
}

.send-btn span{
    background: #ff3019; /* Old browsers */
    background: -moz-linear-gradient(top, #ff3019 0%, #bf1003 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff3019), color-stop(100%,#bf1003)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, #ff3019 0%,#bf1003 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, #ff3019 0%,#bf1003 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top, #ff3019 0%,#bf1003 100%); /* IE10+ */
    background: linear-gradient(to bottom, #ff3019 0%,#bf1003 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff3019', endColorstr='#bf1003',GradientType=0 ); /* IE6-9 */
    border-radius: 15px 15px 15px 15px;
    color: #FFFFFF;
    font-family: arial;
    font-size: 10px;
    font-weight: bold;
    padding: 2px 0;
    text-shadow: 0 0 1px #000000;
    width: 68px;
    display: inline-block;
    cursor: pointer;
}

#footer {
    background: #303434; /* Old browsers */
    background: -moz-linear-gradient(top, #303434 0%, #303434 50%, #222424 51%, #222424 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#303434), color-stop(50%,#303434), color-stop(51%,#222424), color-stop(100%,#222424)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, #303434 0%,#303434 50%,#222424 51%,#222424 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, #303434 0%,#303434 50%,#222424 51%,#222424 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top, #303434 0%,#303434 50%,#222424 51%,#222424 100%); /* IE10+ */
    background: linear-gradient(to bottom, #303434 0%,#303434 50%,#222424 51%,#222424 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#303434', endColorstr='#222424',GradientType=0 ); /* IE6-9 */
    overflow: hidden;
    cursor: default;
    position: fixed;
    width: 100%;
    bottom: 0;
}

.color-select {
    background: none repeat scroll 0 0 #303434;
    border-radius: 5px 5px 0 0;
    bottom: 37px;
    height: 35px;
    left: 135px;
    position: fixed;
    width: 90px;
    display:none;
    padding:2px 2px 0;
    cursor: pointer;
}

.color-opt {
    height: 11px;
    width: 14px;
    border:2px solid #fff;
    border-radius:50%;
    float: left;
    margin-bottom:3px;
}

.deepskyblue  {
    background: #87e0fd; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #87e0fd 0%, #53cbf1 40%, #05abe0 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#87e0fd), color-stop(40%,#53cbf1), color-stop(100%,#05abe0)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #87e0fd 0%,#53cbf1 40%,#05abe0 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #87e0fd 0%,#53cbf1 40%,#05abe0 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #87e0fd 0%,#53cbf1 40%,#05abe0 100%); /* IE10+ */
    background: linear-gradient(135deg, #87e0fd 0%,#53cbf1 40%,#05abe0 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#87e0fd', endColorstr='#05abe0',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */ 
}

.red {
    background: #ff3019; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #ff3019 0%, #cf0404 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ff3019), color-stop(100%,#cf0404)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #ff3019 0%,#cf0404 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #ff3019 0%,#cf0404 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #ff3019 0%,#cf0404 100%); /* IE10+ */
    background: linear-gradient(135deg, #ff3019 0%,#cf0404 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff3019', endColorstr='#cf0404',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */ 

}
.chartreuse {
    background: #9dff02; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #9dff02 0%, #7cbc0a 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#9dff02), color-stop(100%,#7cbc0a)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #9dff02 0%,#7cbc0a 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #9dff02 0%,#7cbc0a 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #9dff02 0%,#7cbc0a 100%); /* IE10+ */
    background: linear-gradient(135deg, #9dff02 0%,#7cbc0a 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#9dff02', endColorstr='#7cbc0a',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}


.blueviolet {
    background: #a623ff; /* Old browsers */
    background: -moz-linear-gradient(-45deg,  #a623ff 0%, #7400c4 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#a623ff), color-stop(100%,#7400c4)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg,  #a623ff 0%,#7400c4 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg,  #a623ff 0%,#7400c4 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg,  #a623ff 0%,#7400c4 100%); /* IE10+ */
    background: linear-gradient(135deg,  #a623ff 0%,#7400c4 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a623ff', endColorstr='#7400c4',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

}

.black {
    background: #45484d; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #45484d 0%, #000000 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#45484d), color-stop(100%,#000000)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #45484d 0%,#000000 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #45484d 0%,#000000 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #45484d 0%,#000000 100%); /* IE10+ */
    background: linear-gradient(135deg, #45484d 0%,#000000 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45484d', endColorstr='#000000',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */ 
}

.gold  {
    background: #ffd65e; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #ffd65e 0%, #cea904 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffd65e), color-stop(100%,#cea904)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #ffd65e 0%,#cea904 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #ffd65e 0%,#cea904 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #ffd65e 0%,#cea904 100%); /* IE10+ */
    background: linear-gradient(135deg, #ffd65e 0%,#cea904 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffd65e', endColorstr='#cea904',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */ 
}

.green {
    background: #006e2e; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #006e2e 0%, #001915 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#006e2e), color-stop(100%,#001915)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #006e2e 0%,#001915 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #006e2e 0%,#001915 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #006e2e 0%,#001915 100%); /* IE10+ */
    background: linear-gradient(135deg, #006e2e 0%,#001915 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#006e2e', endColorstr='#001915',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}

.white{
    background: #ffffff; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #ffffff 0%, #bfbfbf 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#bfbfbf)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #ffffff 0%,#bfbfbf 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #ffffff 0%,#bfbfbf 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #ffffff 0%,#bfbfbf 100%); /* IE10+ */
    background: linear-gradient(135deg, #ffffff 0%,#bfbfbf 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#bfbfbf',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */ 
}


.maroon{
    background: #a90329; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #a90329 0%, #8f0222 44%, #6d0019 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#a90329), color-stop(44%,#8f0222), color-stop(100%,#6d0019)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #a90329 0%,#8f0222 44%,#6d0019 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #a90329 0%,#8f0222 44%,#6d0019 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #a90329 0%,#8f0222 44%,#6d0019 100%); /* IE10+ */
    background: linear-gradient(135deg, #a90329 0%,#8f0222 44%,#6d0019 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a90329', endColorstr='#6d0019',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}

.steelblue {
    background: #4682b4; /* Old browsers */
    background: -moz-linear-gradient(-45deg, #4682b4 0%, #23538a 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#4682b4), color-stop(100%,#23538a)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(-45deg, #4682b4 0%,#23538a 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(-45deg, #4682b4 0%,#23538a 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(-45deg, #4682b4 0%,#23538a 100%); /* IE10+ */
    background: linear-gradient(135deg, #4682b4 0%,#23538a 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4682b4', endColorstr='#23538a',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */ 
}

</style>