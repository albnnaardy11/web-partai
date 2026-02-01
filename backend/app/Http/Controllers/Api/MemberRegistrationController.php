<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string|max:20',
            'nik' => 'required|string|size:16|unique:members,nik',
            'address' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'ktp_photo' => 'nullable|image|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('ktp_photo');
        
        if ($request->hasFile('ktp_photo')) {
            $path = $request->file('ktp_photo')->store('members/ktp', 'public');
            $data['ktp_photo_path'] = $path;
        }

        $member = Member::create($data);

        // Notify Admins
        $admins = \App\Models\User::all();
        \Filament\Notifications\Notification::make()
            ->title('Pendaftaran Anggota Baru')
            ->body("Anggota baru terdaftar: {$member->full_name}")
            ->icon('heroicon-o-user-plus')
            ->color('success')
            ->actions([
                \Filament\Actions\Action::make('view')
                    ->label('Lihat Detail')
                    ->url(\App\Filament\Resources\MemberResource::getUrl('edit', ['record' => $member])),
            ])
            ->sendToDatabase($admins);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Data Anda akan divalidasi oleh tim kami.',
            'data' => $member
        ], 201);
    }
}
