<?php

$GLOBALS['TL_DCA']['tl_module']['palettes']['content_log'] = '{title_legend},name,headline,type;{config_legend},contentLogTpl;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['fields']['contentLogTpl'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['contentLogTpl'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_content_log', 'getCLTemplates'),
	'eval'                    => array('tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

class tl_module_content_log extends Backend
{
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	public function getCLTemplates()
	{
		return $this->getTemplateGroup('cl_');
	}
}