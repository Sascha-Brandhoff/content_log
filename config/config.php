<?php

/**
 * Frontend-Modules
 **/
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 0, array
(
	'content_log'        => 'ModuleContentLog'
));

/**
 * Hooks
 **/
$GLOBALS['TL_HOOKS']['contentLog'][] = array('ClassContentLog', 'checkLog');

/**
 * Copyright information
 */
$GLOBALS['TL_HEAD']['PIXELSPREADDE'] = '<!--
    This Contao OpenSource CMS uses modules from pixelSpread.de
    Copyright (c)2012 - 2014 by Sascha Brandhoff :: Extensions of pixelSpread.de are copyright of their respective owners
    Visit our website at http://www.pixelSpread.de for more information
//-->';