<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Traits\Date;
use DateTime;
use Exception;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tasks = Task::paginate();
            return $this->sendResponse(200, $tasks, 'Resource fetched successfully');
        } catch (Exception $e) {
            // echo($e);
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
            echo('here');

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
                return $this->sendResponse(201, null, 'Resource deleted succussfully');
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        } catch (Exception $e) {
            return $this->sendResponse(500, null, 'Something went wrong');
        }
    }
}
