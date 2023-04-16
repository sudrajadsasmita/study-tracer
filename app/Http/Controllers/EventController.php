<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->search;
            if ($request->user_id != null) {
                if ($request->type != null) {
                    $event = Event::userId(userId: $request->user_id)->type(type: $request->type)->where('nama', 'LIKE', '%' . $search . '%')->get();
                } else {
                    $event = Event::userId(userId: $request->user_id)->where('nama', 'LIKE', '%' . $search . '%')->get();
                }
            } else {
                if ($request->type != null) {
                    $event = Event::type(type: $request->type)->where('nama', 'LIKE', '%' . $search . '%')->get();
                } else {
                    $event = Event::where('nama', 'LIKE', '%' . $search . '%')->get();
                }
            }
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
            $path = $item["image"]->store(
                "assets/file/event/$item[type]/$item[user_id]",
                'public'

            );
            $data = [
                "user_id" => $item["user_id"],
                "nama" => $item["nama"],
                "url" => $item["url"],
                "image" => $path,
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
        // dd($data);
        try {
            $event = Event::findOrFail($id);
            if (isset($data["image"])) {
                $path = str_replace(asset(''), '', $event->image);
                File::delete($path);
                $path = $data["image"]->store(
                    "assets/file/event/$event->type/$event->user_id",
                    'public'
                );
                $data["image"] = $path;
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
