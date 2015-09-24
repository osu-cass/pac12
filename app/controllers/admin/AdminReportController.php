<?php

class AdminReportController extends AdminBaseController {

	public function main($start = null, $end = null)
	{
		$school = Auth::user()->school;

		if ($start == null) {
			$current = Challenge::orderBy('published_start', 'desc')->first();
			$start = strtotime($current->published_start);
			$end = strtotime($current->published_end);
			$now = time();
			$this->data['heading'] = 'Challenge to Date: ' . $school;
		} else {
			$start = strtotime($start);
			$end = strtotime($end);
			$now = $end;
			$this->data['heading'] = date('m-d', $start) . ' - ' . date('m-d', $end) . ' : '. $school;
		}

		$dates = array();
		$totals = array();

		$date = date('Y-m-d', $start);


		while ( $date <= date('Y-m-d', $end ) && $date <= date('Y-m-d', $now ) ) {
			$dates[] = $date;

			$total = DB::table('times')
						->select(DB::raw('sum(minutes) as minutes, count(distinct user_id) as students'))
						->where('date', '=', $date)
						->join('users', 'users.id', '=', 'times.user_id')
						->where('times.school', '=', $school)
						->first();
			$total->date = $date;
			$totals[] = $total;
			$date = date('Y-m-d', strtotime("+1 day", strtotime($date)));

		}

		$this->data['start'] = date('Y-m-d', $start);
		$this->data['now'] = $now;
		$this->data['end'] = date('Y-m-d', $end);
		$this->data['dates'] = $dates;
		$this->data['school'] = $school;

		$this->data['totals'] = $totals;//Total::get();

		$this->data['reportType'] = 'Challenge to Date';

		return View::make('admin.reports.reports', $this->data);
	}

	public function daily($date)
	{
		$school = Auth::user()->school;
		//$time = Time::where('date', '=', $date);
//		$times = DB::table('times')
//					->where('date', '=', $date)
//					->join('users', 'users.id', '=', 'times.user_id')
//					->where('times.school', '=', Auth::user()->school)
//					->select('minutes, type, user.name, user.id, user.name')
//					->get();

		$times = Time::where('date', $date)->where('school', Auth::user()->school)->get();

		if (!$times || count($times) <= 0) {
			return Redirect::to('admin/reports')->withErrors('No times found for that day');
		}

		$school = str_replace(' ', '-', $school);

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$school.'-'.$date.'.csv');

		$f = fopen('php://output', 'w');

		fputcsv($f, array('Minutes', 'Type', 'Id', 'Email'), ',');
		foreach ($times as $time) {
			$row = array();
			$row['time']     = $time->minutes;
			$row['activity'] = $time->activity();
			$row['id']       = $time->user_id;
			$row['name']     = $time->user->email;

			fputcsv($f, $row, ',');
		}
	}

	public function range()
	{
		if (!Input::has('end')) {
			return Redirect::to('admin/reports')->withErrors('Please enter start and end dates.');
		}
		$start = Input::get('start');
		$end = Input::get('end');

		if ($start > $end) {
			$temp = $end;
			$end = $start;
			$start = $temp;
		}

		return $this->main($start, $end);
	}
}
?>
