<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TokenQueue;
use App\Models\Appointment;

class QueueController extends Controller
{
    public function index()
    {
        $queue = TokenQueue::latest()->paginate(20);
        return view('admin.queue.index', compact('queue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'phone' => 'nullable|string',
        ]);

        $tokenNum = 'TK-' . rand(1000, 9999);

        TokenQueue::create([
            'token_number' => $tokenNum,
            'patient_name' => $request->patient_name,
            'phone' => $request->phone,
            'service' => $request->service,
            'queue_time' => now()->format('h:i A'),
            'status' => 'Waiting',
        ]);

        return back()->with('success', "Walk-in Token {$tokenNum} added to queue.");
    }

    public function cycleStatus(TokenQueue $tokenQueue)
    {
        if ($tokenQueue->status === 'Waiting') {
            $newStatus = 'In-Consultation';
        } elseif ($tokenQueue->status === 'In-Consultation') {
            $newStatus = 'Completed';
        } else {
            $newStatus = 'Waiting';
        }

        $tokenQueue->update(['status' => $newStatus]);

        // Sync with appointment table
        Appointment::where('token_number', $tokenQueue->token_number)
            ->update(['status' => $newStatus]);

        return back()->with('success', "Token {$tokenQueue->token_number} is now {$newStatus}.");
    }

    public function destroy(TokenQueue $tokenQueue)
    {
        $tokenQueue->delete();
        return back()->with('success', 'Token removed from queue.');
    }
}
