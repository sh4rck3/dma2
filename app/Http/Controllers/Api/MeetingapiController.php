<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;

class MeetingapiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
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
        Log::info('MeetingapiController.store' . print_r($request->all(), true));
        $userLogado = Auth::user();
        Log::info('MeetingapiController.store' . $userLogado->id);

        // $meeting = new Meeting();
        // $meeting->title = $request->subject;
        // $meeting->description = $request->observation;
        // $meeting->dateMeeting = $request->dateMeeting;
        // $meeting->link = $request->linkMeeting;
        // $meeting->timeMeeting = $request->timeMeeting;
        // $meeting->userId = $userLogado->id;
        // $meeting->localeMeeting = $request->selected;
        // $meeting->save();

        return response()->json([
            'status' => true,
            'title' => 'Meeting!',
            'message' => 'Reunião cadastrada com sucesso!',
            'icon' => 'success'
        ], Response::HTTP_OK);
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
