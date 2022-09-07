<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::all();

        // Prendo $post_deleted che viene passato da destroy quando viene eliminato un post
        // Assegno null come valore SE il parametro non viene passato e quindi non è settato, altrimenti visualizziamo un errore relativo alla variabile non definita
        // Questo valore ci consentirà di stampare o meno nella index il messaggio di conferma dell'eliminazione del post
        $post_deleted = isset($request['post_deleted']) ? $request['post_deleted'] : null;

        $data = [
            'posts' => $posts,
            'post_deleted' => $post_deleted
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
        $categories = Category::all();

        $data = [
            'categories' => $categories
        ];

        return view('admin.posts.create', $data);
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

        // Creo il messaggio relativo a quanti giorni fa è stato creato/aggiornato il post
        $now = Carbon::now();
        $diff_days = $post->created_at->diffInDays($now);
   
        if ($diff_days == 0) {
            $how_long_ago = 'Oggi';
        } else if ($diff_days == 1) {
            $how_long_ago = 'Ieri';
        } else {
            $how_long_ago = $diff_days . 'giorni fa';
        }
        

        // Prendo i parametri che vengono passati da store quando viene creato un nuovo fumetto e da update quando viene modificato.
        // Assegno null come valore SE il parametro non viene passato e quindi non è settato, altrimenti visualizziamo un errore relativo alla/e variabile/i non definite
        // Questo valore ci consentirà di stampare o meno nella show il messaggio di avvenuta operazione (creazione/aggiornamento post)
        $request_data = $request->all();
        $post_created = isset($request_data['post_created']) ? $request_data['post_created'] : null;
        $post_updated = isset($request_data['post_updated']) ? $request_data['post_updated'] : null;

        $data = [
            'post' => $post,
            'post_created' => $post_created,
            'post_updated' => $post_updated,
            'how_long_ago' => $how_long_ago
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
        $categories = Category::all();

        $data = [
            'post' => $post,
            'categories' => $categories
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
        $post_to_delete = Post::findOrFail($id);
        $post_to_delete->delete();

        $post_deleted = true;

        $data = [
            'post_deleted' => $post_deleted
        ];

        return redirect()->route('admin.posts.index', $data);
    }

    // FUNCTIONS
    // Contiene le regole di validazione per i form presenti in create() ed edit()
    protected function getValidationRules() {
        return [
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:50000',
                // controlla che ci sia valore null oppure che esista una categoria 
                // nel campo id della tabella categories evitando che dall'inspector si possano iniare valori
                // non presenti nella colonna id del database
                'category_id' => 'nullable|exists:categories,id'
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
