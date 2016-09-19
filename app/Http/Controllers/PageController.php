<?php
class PageController extends BaseController {

    public function show($url = 'welcome', $section = NULL)
    {
        $page = Page::where('url', $url)->first();

        if (!$page || !$page->is_published() || $url == 'footer') {
            App::abort(404);
        }

        $this->data['page'] = $page;

        if($url == 'welcome' || $url == '/') {
            $this->data['challenge'] = Challenge::where('published_end', '>', date("Y-m-d H:i:s"))->orderBy('published_end', 'desc')->first();
            $this->data['schools'] = School::orderBy('id')->get();;
            $this->data['totals'] = Total::get();

            if ($this->data['challenge']) {
                $challenge = $this->data['challenge'];
                $this->data['start'] = $challenge->start;
                $this->data['end'] = $challenge->end;
                $this->data['countdown'] = max(0, 2000000 - Total::all()->where('challenge_id', '=', $challenge->id)
                                                                        ->reduce(function($rolling, $val) {
                    return $rolling + $val->minutes;
                }));
            } else {
                $this->data['start'] = null;
                $this->data['end'] = null;
            }

            // if ($this->mobile) {
                // return View::make('pages/welcome-mobile', $this->data);
            // } else {
                return View::make('pages.welcome', $this->data);
            // }
        }
        if($url == 'sponsors') {
            return View::make('pages.sponsors', $this->data);
        }
        if($url == 'past-challenges') {
            $this->data['challenges'] = Challenge::where('published_end', '<', date("Y-m-d H:i:s"))->get();
            return View::make('pages.past-challenges', $this->data);
        }

        return View::make('page', $this->data);
    }

}
