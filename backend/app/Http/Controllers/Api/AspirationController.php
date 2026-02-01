<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AspirationController extends Controller
{
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
