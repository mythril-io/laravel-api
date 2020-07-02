<?php

namespace App\Http\Controllers;

use App\DateType;
use Illuminate\Http\Request;

class DateTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DateType::paginate(20);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return DateType::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $this->validate($request, [
            'format' => 'required|unique:date_types',
        ]);

        // Create
        $dateType = DateType::create([
            'format' => $request->format,
        ]);

        return response()->json($dateType, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DateType  $dateType
     * @return \Illuminate\Http\Response
     */
    public function show(DateType $dateType)
    {
        return $dateType;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DateType  $dateType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DateType $dateType)
    {
        // Validate
        $input = $request->only('format');
        $this->validate($request, [
            'format' => 'required|unique:date_types,format,'.$dateType->id,
        ]);

        // Update
        $dateType->update($input);
        $dateType->save();

        return response()->json($dateType, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DateType  $dateType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DateType $dateType)
    {
        $dateType->delete();

        return response()->json(null, 204);
    }
}
