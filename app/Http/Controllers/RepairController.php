<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Required for Str::random


class RepairController extends Controller
{
    public function index()
    {
        return Repair::latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:user,sample',
            'device' => 'required|string',
            'issue' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'name' => 'required_if:type,user|string',
            'phone' => 'required_if:type,user|string',
            'email' => 'required_if:type,user|email',
            'date' => 'required_if:type,user|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('repairs', 'public');
        }

        // Generate tracking code only for actual user repair requests
        $trackingCode = null;
        if ($request->type === 'user') {
            $trackingCode = 'ITA-' . strtoupper(Str::random(6));
        }

        $repair = Repair::create([
            'type' => $request->type,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'device' => $request->device,
            'issue' => $request->issue,
            'date' => $request->date,
            'image' => $imagePath,
            // FIX: Assign a default string for samples instead of null
            'status' => $request->type === 'user' ? 'pending' : 'completed', 
            'tracking_code' => $trackingCode,
        ]);
        return response()->json(['repair' => $repair], 201);
    }

    public function track($code)
    {
        // Search by tracking code
        $repair = Repair::where('tracking_code', $code)->first();

        if (!$repair) {
            return response()->json(['message' => 'Invalid tracking code'], 404);
        }

        return response()->json($repair);
    }
    // Add this to RepairController.php

public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,diagnosing,repairing,completed'
    ]);

    $repair = Repair::findOrFail($id);
    
    // Only allow status updates for user requests
    if ($repair->type !== 'user') {
        return response()->json(['message' => 'Cannot set status for samples'], 400);
    }

    $repair->update([
        'status' => $request->status
    ]);

    return response()->json([
        'message' => 'Status updated successfully',
        'repair' => $repair
    ]);
}

    public function destroy($id)
    {
        $repair = Repair::findOrFail($id);

        if ($repair->image) {
            Storage::disk('public')->delete($repair->image);
        }

        $repair->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}