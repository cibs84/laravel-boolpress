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
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        $new_post = new Post();
        $new_post->fill($form_data);

        $new_post->slug = $this->getUniqueSlug($new_post->title);

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
        // Questo valore ci consentirà di stampare o meno nella show il messaggio di avvenuta operazione (creazione/aggiornamento post)
        $request_data = $request->all();
        $post_created = isset($request_data['post_created']) ? $request_data['post_created'] : null;
        $post_updated = isset($request_data['post_updated']) ? $request_data['post_updated'] : null;

        $data = [
            'post' => $post,
            'post_created' => $post_created,
            'post_updated' => $post_updated
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
        $post = Post::findOrFail($id);

        $data = [
            'post' => $post
        ];

        return view('admin.posts.edit', $data);
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
        $request->validate($this->getValidationRules());
        $form_data = $request->all();
        $post_to_update = Post::findOrFail($id);
        // SE il titolo inserito nel form è diverso da quello presente nel post da modificare
        // ALLORA assegniamo un nuovo slug che creiamo con la funzione getUniqueSlug() a cui passiamo il titolo modificato
        // ALTRIMENTI assegniamo lo slug già presente dato che il titolo non è stato modificato
        if ($form_data['title'] !== $post_to_update->title) {
            $form_data['slug'] = $this->getUniqueSlug($form_data['title']);
        } else {
            $form_data['slug'] = $post_to_update->slug;
        }
        // Aggiorniamo il post con i dati del form
        $post_to_update->update($form_data);

        // Variabile di controllo per visualizzare nella show il messaggio di conferma dell'aggiornamento post
        $post_updated = true;

        $data = [
            'post_updated' => $post_updated,
            'post' => $post_to_update->id
        ];

        return redirect()->route('admin.posts.show', $data);
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

    // FUNCTIONS
    // Contiene le regole di validazione per i form presenti in create() ed edit()
    protected function getValidationRules() {
        return [
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:50000'
        ];
    }
    
    // Fornisce uno slug univoco fornendo il titolo del nuovo post inserito tramite form presente in create() ed edit()
    protected function getUniqueSlug($new_title) {
        // Assegno lo slug
        $slug_to_save = Str::of($new_title)->lower()->slug('-');
        $slug_original =  $slug_to_save;
        // Verifica se lo slug già esiste nel db. Se non ce ne sono, il valore di $existing_same_slug sarà null
        $existing_same_slug = Post::where('slug', '=', $slug_to_save)->first();
        

        // Finchè trova uno slug già con quel nome e quindi $existing_slug sarà true perchè avrà un valore,
        // continuerò ad appendere allo slug $slug_to_save -1, -2, ecc..
        // SE lo slug risultante non sarà uguale a nessun altro nel db, $existing_slug sarà null (quindi non più true) 
        // e si interromperà il ciclo memorizzando il dato nel db
        $counter = 1;
        while ($existing_same_slug) {
            $slug_to_save = $slug_original . '-' . $counter;

            // Verifica se lo slug già esiste nel db. Se non ce ne sono, il valore di $existing_same_slug sarà null
            $existing_same_slug = Post::where('slug', '=', $slug_to_save)->first();
            
            $counter++;
        }

        return $slug_to_save;
    }
}
