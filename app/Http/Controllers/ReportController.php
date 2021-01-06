<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Exception;
use Illuminate\Http\Request;

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
            if ($request->query('from') != null && $request->query('to') != null) {
                $from = $request->query('from');
                $to = $request->query('to');
                $reports = Report::whereBetween('date', [strval($from), strval($to)])->get();
                return $this->sendResponse(200, $reports, "Resource fetched successfully");
            }
            $reports = Report::paginate();
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
        //
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
        //
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
