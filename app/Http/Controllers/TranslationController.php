<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;

// class TranslationController extends Controller
// {
//     /**
//      * Handle translation requests.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function translate(Request $request)
//     {
//         // Use Http::post instead of a translator service
//         $response = Http::post(env('TRANSLATION_API_URL'), [
//             'q' => $request->input('q'),
//             'source' => $request->input('source'),
//             'target' => $request->input('target'),
//         ]);

//         return response()->json($response->json());
//     }
// }
