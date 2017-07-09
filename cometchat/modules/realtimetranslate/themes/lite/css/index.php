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
}

html, body {
	background: <?php echo $themeSettings['tab_background'];?>;
	direction: <?php echo $dir;?>;
	height:100%;
}

ul {
  float: left;
  margin: 0;
  padding: 0;
  list-style: none;
  list-style-image: none;
  padding-<?php echo $left;?>: 15px;
}

li {
  float: left;
  width: 119px;
  margin: 0;
  height: 20px;
  cursor: pointer;
  position: relative;
} 

li:before {
    background: url("themes/<?php echo $theme;?>/images/bullet.png") no-repeat scroll rgba(0, 0, 0, 0);
    content: "";
    height: 10px;
    position: absolute;
    left: -8px;
    top: 2px;
    width: 10px;
    background-position: 0 1px;
    <?php if ($rtl):?>
    background-position: 0 -8px;
    right: -13px;
    left: 0;
    <?php endif;?>
}

.container {
	font-weight:normal;
	font-family: <?php echo $themeSettings['tab_font_family'];?>;
	font-size: <?php echo $themeSettings['tab_font_size'];?>;
	color: <?php echo $themeSettings['tab_color'];?>;
	padding: 10px 8px;
	padding-<?php echo $right;?>: 0px;
	width: 255px !important;
	height:100%;
}

.container a {
	color: <?php echo $themeSettings['tab_link_color'];?>;
}

.translating {
	display: none;
}

.current {
	font-weight: bold;
	margin-bottom: 15px;
}

</style>