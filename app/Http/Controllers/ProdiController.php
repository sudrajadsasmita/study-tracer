<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $prodi = Prodi::with(["faculty"])->get();
            return $this->sendResponse(result: $prodi, message: "Fetch data successfully...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    public function getByFaculty($id)
    {
        try {
            $prodi = Prodi::where("faculty_id", "=", $id)->get();
            return $this->sendResponse(result: $prodi, message: "Fetch data successfully...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
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
        //
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
