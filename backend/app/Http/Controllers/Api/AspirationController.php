<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class AspirationController extends Controller
{
    #[OA\Post(path: '/api/aspirations', summary: 'Submit a new aspiration', tags: ['Aspirations'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name", "email", "subject", "message"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Budi Santoso"),
                new OA\Property(property: "email", type: "string", format: "email", example: "budi@example.com"),
                new OA\Property(property: "subject", type: "string", example: "Saran Pembangunan"),
                new OA\Property(property: "message", type: "string", example: "Saya ingin menyarankan agar...")
            ]
        )
    )]
    #[OA\Response(response: 201, description: 'Aspiration submitted successfully')]
    #[OA\Response(response: 422, description: 'Validation error')]
    public function store(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $aspiration = Aspiration::create($request->all());

        // Notify Admins
        $admins = \App\Models\User::all();
        \Filament\Notifications\Notification::make()
            ->title('Aspirasi Rakyat Baru')
            ->body("Aspirasi baru dari: {$aspiration->name}")
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->color('info')
            ->actions([
                \Filament\Actions\Action::make('view')
                    ->label('Baca Aspirasi')
                    ->url(\App\Filament\Resources\AspirationResource::getUrl('edit', ['record' => $aspiration])),
            ])
            ->sendToDatabase($admins);

        return response()->json([
            'success' => true,
            'message' => 'Aspirasi Anda telah terkirim! Terima kasih telah berkontribusi untuk Indonesia.',
            'data' => $aspiration
        ], 201);
    }
}

