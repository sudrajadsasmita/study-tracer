<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCreateRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->user_id != null) {
                $event = Event::userId(userId: $request->user_id)->get();
            } else {
                $event = Event::all();
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
    public function update(Request $request, $id)
    {
        $data = $request->validated();
        try {
            $event = Event::findOrFail($id);
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
            $data = $event->delete();
            return $this->sendResponse(result: $data, message: "delete data successful...");
        } catch (\Exception $e) {
            return $this->sendError(error: $e->getMessage());
        }
    }
}
