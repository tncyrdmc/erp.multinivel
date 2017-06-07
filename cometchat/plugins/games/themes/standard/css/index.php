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
	overflow: hidden;
	background: <?php echo $themeSettings['tab_background'];?>;
	direction: <?php echo $dir;?>;
}

ul {
	float: left;
	width: 100%; 
	margin: 0;
	padding: 0;
	list-style: none;
	list-style-image: none;
	padding-<?php echo $left;?>: 15px;
}

li {
	float: left;
	width: 130px;
	margin: 0;
	height: 20px;
	padding: 0px;
	cursor: pointer;
	position: relative;
} 

li:before {
    background: url("themes/<?php echo $theme;?>/images/bullet.png") no-repeat scroll rgba(0, 0, 0, 0);
    content: "";
    height: 10px;
    position: absolute;
    left: -10px;
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
	width:98%;
	margin:0 auto;
	margin-top: 5px;
}

.container_title {
	background-color: <?php echo $themeSettings['tab_title_background'];?> !important;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $themeSettings['tab_title_gradient_start'];?>', endColorstr='<?php echo $themeSettings['tab_title_gradient_end'];?>');
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $themeSettings['tab_title_gradient_start'];?>), to(<?php echo $themeSettings['tab_title_gradient_end'];?>));
	background: -moz-linear-gradient(top, <?php echo $themeSettings['tab_title_gradient_start'];?>, <?php echo $themeSettings['tab_title_gradient_end'];?>);
	background: -ms-linear-gradient(top, <?php echo $themeSettings['tab_title_gradient_start'];?>, <?php echo $themeSettings['tab_title_gradient_end'];?>);
	background: -o-linear-gradient(top, <?php echo $themeSettings['tab_title_gradient_start'];?>, <?php echo $themeSettings['tab_title_gradient_end'];?>);
	border-left: 1px solid <?php echo $themeSettings['tab_title_border'];?>;
	border-right: 1px solid <?php echo $themeSettings['tab_title_border'];?>;
	border-top: 1px solid <?php echo $themeSettings['tab_title_border'];?>;
	color: <?php echo $themeSettings['tab_title_color'];?>;
	font-family: <?php echo $themeSettings['tab_title_font_family'];?>;
	font-size: <?php echo $themeSettings['tab_title_font_size_large'];?>;
	padding: 5px;
	font-weight: bold;
	padding-left: 10px;
	padding-bottom: 6px;
	text-shadow: 1px 1px 0 <?php echo $themeSettings['tab_title_text_background'];?>;
}

.container_body {
	border-left: 1px solid <?php echo $themeSettings['tab_border'];?>;
	border-bottom: 1px solid <?php echo $themeSettings['tab_border'];?>;
	border-right: 1px solid <?php echo $themeSettings['tab_border'];?>;
	background-color: <?php echo $themeSettings['tab_background'];?>;
	color: <?php echo $themeSettings['tab_color'];?>;
	padding: 5px;
	font-weight: normal;
	font-family: <?php echo $themeSettings['tab_font_family'];?>;
	font-size: <?php echo $themeSettings['tab_font_size'];?>;
	padding: 10px 10px;
}

.container_body.embed {
	border: 0px;
	padding: 10px;
}

.container_title.embed {
	display: none;
}

</style>