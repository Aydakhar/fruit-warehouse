<?php

namespace App\Http\Controllers;

use App\Events\WarehouseUpdated;
use App\Models\Box;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouseState = Cache::rememberForever('warehouse_state', function () {
            return Room::with('boxes')->get();
        });

        return response()->json($warehouseState);
    }

    public function addBoxes(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'boxes' => 'required|array',
            'boxes.*.fruit_type' => 'required|string|in:apples,pears,oranges',
            'boxes.*.box_count' => 'required|integer|min:1',
        ]);

        $roomId = $request->get('room_id');
        $boxes = $request->get('boxes');

        foreach ($boxes as $box) {
            $record = Box::firstOrNew([
                'room_id' => $roomId,
                'fruit_type' => $box['fruit_type'],
            ]);

            $record->box_count += $box['box_count'];
            $record->save();
        }

        Cache::forget('warehouse_state');
        broadcast(new WarehouseUpdated())->via('reverb');

        return response()->json(['message' => 'Boxes added successfully']);
    }

    public function moveBoxes(Request $request) {
        $request->validate([
            'from_room_id' => 'required|exists:rooms,id',
            'to_room_id' => 'required|exists:rooms,id',
            'boxes' => 'required|array',
            'boxes.*.fruit_type' => 'required|string|in:apples,pears,oranges',
            'boxes.*.box_count' => 'required|integer|min:1',
        ]);

        $fromRoomId = $request->get('from_room_id');
        $toRoomId = $request->get('to_room_id');
        $boxes = $request->get('boxes');

        foreach ($boxes as $box) {
            $fromBox = Box::where('room_id', $fromRoomId)
                ->where('fruit_type', $box['fruit_type'])
                ->first();

            if (!$fromBox || $fromBox->box_count < $box['box_count']) {
                return response()->json(['message' => 'Not enough boxes to move'], 400);
            }

            $fromBox->box_count -= $box['box_count'];
            if ($fromBox->box_count == 0) {
                $fromBox->delete();
            } else {
                $fromBox->save();
            }

            $toBox = Box::firstOrNew([
                'room_id' => $toRoomId,
                'fruit_type' => $box['fruit_type'],
            ]);

            $toBox->box_count += $box['box_count'];
            $toBox->save();
        }

        Cache::forget('warehouse_state');
        WarehouseUpdated::dispatch();

        return response()->json(['message' => 'Boxes moved successfully']);
    }

    public function removeBoxes(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'boxes' => 'required|array',
            'boxes.*.fruit_type' => 'required|string|in:apples,pears,oranges',
            'boxes.*.box_count' => 'required|integer|min:1',
        ]);

        $roomId = $request->get('room_id');
        $boxes = $request->get('boxes');

        foreach ($boxes as $box) {
            $record = Box::where('room_id', $roomId)
                ->where('fruit_type', $box['fruit_type'])
                ->first();

            if ($record) {
                $record->box_count -= $box['box_count'];
                $record->box_count = max(0, $record->box_count);
                $record->save();
            }
        }

        Cache::forget('warehouse_state');
        WarehouseUpdated::dispatch();

        return response()->json(['message' => 'Boxes removed successfully']);
    }
}
