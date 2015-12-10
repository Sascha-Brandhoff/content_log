<?php

namespace Contao;

class ClassContentLog extends \Controller
{
	public function checkLog($ptable, $tstamp, $item)
	{
		switch($ptable)
		{
			case 'tl_article':
				$objArticle = \ArticleModel::findById($item['pid']);
				$objPage    = \PageModel::findById($objArticle->pid);

				$item['page'] = $objPage->title;
				$item['showUrl']  = $this->generateFrontendUrl($objPage->row(), '');
				break;
			case 'tl_news':
				$objNews = \NewsModel::findById($item['pid']);
				$objArchive = \NewsArchiveModel::findById($objNews->pid);
				$objPage    = \PageModel::findById($objArchive->jumpTo);

				$item['page'] = $objNews->headline;
				$item['showUrl']  = ampersand($this->generateFrontendUrl($objPage->row(), ((\Config::get('useAutoItem') && !\Config::get('disableAlias')) ?  '/' : '/items/') . ((!\Config::get('disableAlias') && $objNews->alias != '') ? $objNews->alias : $objNews->id)));
				break;
			case 'tl_calendar':

				break;
		}

		return $item;
	}
}