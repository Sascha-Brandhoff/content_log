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
				$objNews    = \NewsModel::findById($item['pid']);
				$objArchive = \NewsArchiveModel::findById($objNews->pid);
				$objPage    = \PageModel::findById($objArchive->jumpTo);

				$item['page'] = $objNews->headline;
				$item['showUrl']  = ampersand($this->generateFrontendUrl($objPage->row(), ((\Config::get('useAutoItem') && !\Config::get('disableAlias')) ?  '/' : '/items/') . ((!\Config::get('disableAlias') && $objNews->alias != '') ? $objNews->alias : $objNews->id)));
				break;
			case 'tl_calendar':

				break;
			case 'tl_faq':
				$objFAQ      = \FaqModel::findById($item['id']);
				$objCategory = \FaqCategoryModel::findById($item['pid']);
				$objPage     = \PageModel::findById($objCategory->jumpTo);

				$item['htmlElement'] = '<div class="ce_faq"><h1>' . $objFAQ->question . '</h1>' . $objFAQ->answer . '</div>';
				$item['page'] = $objCategory->title;
				$item['title'] = $objFAQ->question;
				$item['showUrl']  = ampersand($this->generateFrontendUrl($objPage->row(), ((\Config::get('useAutoItem') && !\Config::get('disableAlias')) ?  '/' : '/items/') . ((!\Config::get('disableAlias') && $objFAQ->alias != '') ? $objFAQ->alias : $objFAQ->id)));
				break;
		}

		return $item;
	}
}