<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;

class LeadController extends Controller
{
    public function store(Request $request) {
        // Valido i dati del form contatti
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|max:50',
        //     'message' => 'required|string|max:50000'
        // ]);

        $form_data = $request->all();
        $new_lead = new Lead();

        // Salvo i dati nel database
        $new_lead->fill($form_data);
        $new_lead->save();

        return response()->json([
            'success' => true
        ]);
    }
}
