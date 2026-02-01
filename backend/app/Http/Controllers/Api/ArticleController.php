<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class ArticleController extends Controller
{
    #[OA\Get(path: '/api/articles', summary: 'Get list of articles', tags: ['Articles'])]
    #[OA\Parameter(name: 'search', in: 'query', description: 'Search keyword for articles', required: false, schema: new OA\Schema(type: 'string'))]
    #[OA\Response(response: 200, description: 'Successful operation')]
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        return response()->json($query->latest()->get());
    }

    #[OA\Get(path: '/api/articles/{id}', summary: 'Get article detail', tags: ['Articles'])]
    #[OA\Parameter(name: 'id', in: 'path', description: 'ID of article to return', required: true, schema: new OA\Schema(type: 'integer'))]
    #[OA\Response(response: 200, description: 'Successful operation')]
    #[OA\Response(response: 404, description: 'Article not found')]
    public function show($id)
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }
        return response()->json($article);
    }
}

