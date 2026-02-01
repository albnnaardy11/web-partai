<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ProgramController extends Controller
{
    #[OA\Get(path: '/api/programs', summary: 'Get list of programs', tags: ['General'])]
    #[OA\Response(response: 200, description: 'Successful operation')]
    public function index()

    {
        return response()->json(Program::all());
    }
}
