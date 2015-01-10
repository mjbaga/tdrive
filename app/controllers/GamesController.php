<?php

class GamesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /games
	 *
	 * @return Response
	 */
	public function index()
	{
		$games = Game::with('media')->get();
		$root = Request::root();
		$thumbnails = array();

		foreach($games as $game) {
			foreach($game->media as $media) {
				if($media->pivot->type == 'featured') {
					$thumbnails[] = $root. '/images/uploads/' . $media->url;
				}
			}
		}
		return View::make('pages.games')
			->with('thumbnails', $thumbnails)
			->with('games', $games);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /games/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /games
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /games/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$languages = Language::all();
		$game = Game::find($id);
		$current_game = Game::find($id);
		$categories = [];
		foreach($game->categories as $cat) {
			$categories[] = $cat->id;
		}

		$reviews = [];

		foreach($game->review as $review) {
			$reviews[] = $review;
		}

		$games = Game::all();
		$related_games = [];
		foreach($games as $gm) {
			$included = false;
			foreach($gm->categories as $rgm) {
				if(in_array($rgm->id, $categories) && $gm->id != $game->id) {
					if(!$included) {
						$related_games[] = $gm;
						$included = true;
					}
				}
			}
		}
		$ratings = Review::getRatings($game->id);
		$visitor = Tracker::currentSession();
		$country = Country::find(Session::get('country_id'));
		return View::make('game')
			->with('page_title', $game->main_title)
			->with('page_id', 'game-detail')
			->with('reviews', $reviews)
			->with('ratings', $ratings)
			->with('current_game', $current_game)
			->with('country', $country)
			->with(compact('languages'))
			->with(compact('related_games'))
			->with(compact('game'));
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /games/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /games/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /games/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function loadGames() {
		$games = Game::with('media')->get();

		return $games->toJson();
	}
}
