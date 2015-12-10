<?php

foreach($GLOBALS['TL_DCA']['tl_content']['palettes'] as $k=>$v)
{
	if($k != '__selector__')
	{
		$GLOBALS['TL_DCA']['tl_content']['palettes'][$k] .= ';{log_legend},outSide_log';
	}
}

$GLOBALS['TL_DCA']['tl_content']['fields']['outSide_log'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['outSide_log'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'sql'                     => "char(1) NOT NULL default ''"
);