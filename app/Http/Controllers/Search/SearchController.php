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

namespace App\Http\Controllers\Search;

use App\Helpers\Search\PostQueries;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SearchController extends BaseController
{
	public $isIndexSearch = true;
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		// dd(config('country'));
		if(request('country_search')){
			// $country = \App\Models\Country::where('country_code', request('country_search'))->first();
			// dd($country);
			config(['country.code' => request('country_search')]);
			
		}

		view()->share('isIndexSearch', $this->isIndexSearch);
		// dd($this->preSearch);
		// Search
		$data = (new PostQueries($this->preSearch))->fetch();
		
		

		// Get Titles
		$title = $this->getTitle();
		$this->getBreadcrumb();
		$this->getHtmlTitle();
		
		// Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);
		
		return appView('search.results', $data);
	}
}
