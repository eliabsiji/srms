<?php

namespace App\Http\Controllers\Apps;

use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyJournalsController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:myjournals-list|myjournals-create|myjournals-edit|myjournals-delete', ['only' => ['index','store']]);
         $this->middleware('permission:myjournals-create', ['only' => ['create','store']]);
         $this->middleware('permission:myjournals-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:myjournals-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('myjournal.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        echo Carbon::now()->toDateString();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
