<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() 
    {
        $posts = Post::paginate(6);

        $data = [
            'success' => true,
            'results' => $posts
        ];

        return response()->json($data);
    }
 
    public function show($slug) 
    {
        // Chiediamo al model di cercare un post che abbia nella colonna 'slug' un valore pari a quello passato in $slug
        // e UNIAMO gli eventuali risultati trovati nelle tabelle 'tags' e 'categories' relazionate con 'posts',  
        // richiamando i nomi delle funzioni presenti nei relativi model
       $post = Post::where('slug', '=', $slug)->with(['tags', 'category'])->first();
       
        // SE il risultato della query contenuto in $post non sarà inesistente/null, passiamo 'results' e 'success' come true
        // ALTRIMENTI 'results' non verrà tornato e 'success' tornerà false
       if ($post) {
            $data = [
                'success' => true,
                'results' => $post
            ];
       } else {
            $data = [
                'success' => false
            ];
       }
       
       

       return response()->json($data);
    }
}
