<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->query('forGraph') != null) {
                $filterBy = $request->query('filterBy');
                if ($filterBy == "overall") {
                    $income = Report::select(DB::raw('sum(income_amount) as data'), 'date as label')->groupBy('date')->orderBy('label')->get();
                    $expense = Report::select(DB::raw('sum(expense_amount) as data'), 'date as label')->groupBy('date')->orderBy('label')->get();
                    $reports = ['expense' => $expense, 'income' => $income];
                    return $this->sendResponse(200, $reports, 'Resource fetched successfully');
                } else if ($filterBy == "thisyear") {
                    $income = Report::select(DB::raw('sum(income_amount) as data'), 'date as label')->groupBy('date')->whereYear('date', date('Y'))->orderBy('label')->get();
                    $expense = Report::select(DB::raw('sum(expense_amount) as data'), 'date as label')->groupBy('date')->whereYear('date', date('Y'))->orderBy('label')->get();
                    $reports = ['expense' => $expense, 'income' => $income];

                    return $this->sendResponse(200, $reports, 'Resource fetched successfully');
                } else if ($filterBy == "last6months") {
                    $income = DB::table('reports')->select(DB::raw('sum(income_amount) as data, date as label'))->groupBy('date')->whereRaw('current_date - date < 180')->orderBy('label')->get();
                    $expense = DB::table('reports')->select(DB::raw('sum(expense_amount) as data, date as label'))->groupBy('date')->whereRaw('current_date - date < 180')->orderBy('label')->get();
                    $reports = ['expense' => $expense, 'income' => $income];

                    return $this->sendResponse(200, $reports, 'Resource fetched successfully');
                } else if ($filterBy == "thismonth") {
                    $income = Report::select(DB::raw('sum(income_amount) as data'), 'date as label')->groupBy('date')->whereYear('date', date('Y'))->wheremonth('date', date('m'))->orderBy('label')->get();
                    $expense = Report::select(DB::raw('sum(expense_amount) as data'), 'date as label')->groupBy('date')->whereYear('date', date('Y'))->wheremonth('date', date('m'))->orderBy('label')->get();
                    $reports = ['expense' => $expense, 'income' => $income];

                    return $this->sendResponse(200, $reports, 'Resource fetched successfully');
                } else if ($filterBy == "lastmonth") {
                    $income = Report::select(DB::raw('sum(income_amount) as data'), 'date as label')->groupBy('date')->wheremonth('date', '=', Carbon::now()->subMonth()->month)->orderBy('label')->get();
                    $expense = Report::select(DB::raw('sum(expense_amount) as data'), 'date as label')->groupBy('date')->wheremonth('date', '=', Carbon::now()->subMonth()->month)->orderBy('label')->get();
                    $reports = ['expense' => $expense, 'income' => $income];

                    return $this->sendResponse(200, $reports, 'Resource fetched successfully');
                }
                return;
            }
            if ($request->query('from') != null && $request->query('to') != null) {
                $from = $request->query('from');
                $to = $request->query('to');
                $reports = Report::whereBetween('date', [strval($from), strval($to)])->get();
                return $this->sendResponse(200, $reports, "Resource fetched successfully");
            }
            if ($request->query('daily') != null){
                $daily_income = Report::select(DB::raw('sum(income_amount) as data'), 'date as label')->groupBy('date')->whereDate('date', '=', $request->query('daily'))->orderBy('label')->get();
                $daily_expense = Report::select(DB::raw('sum(expense_amount) as data'), 'date as label')->groupBy('date')->whereDate('date', '=', $request->query('daily'))->orderBy('label')->get();
                $data = ['daily_income'=>$daily_income, 'daily_expense'=>$daily_expense];
                return $this->sendResponse(200, $data, "Resource fetched successfully");
            }
            $reports = Report::paginate(10);
            return $this->sendResponse(200, $reports, "Resource fetched successfully");
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, "Something went wrong");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required'
            ]);
            if ($validated) {
                $income_amount = $request->input('income_amount');
                $expense_amount = $request->input('expense_amount');

                $report = Report::create([
                    'income_amount' => $income_amount != null ? $income_amount : 0,
                    'income_description' => $request->input('income_description'),
                    'expense_amount' => $expense_amount != null ? $expense_amount : 0,
                    'expense_description' => $request->input('expense_description'),
                    'date' => $request->input('date')
                ]);

                return $this->sendResponse(201, $report, "Resource created successfully");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, "Something went wrong");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $report = Report::where('id', $id)->first();
            if (isset($report)) {
                return $this->sendResponse(200, $report, "Resource fetched successfully");
            } else {
                return $this->sendResponse(400, null, "Resource not found");
            }
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, "Something went wrong");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $report = Report::where('id', $id)->first();

            if (isset($report)) {
                $validated = $request->validate([
                    'date' => 'required'
                ]);
                if ($validated) {
                    $report->income_amount = $request->income_amount;
                    $report->income_description = $request->income_description;
                    $report->expense_amount = $request->expense_amount;
                    $report->expense_description = $request->expense_description;
                    $report->date = $request->date;
                    $report->save();
                    return $this->sendResponse(200, $report, "Resource updated successfully");
                }
            } else {
                return $this->sendResponse(400, null, "Resource not found");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, "Something went wrong");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $report = Report::where('id', $id)->first();
            if (isset($report)) {
                $report->delete();
                return $this->sendResponse(204, null, "Resource deleted successfully");
            } else {
                return $this->sendResponse(404, null, "Not Found");
            }
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, "Something went wrong");
        }
    }
}
