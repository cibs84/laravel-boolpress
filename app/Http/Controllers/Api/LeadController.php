<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactThankYouEmail;

class LeadController extends Controller
{
    public function store(Request $request) {
        // Leggo i dati inviati dal form presente nella pagina /contact
        $form_data = $request->all();

        // Valido i dati del form contatti
        $validator = Validator::make($form_data, [
            'name' => 'required|string|max:255|regex:/^[\pL\s\']+$/u|min:3', // consente solo caratteri, apostrofi e spazi (no numeri e caratteri speciali)
            'email' => 'required|string|max:50|email:rfc,dns',
            'message' => 'required|string|max:50000'
        ]);

        // SE la validazione fallisce
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        
        // Salvo i dati nel database
        $new_lead = new Lead();
        $new_lead->fill($form_data);
        $new_lead->save();

        // Invio email di ringraziamento
        Mail::to($new_lead->email)->send(new ContactThankYouEmail());

        return response()->json([
            'success' => true
        ]);
    }
}
