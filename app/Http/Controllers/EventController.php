<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->search;
            if ($request->role == "ADMIN") {
                $event = Event::all();
            } else {
                if ($request->user_id != null) {
                    if ($request->type != null) {
                        $event = Event::userId(userId: $request->user_id)->type(type: $request->type)->where('nama', 'LIKE', '%' . $search . '%')->get();
                    } else {
                        $event = Event::userId(userId: $request->user_id)->where('nama', 'LIKE', '%' . $search . '%');
                    }
                } else {
                    if ($request->type != null) {
                        $event = Event::type(type: $request->type)->where('nama', 'LIKE', '%' . $search . '%');
                    } else {
                        $event = Event::where('nama', 'LIKE', '%' . $search . '%');
                    }
                }
            }
            if ($request->has("paginate") && $request->get("paginate") == "true") {
                return $event->paginate();
            }
            return $this->sendResponse(result: $event->get(), message: "fetch data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    public function getNewFiveEvent()
    {
        try {
            $event  = Event::latest()->limit(5)->get();
            return $this->sendResponse(result: $event, message: "fetch data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventCreateRequest $request)
    {
        $item = $request->validated();
        try {
            $imageName = time() . '.' . $item["image"]->getClientOriginalExtension();
            $path = "assets/file/event/$item[type]/$item[user_id]";
            $item["image"]->move(public_path($path), $imageName);
            $data = [
                "user_id" => $item["user_id"],
                "nama" => $item["nama"],
                "url" => $item["url"],
                "image" => $path . "/" . $imageName,
                "type" => $item["type"]
            ];
            $event = Event::create($data);
            return $this->sendResponse(result: $event, message: "create data successful...");
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
            $data = Event::findOrFail($id)->first();
            return $this->sendResponse(result: $data, message: "fetch data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, $id)
    {
        $data = $request->validated();
        try {
            $event = Event::findOrFail($id);
            if (isset($data["image"])) {
                $existPath = Str::replace(url(""), '', $event->image);
                File::delete(public_path($existPath));
                $imageName = time() . '.' . $data["image"]->getClientOriginalExtension();
                $path = "assets/file/event/$event->type/$event->user_id";
                $data["image"]->move(public_path($path), $imageName);

                $data["image"] = $path . "/" . $imageName;
            }
            $event->update($data);
            return $this->sendResponse(result: $event, message: "update data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            $path = str_replace(asset(''), '', $event->image);
            File::delete($path);
            $data = $event->delete();
            return $this->sendResponse(result: $data, message: "delete data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }
}
