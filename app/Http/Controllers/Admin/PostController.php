<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $data = [
            'posts' => $posts
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:50000'
        ]);

        $form_data = $request->all();

        $new_post = new Post();
        $new_post->fill($form_data);

        // Assegno lo slug
        $slug_to_save = Str::of($new_post->title)->lower()->slug('-');
        $slug_original =  $slug_to_save;
        // Verifica se lo slug già esiste nel db. Se non ce ne sono, il valore di $existing_same_slug sarà null
        $existing_same_slug = Post::where('slug', '=', $slug_to_save)->first();
        

        // Finchè trova uno slug già con quel nome e quindi $existing_slug sarà true perchè avrà un valore,
        // continuerò ad appendere allo slug $slug_to_save -1, -2, ecc..
        // SE lo slug risultante non sarà uguale a nessun altro nel db, interrompo il ciclo e memorizzo il dato nel db
        $counter = 1;
        while ($existing_same_slug) {
            $slug_to_save = $slug_original . '-' . $counter;

            // Verifica se lo slug già esiste nel db. Se non ce ne sono, il valore di $existing_same_slug sarà null
            $existing_same_slug = Post::where('slug', '=', $slug_to_save)->first();
            
            $counter++;
        }

        $new_post->slug = $slug_to_save;
        $new_post->save();
        
        return redirect()->route('admin.posts.show', ['post' => $new_post->id, 'post_created' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $post = Post::findOrFail($id);

        // Prendo i parametri che vengono passati da store quando viene creato un nuovo fumetto e da update quando viene modificato.
        // Assegno null come valore SE il parametro non viene passato e quindi non è settato, altrimenti visualizziamo un errore relativo alla/e variabile/i non definite
        $request_data = $request->all();
        $post_created = isset($request_data['post_created']) ? $request_data['post_created'] : null;

        $data = [
            'post' => $post,
            'post_created' => $post_created
        ];
        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
