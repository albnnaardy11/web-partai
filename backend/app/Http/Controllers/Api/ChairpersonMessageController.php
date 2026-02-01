<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ChairpersonMessage;
use OpenApi\Attributes as OA;

class ChairpersonMessageController extends Controller
{
    #[OA\Get(path: '/api/chairperson-message', summary: 'Get chairperson message', tags: ['General'])]
    #[OA\Response(response: 200, description: 'Successful operation')]
    public function index()

    {
        $message = ChairpersonMessage::where('is_active', true)->latest()->first();

        if (!$message) {
            return response()->json([
                'header_badge' => 'Sambutan Ketua Umum',
                'header_title' => 'Pesan dari <span class="text-danger">Ibu Ketua</span>',
                'image_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=988&auto=format&fit=crop',
                'message_greeting' => '"Assalamu’alaikum warahmatullahi wabarakatuh dan salam sejahtera untuk seluruh rakyat Indonesia."',
                'message_content' => [
                    'Sebagai seorang ibu, saya memahami betul bagaimana pentingnya kasih sayang, perlindungan, dan pengorbanan untuk masa depan yang lebih baik. Nilai-nilai inilah yang kami bawa ke dalam dunia politik Indonesia.',
                    'Mari bersama-sama kita wujudkan Indonesia yang lebih adil, makmur, dan penuh kasih sayang. Karena Indonesia adalah rumah kita bersama, dan setiap keluarga Indonesia berhak mendapatkan kehidupan yang layak.'
                ],
                'signature_greeting' => 'Wassalamu’alaikum warahmatullahi wabarakatuh,',
                'chairperson_name' => 'Ibu Siti Rahmawati',
                'chairperson_title' => 'Ketua Umum Partai Ibu',
                'philosophy_text' => '"Indonesia adalah keluarga besar kita"',
                'commitment_text' => '"Kepedulian untuk setiap anak bangsa"',
            ]);
        }

        // Split message_content into paragraphs if it's a single string with newlines
        $paragraphs = explode("\n", str_replace("\r", "", $message->message_content));
        $paragraphs = array_filter(array_map('trim', $paragraphs));

        return response()->json([
            'header_badge' => $message->header_badge,
            'header_title' => $message->header_title,
            'image_url' => $message->image_path ? asset('storage/' . $message->image_path) : null,
            'message_greeting' => $message->message_greeting,
            'message_content' => $paragraphs,
            'signature_greeting' => $message->signature_greeting,
            'chairperson_name' => $message->chairperson_name,
            'chairperson_title' => $message->chairperson_title,
            'philosophy_text' => $message->philosophy_text,
            'commitment_text' => $message->commitment_text,
        ]);
    }
}
