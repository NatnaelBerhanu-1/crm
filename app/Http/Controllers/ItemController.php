<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Exception;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $items = Item::paginate(10);
            return $this->sendResponse(200, $items, "Resource fetched successfully");
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, 'Something went swrong');
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
                'description' => 'required',
                'price' => 'required',
                'location' => 'required',
                'condition' => 'required',
            ]);

            if ($validated) {
                $name = $request->input('name');
                $description = $request->input('description');
                $price = $request->input('price');
                $location = $request->input('location');
                $condition = $request->input('condition');

                $remark = $request->input('remark');
                if ($remark == null) {
                    $remark = "";
                }

                $item = Item::create([
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'location' => $location,
                    'condition' => $condition,
                    'remark' => $remark
                ]);

                return $this->sendResponse(201, $item, "Resource created successfully!");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, 'Something went swrong');
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
            $item = Item::where('id', $id)->first();
            if (isset($item)) {
                return $this->sendResponse(200, $item, 'Resource fetched succussfully');
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        } catch (Exception $e) {
            echo ($e);
            $this->sendResponse(500, null, "Something went wrong");
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
            $item = Item::where('id', $id)->first();

            if (isset($item)) {
                $validated = $request->validate([
                    'name' => 'required',
                    'description' => 'required',
                    'price' => 'required',
                    'location' => 'required',
                    'condition' => 'required',
                ]);

                if ($validated) {
                    $name = $request->input('name');
                    $description = $request->input('description');
                    $price = $request->input('price');
                    $location = $request->input('location');
                    $condition = $request->input('condition');
                    $remark = $request->input('remark');
                    if ($remark == null) {
                        $remark = "";
                    }

                    $item->name = $name;
                    $item->description = $description;
                    $item->price = $price;
                    $item->location = $location;
                    $item->condition = $condition;
                    $item->remark = $remark;

                    $item->save();

                    return $this->sendResponse(200, $item, "Resource created successfully!");
                }
            } else {
                return $this->sendResponse(400, null, "Resource not found");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            echo ($e->validator->getMessageBag());
            return $this->sendResponse(500, null, 'Something went wrong');
        } catch (Exception $e) {
            echo ($e);
            return $this->sendResponse(500, null, 'Something went swrong');
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
            $item = Item::where('id', $id)->first();
            if (isset($item)) {
                $item->delete();
                return $this->sendResponse(204, null, 'Resource deleted succussfully');
            } else {
                return $this->sendResponse(404, null, 'Resource not found');
            }
        } catch (Exception $e) {
            echo ($e);
            $this->sendResponse(500, null, "Something went wrong");
        }
    }
}
