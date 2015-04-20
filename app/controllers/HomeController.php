<?php 

class HomeController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Session::forget('carrier_name');
		Session::forget('carrier');
		$languages = Language::all();

		$user_location = GeoIP::getLocation();

		$country = Country::where('name', $user_location['country'])->get();
		$country_id = '';

		foreach($country as $key) {
			$country_id = $key->id;
		}

		$carriers = Country::with('carriers')->where('country_code', '=', $country_id)->get();

		$selected_carriers = [];

		foreach($carriers as $c) {
			foreach($c->carriers as $i) {
				$selected_carriers[] = $i;
			}
		}

		if(!$selected_carriers) 
		{	

			$carriers_all = Carrier::all();
			foreach($carriers_all as $carrier)
			{
				$selected_carriers[] = $carrier;
			}

		}


		$carrier_all = [];

		foreach(Carrier::all() as $crr) {
			$carrier_all[$crr->id] = $crr->carrier;
		}

		return View::make('carrier')
			->with('page_title', 'Select carrier')
			->with('selected_carriers', $selected_carriers)
			->with('country_id', $country_id)
			->with('page_id', 'form')
			->with('page_class', 'select_carrier')
			->with(compact('languages'))
			->with('carrier_all', $carrier_all);
	}

	public function home()
	{	
		$latest_news = News::whereStatus('live')->orderby('created_at', 'desc')->take(2)->get();
		$previous_news = News::whereStatus('live')->orderby('created_at', 'desc')->take(3)->skip(2)->get();
		$faqs = Faq::all();
		$year = News::all();

		/* TODO: check if session has carrier */
		if (!Session::has('carrier')) {
			
			Session::put('country_id', Input::get('country_id'));
			Session::put('carrier', Input::get('selected_carrier'));
			$country = Country::find(Input::get('country_id'));
			$first_visit = true;
					
		} else {			
			
			$country = Country::find(Session::get('country_id'));
			$first_visit = false;
		}

		if(!Session::has('country_id')) {
			$user_location = GeoIP::getLocation();
			$country = Country::where('name', $user_location['country'])->first();
			$country_id = $country->id;
		}

		$carrier = Carrier::find(Session::get('carrier'));

		$countries = [];

		if(!Session::has('locale')) {
			Session::put('locale', strtolower($carrier->language->iso_code));
		}

		$locale = Language::where('iso_code', '=', strtoupper(Session::get('locale')))->first();

		// print_r(Session::all());

		/* For displaying game discount alert */

		$dt = Carbon::now();

		$discounts = Discount::whereActive(1)
			->where('start_date', '<=', $dt->toDateString())
			->where('end_date', '>=',  $dt->toDateString())		
			->get();

		/* END */
		$ctr = 0;
		/* For getting discounts */
		$discounted_games = [];
		foreach ($discounts as $data) {
			foreach($data->games as $game ) {
				$discounted_games[$data->id][] = $game->id; 
			}
		}

		/*foreach ($discounts as $data) {
			
			dd($data);
		}*/

	/* For displaying news alert */	

		$news_alert = News::whereNewsCategoryId(2)
			->whereStatus('live')
			->get();


	/* END */

	/* For displaying year dynamically in select form */

		$arr_yrs = [];	
		
		foreach ($year as $yrs) {
			$year = date('Y', strtotime($yrs->created_at)); 
			$arr_yrs[$year] = $year;
			$year = array_unique($arr_yrs);
		}
		
	/* END */

		$languages = [];

		$user_location = GeoIP::getLocation();

		$categories = [];

		$game_settings = GameSetting::all();

		$featured_games = Game::where('featured', 1)
			/*->whereCarrierId(Session::get('carrier'))*/
			->orderBy('created_at', 'DESC')			
			->get();

		// $games = Game::all()->take($game_settings[0]->game_thumbnails);

		/* Get all games by carrier id */

		//$games = Game::whereCarrierId(Session::get('carrier'))->get();
		//$games = Game::all();		

		/* End */
		$limit = $game_settings[0]->game_thumbnails;

		foreach(Category::orderby('order')->get() as $cat) {
			if ($cat->featured == 1) {
				$categories[] = $cat;
			}
		}

		$languages = Language::all();

		// foreach(Language::all() as $language) {
		// 	$languages[$language->id] = $language->language;
		// }

		/*BaseController::test(Input::get('country_id'));*/
		
		
		
		Session::put('carrier_name', $carrier->carrier);		

		Session::put('user_country', $country->full_name);


		/* For displaying slider images dynamically ordered from database */

		$games_slide = [];
		$news_slide = [];

		$sliders = Slider::all();

		foreach($sliders as $slider) {
			if($slider->slideable_type == 'Game') $selected_games[] = $slider->slideable_id;
			else if($slider->slideable_type == 'News') $selected_news[] = $slider->slideable_id;
		}		
		
		foreach(Game::all() as $game) {	

			foreach($game->apps as $app) {

				$iso_code = ''; 

				foreach($languages as $language){

					if($language->id == $app->pivot->language_id){
						$iso_code = strtolower($language->iso_code);
					}
				}						
				
				foreach ($game->media as $media) {
					
					if($media->type == 'homepage') {

						if($iso_code == Session::get('locale') && $app->pivot->carrier_id == Session::get('carrier')) {						
							
							$games_slide[$game->id] = array(
								'url' => $media->url, 
								'title' => $game->main_title, 
								'id' => $game->id,
								'slug' => $app->pivot->app_id);
						}
					}
				}
			}
		}
		
		$cid = Session::get('carrier');		
	
		$games = Game::whereHas('apps', function($q) use ($cid)
		  {
		      $q->where('carrier_id', '=', $cid);

		  })->get();
		

		foreach(News::all() as $nw) {
			//$news_slide[$nw->id] = $nw->homepage_image;

			//$news_slide[$nw->id] = $nw->featured_image;
			$news_slide[$nw->id] = array(
				'image' => $nw->homepage_image,
				'id' => $nw->id,
				'title' => $nw->main_title
			);

		}

		//$cat = Category::find(2)->games;
		//echo "<pre>";
		//dd($cat->toArray());
		//foreach($categories as $cat ) 
		//{
			foreach($cat->games() as $apps) 
			{
				//foreach($apps->media as $media) 
				//{
					echo "<pre>";
					//dd($apps->media->toArray());
					echo "</pre>";	
				//}
			}
			
		//}

		/* END */

		return View::make('index')
			->with('page_title', 'Home')
			->with('page_id', 'home')
			->with('previous_news', $previous_news)
			->with('latest_news', $latest_news)
			->with('year', $year)
			->with('news_alert', $news_alert)
			->with('first_visit', $first_visit)
			->with('carrier', $carrier)
			->with('country', $country)
			->with('categories', $categories)
			->with('discounts', $discounts)
			->with('limit', $limit)
			/*->with(compact('featured_games'))*/
			->with(compact('games','featured_games', 'faqs', 'languages', 'discounted_games', 'games_slide','news_slide','sliders'));
			/*->with(compact('faqs'))
			->with(compact('languages'));*/
	
	}

}
