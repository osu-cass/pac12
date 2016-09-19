<?php

class AdminReportController extends AdminBaseController {

    public function main($start = null, $end = null)
    {
        $school = School::where('id', Auth::user()->school_id)->first();

        if ($start == null) {
            $current = Challenge::orderBy('published_start', 'desc')->first();
            $start = strtotime($current->published_start);
            $end = strtotime($current->published_end);
            $now = time();
            $this->data['heading'] = 'Challenge to Date: ' . $school->name;
        } else {
            $start = strtotime($start);
            $end = strtotime($end);
            $now = $end;
            $this->data['heading'] = date('m-d', $start) . ' - ' . date('m-d', $end) . ' : '. $school->name;
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
                        ->where('times.school_id', '=', $school->id)
                        ->first();
            $total->date = $date;
            $totals[] = $total;
            $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
        }

        $this->data['start'] = date('Y-m-d', $start);
        $this->data['now'] = $now;
        $this->data['end'] = date('Y-m-d', $end);
        $this->data['dates'] = $dates;
        $this->data['school'] = $school->name;

        $this->data['totals'] = $totals;

        $this->data['reportType'] = 'Challenge to Date';

        return View::make('admin.reports.reports', $this->data);
    }

    public function daily($date)
    {
        $school = School::where('id', Auth::user()->school_id)->first();
        $times = Time::where('date', $date)->where('school_id', Auth::user()->school_id)->get();

        if (!$times || count($times) <= 0) {
            return Redirect::to('admin/reports')->withErrors('No times found for that day');
        }

        $school = str_replace(' ', '-', $school->name);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$school.'-'.$date.'.csv');


        $f = fopen('php://output', 'w');

        fputcsv($f, array('Minutes', 'Type', 'Id', 'Email'), ',');

        foreach ($times as $time) {
            fputcsv($f, array($time->minutes , $time->type, $time->user_id, $time->user->email), ",");
        }

        fclose($f);
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
