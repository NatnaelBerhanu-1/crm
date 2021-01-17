<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\StaffTask;
use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Traits\Date;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->query('filterBy') == 'date') {
                if ($request->query('type') == 'print') {
                    $tasks = Task::whereDate('delivery_date', $request->query('date'))->get();
                } else {
                    $tasks = Task::whereDate('shot_date', $request->query('date'))->get();
                    // echo($tasks);
                }
            } else if ($request->query('groupBy') == 'date') {
                $shotTasks = Task::select(DB::raw('DATE(shot_date) as date'), DB::raw('count(*) as title'), DB::raw('\'shot\' as type'))->groupBy('shot_date');
                $printTasks = Task::select(DB::raw('DATE(delivery_date) as date'), DB::raw('count(*) as title'), DB::raw('\'print\' as type'))->groupBy('delivery_date')->union($shotTasks)->get();
                return $this->sendResponse(200, $printTasks, 'Resource fetched successfully');
            } else if ($request->query('search') != null) {
                $condition = "%{$request->query('search')}%";
                $tasks = Task::where('phone_number', 'like', $condition)->orWhere('name', 'like', $condition)->paginate(10);
            } else {
                $tasks = Task::with('staffs')->paginate(10);
                $tasks->withPath('');
            }
            return $this->sendResponse(200, $tasks, 'Resource fetched successfully');
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, 'Something went wrong');
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
                'name' => 'required',
                'phone_number' => 'required',
                'type' => 'required',
                'location' => 'required',
                'type' => 'required',
                'package' => 'required',
                'description' => 'required',
                'quantity' => 'required',
                'total_price' => 'required',
                'paid_amount' => 'required',
                'shot_date' => 'required',
                'delivery_date' => 'required',
                'status' => 'required',
                'user_id' => 'required',
                'service' => 'required',
                'data_location' => 'required',
                'selection_date' => 'required',
                'staffs' => 'required',
            ]);

            if ($validated) {
                $name = $request->input('name');
                $phone_number = $request->input('phone_number');
                $location = $request->input('location');
                $type = $request->input('type');
                $package = $request->input('package');
                $description = $request->input('description');
                $quantity = $request->input('quantity');
                $total_price = $request->input('total_price');
                $paid_amount = $request->input('paid_amount');
                $shot_date = $request->input('shot_date');
                $delivery_date = $request->input('delivery_date');
                $user_id = $request->input('user_id');
                $type = $request->input('type');
                $status = $request->input('status');
                $service = $request->input('service');
                $data_location = $request->input('data_location');
                $selection_date = $request->input('selection_date');
                $staffs = $request->staffs;

                if ($request->input('remark') != null) {
                    $remark = $request->input('remark');
                } else {
                    $remark = "";
                }
                $task = Task::create([
                    'name' => $name,
                    'phone_number' => $phone_number,
                    'type' => $type,
                    'location' => $location,
                    'total_price' => $total_price,
                    'paid_amount' => $paid_amount,
                    'shot_date' => $shot_date,
                    'delivery_date' => $delivery_date,
                    'user_id' => $user_id,
                    'package' => $package,
                    'description' => $description,
                    'quantity' => $quantity,
                    'status' => $status,
                    'remark' => $remark,
                    'data_location' => $data_location,
                    'selection_date' => $selection_date,
                    'service' => json_encode($service)
                ]);

                $task->staffs()->attach($staffs);

                return $this->sendResponse(201, $task, 'Resource created successfully');
            } else {
                return $this->sendResponse(400, '', 'Phone number already taken');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, 'Something went wrong');
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
            $task = Task::where('id', $id)->with('staffs')->first();
            if (isset($task)) {
                return $this->sendResponse(200, $task, 'Resource fetched successfully');
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        } catch (Exception $e) {
            return $this->sendResponse(500, null, 'Something went wrong');
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
            $task = Task::where('id', $id)->with('staffs')->first();
            if (isset($task)) {
                $validated = $request->validate([
                    'name' => 'required',
                    'phone_number' => 'required',
                    'type' => 'required',
                    'location' => 'required',
                    'type' => 'required',
                    'package' => 'required',
                    'description' => 'required',
                    'quantity' => 'required',
                    'total_price' => 'required',
                    'paid_amount' => 'required',
                    'shot_date' => 'required',
                    'delivery_date' => 'required',
                    'status' => 'required',
                    'user_id' => 'required',
                    'service' => 'required',
                    'data_location' => 'required',
                    'selection_date' => 'required',
                    'staffs' => 'required',
                ]);
                if ($validated) {
                    if ($request->input('remark') != null) {
                        $remark = $request->input('remark');
                    } else {
                        $remark = "";
                    }
                    $name = $request->input('name');
                    $phone_number = $request->input('phone_number');
                    $location = $request->input('location');
                    $type = $request->input('type');
                    $package = $request->input('package');
                    $description = $request->input('description');
                    $quantity = $request->input('quantity');
                    $total_price = $request->input('total_price');
                    $paid_amount = $request->input('paid_amount');
                    $shot_date = $request->input('shot_date');
                    $delivery_date = $request->input('delivery_date');
                    $type = $request->input('type');
                    $status = $request->input('status');
                    $remark = $request->input('remark');
                    $data_location = $request->input('data_location');
                    $selection_date = $request->input('selection_date');
                    $service = $request->input('service');
                    $staffs = $request->staffs;


                    $task->name = $name;
                    $task->phone_number = $phone_number;
                    $task->location = $location;
                    $task->total_price = $total_price;
                    $task->paid_amount = $paid_amount;
                    $task->shot_date = $shot_date;
                    $task->delivery_date = $delivery_date;
                    $task->type = $type;
                    $task->package = $package;
                    $task->description = $description;
                    $task->quantity = $quantity;
                    $task->status = $status;
                    $task->remark = $remark;
                    $task->data_location = $data_location;
                    $task->selection_date = $selection_date;
                    $task->service = json_encode($service);
                    $task->save();

                    $task->staffs()->detach();
                    $task->staffs()->attach($staffs);

                    return $this->sendResponse(200, $task, 'Resource updated successfully');
                } else {
                    return $this->sendResponse(400, '', 'Validation Failed');
                }
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, 'Something went wrong');
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
            $task = Task::where('id', $id)->first();
            if (isset($task)) {
                $task->delete();
                return $this->sendResponse(204, null, 'Resource deleted succussfully');
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        } catch (Exception $e) {
            return $this->sendResponse(500, null, 'Something went wrong');
        }
    }

    public function getInitDate()
    {
        try {
            $year =  date('Y');
            $today = date('Y-m-d H:i:s');
            $monthlyTasks = Task::select(DB::raw('count(id) as data, date_part(\'month\', created_at) as month, date_part(\'year\', created_at) as year'))->whereYear('created_at',  $year)->groupBy('month', 'year')->get();
            $monthlyEarning = Report::select(DB::raw('sum(income_amount) as data, date_part(\'month\', date) as month, date_part(\'year\', date) as year'))->whereYear('date',  $year)->groupBy('month', 'year')->get();
            $completedTasks = Task::where('delivery_date', '<', $today)->count();
            $ongoingTasks = Task::where('delivery_date', '>=', $today)->count();
            $upcomingTasks = Task::where('delivery_date', '>=', $today)->limit(5)->get();
            $data = ['monthlyTasks' => $monthlyTasks, 'monthlyEarning' => $monthlyEarning, 'completedTasks' => $completedTasks, 'ongoingTasks' => $ongoingTasks, 'upcomingTasks' => $upcomingTasks];
            return $this->sendResponse(200, $data, "Resource feteched successfully");
        } catch (Exception $e) {
            echo ($e);
            $this->sendResponse(500, null, "Something went wrong");
        }
    }
}
