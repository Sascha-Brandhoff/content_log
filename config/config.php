<?php

array_insert($GLOBALS['FE_MOD']['miscellaneous'], 0, array
(
	'content_log'        => 'ModuleContentLog'
));

$GLOBALS['TL_HOOKS']['contentLog'][] = array('ClassContentLog', 'checkLog');