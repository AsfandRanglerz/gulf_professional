<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Helpers\Search\Traits\Relations;

trait CategoryRelation
{
	protected function setCategoryRelation($locale = null)
	{
		if (!(isset($this->posts))) {
			dd('Fatal Error: Category relation cannot be applied.');
		}
		
		// category
		$this->posts->with(['category' => function ($query) {
			$query->with('parent');
		}]);
		
		if (!request()->filled('q')) {
			
			$this->posts->has('category');
			
		} else {
			
			if (empty($locale)) {
				$locale = config('lang.abbr');
			}
			
			$this->posts->join('categories as tCategory', function ($join) {
				$join->on('tCategory.id', '=', 'posts.category_id')
					->where('tCategory.active', 1);
			});
			$this->posts->leftJoin('categories as tParentCat', function ($join) {
				$join->on('tParentCat.id', '=', 'tCategory.parent_id')
					->where('tParentCat.active', 1);
			});
			
			$this->posts->leftJoin('categories as lCategory', function ($join) use ($locale) {
				$join->on('lCategory.translation_of', '=', 'tCategory.id')
					->where('lCategory.translation_lang', $locale);
			});
			$this->posts->leftJoin('categories as lParentCat', function ($join) use ($locale) {
				$join->on('lParentCat.translation_of', '=', 'tParentCat.id')
					->where('lParentCat.translation_lang', $locale);
			});
			
		}
	}
}
