<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->status_bekerja != null) {
                $profile = Profile::statusBekerja(statusBekerja: $request->status_bekerja)->get();
            } else {
                $profile = Profile::all();
            }
            return $this->sendResponse(result: $profile, message: "fetch data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileCreateRequest $request)
    {
        $data = $request->validated();
        try {
            $data['photo']->store(
                "assets/file/profile/$data[nim]",
                'public'
            );
            $profile = Profile::create($data);
            return $this->sendResponse(result: $profile, message: "create data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Profile::findOrFail($id)->first();
            return $this->sendResponse(result: $data, message: "fetch data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request,  $id)
    {
        $data = $request->validated();
        try {
            $profile = Profile::findOrFail($id);
            if (isset($data["photo"])) {
                $path = str_replace(asset(''), '', $profile->photo);

                File::delete($profile->photo);
                $path = $data["photo"]->store(
                    "assets/file/profile/$profile->nim",
                    'public'
                );
                $data["image"] = $path;
            }
            $profile->update($data);
            return $this->sendResponse(result: $profile, message: "update data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        try {
            $path = str_replace(asset(''), '', $profile->photo);
            File::delete($path);
            File::delete($profile->photo);
            $data = $profile->delete();
            return $this->sendResponse(result: $data, message: "delete data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }
}
