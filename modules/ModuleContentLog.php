<?php

namespace Contao;

class ModuleContentLog extends \Module
{
	protected $strTemplate = 'mod_content_log';

	public function generate()
	{
		if (TL_MODE == 'BE') {
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['content_log'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		if (!FE_USER_LOGGED_IN)
		{
			return '';
		}

		$this->Import('FrontendUser', 'Member');

		return parent::generate();
	}

	protected function compile()
	{
		$arrContent = array();
		$objContent = $this->Database->prepare("SELECT * FROM tl_content WHERE tstamp > ? && outSide_log = ? && invisible = ? ORDER BY tstamp DESC")->execute($this->Member->lastLogin, '', '');
		while($objContent->next())
		{
			$arrItem = $objContent->row();

			if($objContent->type == 'module')
			{
				$objModule = \ModuleModel::findById($objContent->module);
			}

			if($objContent->type != 'module' OR ($objContent->type == 'module' && $objModule->type != 'content_log'))
			{
				$arrItem['htmlElement'] = $this->getContentElement($objContent->id);

				foreach($GLOBALS['TL_HOOKS']['contentLog'] as $callback)
				{
					$this->import($callback[0]);
					$arrItem = $this->$callback[0]->$callback[1]($objContent->ptable, $objContent->tstamp, $arrItem);
				}

				if(($mod++ % 2) == 0)
				{
					$arrItem['css'] .= 'even';
				}
				else
				{
					$arrItem['css'] .= 'odd';
				}

				$arrItem['headline']  = deserialize($arrItem['headline']);
				$arrItem['parseDate'] = '<time datetime="' . date('Y-m-d\TH:i:sP', $arrItem['tstamp']) . '">' . \Date::parse($GLOBALS['objPage']->datimFormat, $arrItem['tstamp']) . '</time>';
				$arrContent[] = (object) $arrItem;
			}
		}

		$objFAQ = $this->Database->prepare("SELECT * FROM tl_faq WHERE tstamp > ? && published = ? ORDER BY tstamp DESC")->execute($this->Member->lastLogin, '1');
		while($objFAQ->next())
		{
			$arrItem = $objFAQ->row();

			foreach($GLOBALS['TL_HOOKS']['contentLog'] as $callback)
			{
				$this->import($callback[0]);
				$arrItem = $this->$callback[0]->$callback[1]('tl_faq', $objFAQ->tstamp, $arrItem);
			}

			if(($mod++ % 2) == 0)
			{
				$arrItem['css'] .= 'even';
			}
			else
			{
				$arrItem['css'] .= 'odd';
			}


			$arrItem['parseDate'] = '<time datetime="' . date('Y-m-d\TH:i:sP', $arrItem['tstamp']) . '">' . \Date::parse($GLOBALS['objPage']->datimFormat, $arrItem['tstamp']) . '</time>';
			$arrContent[] = (object) $arrItem;
		}

		$arrContent[0]->css .= ' first';
		$arrContent[count($arrContent) - 1]->css .= ' last';

		foreach($arrContent as $v)
		{
			$objTemplate = new \FrontendTemplate($this->contentLogTpl);
			$objTemplate->setData((array) $v);
			$html .= $objTemplate->parse();
		}

		if($this->contentLogTpl == 'cl_list')
		{
			$html = '<table>' . $html . '</table>';
		}

		$this->Template->html = $html;
	}	
}