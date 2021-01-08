<?php

namespace App\Http\Controllers;

use App\Models\Report;
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
            if($request->query('filterBy')=='date'){
                if($request->query('type')=='print'){
                    $tasks = Task::whereDate('print_date',$request->query('date'))->get();
                }else{
                    $tasks = Task::whereDate('shot_date',$request->query('date'))->get();
                }
            }
            else if($request->query('groupBy')=='date'){
                $shotTasks = Task::select(DB::raw('DATE(shot_date) as date'), DB::raw('count(*) as title'), DB::raw('\'shot\' as type'))->groupBy('shot_date');
                $printTasks = Task::select(DB::raw('DATE(print_date) as date'), DB::raw('count(*) as title'), DB::raw('\'print\' as type'))->groupBy('print_date')->union($shotTasks)->get();
                return $this->sendResponse(200, $printTasks, 'Resource fetched successfully');
            }
            else if($request->query('search')!=null){
                $condition = "%{$request->query('search')}%";
                $tasks = Task::where('phone_number', 'like', $condition)->orWhere('name', 'like', $condition)->paginate(10);
            }
            else{
                $tasks = Task::paginate(10);
                $tasks->withPath('');
            }
            return $this->sendResponse(200, $tasks, 'Resource fetched successfully');
        } catch (Exception $e) {
            echo($e);
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
                'size' => 'required',
                'quantity' => 'required',
                'total_price' => 'required',
                'paid_amount' => 'required',
                'shot_date' => 'required',
                'print_date' => 'required',
                'status' => 'required',
                'user_id' => 'required'
            ]);

            if ($validated) {
                $name = $request->input('name');
                $phone_number = $request->input('phone_number');
                $location = $request->input('location');
                $type = $request->input('type');
                $package = $request->input('package');
                $size = $request->input('size');
                $quantity = $request->input('quantity');
                $total_price = $request->input('total_price');
                $paid_amount = $request->input('paid_amount');
                $shot_date = $request->input('shot_date');
                $print_date = $request->input('print_date');
                $user_id = $request->input('user_id');
                $type = $request->input('type');
                $status = $request->input('status');

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
                    'print_date' => $print_date,
                    'user_id' => $user_id,
                    'package' => $package,
                    'size' => $size,
                    'quantity' => $quantity,
                    'status' => $status,
                    'remark' => $remark
                ]);

                return $this->sendResponse(201, $task, 'Resource created successfully');
            } else {
                return $this->sendResponse(400, '', 'Phone number already taken');
            }
        }catch(\Illuminate\Validation\ValidationException $e){
            echo($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        }
        catch (Exception $e) {
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
            $task = Task::where('id', $id)->first();
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
            $task = Task::where('id', $id)->first();
            if (isset($task)) {
                $validated = $request->validate([
                    'name' => 'required',
                    'phone_number' => 'required',
                    'type' => 'required',
                    'location' => 'required',
                    'type' => 'required',
                    'package' => 'required',
                    'size' => 'required',
                    'quantity' => 'required',
                    'total_price' => 'required',
                    'paid_amount' => 'required',
                    'shot_date' => 'required',
                    'print_date' => 'required',
                    'status' => 'required',
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
                    $size = $request->input('size');
                    $quantity = $request->input('quantity');
                    $total_price = $request->input('total_price');
                    $paid_amount = $request->input('paid_amount');
                    $shot_date = $request->input('shot_date');
                    $print_date = $request->input('print_date');
                    $type = $request->input('type');
                    $status = $request->input('status');
                    $remark = $request->input('remark');
                    //Todo: check the syntax for all files
                    $task->name = $name;
                    $task->phone_number = $phone_number;
                    $task->location = $location;
                    $task->total_price = $total_price;
                    $task->paid_amount = $paid_amount;
                    $task->shot_date = $shot_date;
                    $task->print_date = $print_date;
                    $task->type = $type;
                    $task->package = $package;
                    $task->size = $size;
                    $task->quantity = $quantity;
                    $task->status = $status;
                    $task->remark = $remark;

                    $task->save();
                    return $this->sendResponse(200, $task, 'Resource updated successfully');
                } else {
                    return $this->sendResponse(400, '', 'Validation Failed');
                }
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        }catch(\Illuminate\Validation\ValidationException $e){
            echo($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        }catch (Exception $e) {
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

    public function getInitDate(){
        try{
            $year =  date('Y');
            $today = date('Y-m-d H:i:s');
            $monthlyTasks = Task::select(DB::raw('count(id) as data, date_part(\'month\', created_at) as month, date_part(\'year\', created_at) as year'))->whereYear('created_at',  $year)->groupBy('month', 'year')->get();
            $monthlyEarning = Report::select(DB::raw('sum(income_amount) as data, date_part(\'month\', date) as month, date_part(\'year\', date) as year'))->whereYear('date',  $year)->groupBy('month', 'year')->get();
            $completedTasks = Task::where('print_date', '<', $today)->count();
            $ongoingTasks = Task::where('print_date', '>=', $today)->count();
            $upcomingTasks = Task::where('print_date', '>=', $today)->limit(5)->get();
            $data = ['monthlyTasks'=>$monthlyTasks, 'monthlyEarning'=>$monthlyEarning, 'completedTasks'=>$completedTasks, 'ongoingTasks'=>$ongoingTasks, 'upcomingTasks'=>$upcomingTasks];
            return $this->sendResponse(200, $data, "Resource feteched successfully");
        }catch(Exception $e){
            echo($e);
            $this->sendResponse(500, null, "Something went wrong");
        }
    }
}
