<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Category;
use App\Mail\NewPostAdminEmail;
use App\Post;
use App\Tag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::paginate(5);

        // Prendo $post_deleted che viene passato da destroy quando viene eliminato un post
        // Assegno null come valore SE il parametro non viene passato e quindi non √® settato, altrimenti visualizziamo un errore relativo alla variabile non definita
        // Questo valore ci consentir√† di stampare o meno nella index il messaggio di conferma dell'eliminazione del post
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
        $tags = Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags
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
        
        if (isset($form_data['post-cover'])) {
            // Carica il file nella cartella 'uploads' che crea in storage/app/public
            // e torna il path dell'immagine che andr√† salvato nel db
            $img_path = Storage::put('uploads', $form_data['post-cover']);
            $form_data['cover'] = $img_path;
        }

        // In form_data, assegna alla chiave che crea con lo stesso nome della colonna presente in 'posts',
        // il path dell'immagine caricata tramite il form e che verr√† poi assegnato tramite fill

        $new_post = new Post();
        $new_post->fill($form_data);

        $new_post->slug = $this->getUniqueSlug($new_post->title);
        
        $new_post->save();

        // Dopo aver salvato il nuovo post, gli associo i tag
        if (isset($form_data['tags'])) {
            $new_post->tags()->sync($form_data['tags']);
        }

        // Invio all'Amministratore un'email di notifica della creazione del nuovo post
        Mail::to('admin@email.it')->send(new NewPostAdminEmail($new_post));

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

        // Creo il messaggio relativo a quanti giorni fa √® stato creato/aggiornato il post
        $how_long_ago_created = $this->getHowLongAgo($post->created_at);
        $how_long_ago_updated = $this->getHowLongAgo($post->updated_at);
        
        // Prendo i parametri che vengono passati da store quando viene creato un nuovo fumetto e da update quando viene modificato.
        // Assegno null come valore SE il parametro non viene passato e quindi non √® settato, altrimenti visualizziamo un errore relativo alla/e variabile/i non definite
        // Questo valore ci consentir√† di stampare o meno nella show il messaggio di avvenuta operazione (creazione/aggiornamento post)
        $request_data = $request->all();
        $post_created = isset($request_data['post_created']) ? $request_data['post_created'] : null;
        $post_updated = isset($request_data['post_updated']) ? $request_data['post_updated'] : null;

        $data = [
            'post' => $post,
            'post_created' => $post_created,
            'post_updated' => $post_updated,
            'how_long_ago_created' => $how_long_ago_created,
            'how_long_ago_updated' => $how_long_ago_updated,
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
        $tags = Tag::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
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

        if (isset($form_data['post-cover'])) {
            // Carica l'immagine nella cartella storage/app/public/uploads
            // e torna il path dell'immagine che andr√† salvato nel db
            $img_path = Storage::put('uploads', $form_data['post-cover']);
            $form_data['cover'] = $img_path;
        }

        $post_to_update = Post::findOrFail($id);
        // SE il titolo inserito nel form √® diverso da quello presente nel post da modificare
        // ALLORA assegniamo un nuovo slug che creiamo con la funzione getUniqueSlug() a cui passiamo il titolo modificato
        // ALTRIMENTI assegniamo lo slug gi√† presente dato che il titolo non √® stato modificato
        if ($form_data['title'] !== $post_to_update->title) {
            $form_data['slug'] = $this->getUniqueSlug($form_data['title']);
        } else {
            $form_data['slug'] = $post_to_update->slug; 
        }
        // Aggiorniamo il post con i dati del form
        $post_to_update->update($form_data);

        // Dopo aver aggiornato il post, aggiorniamo anche i tag
        if (isset($form_data['tags'])) {
            $post_to_update->tags()->sync($form_data['tags']);
        } else {
            $post_to_update->tags()->sync([]); // Rimuove tutti i tag precedentemente salvati
        }

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
        $post_to_delete->tags()->sync([]);
        $post_to_delete->delete();

        $post_deleted = true;

        $data = [
            'post_deleted' => $post_deleted
        ];

        return redirect()->route('admin.posts.index', $data);
    }


    // *******************
    //      FUNCTIONS
    // *******************
    

    // E' richiamata da store() e update() 
    // e contiene le regole di validazione per i form presenti in create() ed edit()
    protected function getValidationRules() {
        return [
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:50000',
                'post-cover' => 'file|mimes:jpeg,jpg,png,bmp,gif,svg,webp|max:3024|nullable',
                // controlla che ci sia valore null oppure che esista una categoria 
                // nel campo id della tabella categories evitando che dall'inspector si possano iniare valori
                // non presenti nella colonna id del database
                'category_id' => 'nullable|exists:categories,id'
        ];
    }
    
    // Fornisce uno slug univoco fornendo il titolo del nuovo post inserito tramite form presente in create() ed edit()
    protected function getUniqueSlug($new_title) {
        // Assegno lo slug
        $slug_to_save = Str::slug($new_title, '-');
        $slug_original =  $slug_to_save;
        // Verifica se lo slug gi√† esiste nel db. Se non ce ne sono, il valore di $existing_same_slug sar√† null
        $existing_same_slug = Post::where('slug', '=', $slug_to_save)->first();
        

        // Finch√® trova uno slug gi√† con quel nome e quindi $existing_slug sar√† true perch√® avr√† un valore,
        // continuer√≤ ad appendere allo slug $slug_to_save -1, -2, ecc..
        // SE lo slug risultante non sar√† uguale a nessun altro nel db, $existing_slug sar√† null (quindi non pi√Ļ true) 
        // e si interromper√† il ciclo memorizzando il dato nel db
        $counter = 1;
        while ($existing_same_slug) {
            $slug_to_save = $slug_original . '-' . $counter;

            // Verifica se lo slug gi√† esiste nel db. Se non ce ne sono, il valore di $existing_same_slug sar√† null
            $existing_same_slug = Post::where('slug', '=', $slug_to_save)->first();
            
            $counter++;
        }

        return $slug_to_save;
    }

    // Crea un messaggio relativo a quanti giorni sono passati 
    // dalla data odierna a quella che gli si passa tramite argomento
    protected function getHowLongAgo($date) {
        // Data odierna
        $now = Carbon::now();
        
        // quanti giorni sono passati da oggi alla data che abbiamo passato passata
        $diff_days = $date->diffInDays($now);
        
        // Ritorna un messaggio sulla base di $diff_days
        if ($diff_days == 0) {
            return 'Today';
        } else if ($diff_days == 1) {
            return 'Yesterday';
        } else {
            return $diff_days . ' days ago';
        }
    }
}
