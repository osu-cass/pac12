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
            $currentDate = date('Y-m-d');
            $this->data['challenge'] = Challenge::where('published_start', '<=', $currentDate)
                ->where('published_end', '>=', $currentDate)
                ->first();
            $this->data['schools'] = School::orderBy('id')->get();;
            $this->data['totals'] = Total::get();

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
