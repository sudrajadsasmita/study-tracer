<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileUpdatePhotoRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->status_bekerja != null) {
                $profile = Profile::with(["prodi.faculty"])->statusBekerja(statusBekerja: $request->status_bekerja)->get();
            } else {
                $profile = Profile::with(["prodi.faculty"])->get();
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
            $data = Profile::where('id', '=', $id)->with(["prodi.faculty"])->first();
            return $this->sendResponse(result: $data, message: "fetch data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    public function updatePhoto(ProfileUpdatePhotoRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $profile = Profile::findOrFail($id);
            if (isset($data["photo"])) {
                $imageName = time() . '.' . $data["photo"]->getClientOriginalExtension();
                if ($profile->photo != null) {
                    $existPath = Str::replace(url(""), '', $profile->photo);
                    File::delete(public_path($existPath));
                }
                $path = "assets/file/profile/$profile->nim";

                $data["photo"]->move(public_path($path), $imageName);
                $data["photo"] = $path . "/" . $imageName;
                $profile->update($data);
                return $this->sendResponse(result: $profile, message: "update data successful...");
            } else {
                return $this->sendResponse(result: $data, message: "update data successful...");
            }
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
                $imageName = time() . '.' . $data["photo"]->getClientOriginalExtension();
                if ($profile->photo != null) {
                    $existPath = Str::replace(url(""), '', $profile->photo);
                    File::delete(public_path($existPath));
                }
                $path = "assets/file/profile/$profile->nim";

                $data["photo"]->move(public_path($path), $imageName);
                $data["photo"] = $path . "/" . $imageName;
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
            $data = $profile->delete();
            return $this->sendResponse(result: $data, message: "delete data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }
}
