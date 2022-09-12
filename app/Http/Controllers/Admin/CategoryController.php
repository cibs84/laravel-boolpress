<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $request_data = $request->all();
        $updated = isset($request_data['updated']) ? $request_data['updated'] : null;
        $deleted = isset($request_data['deleted']) ? $request_data['deleted'] : null;

        $data = [
            'categories' => $categories,
            'updated' => $updated,
            'deleted' => $deleted,
        ];

        return view('admin.categories.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('admin.categories.create');
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

        $new_category = new Category();
        $new_category->name = Str::ucfirst($form_data['name']);
        $new_category->slug = Str::slug($form_data['name'], '-');
        $new_category->save();


        $data = [
            'category' => $new_category->id,
            'created' => true
        ];

        return redirect()->route('admin.categories.show', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $request = $request->all();
        $created = isset($request['created']) ? $request['created'] : null;
        
        $category = Category::findOrFail($id);

        $data = [
            'category' => $category,
            'created' => $created
        ];

        return view('admin.categories.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $data = [
            'category' => $category
        ];

        return view('admin.categories.edit', $data);
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
        $category_to_update = Category::findOrFail($id);
        $category_to_update->name = $form_data['name'];
        $category_to_update->slug = Str::slug($category_to_update->name, '-');
        $category_to_update->update();

        $data = [
            'updated' => true
        ];

        return redirect()->route('admin.categories.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category_to_delete = Category::findOrFail($id);
        $category_to_delete->delete();

        $data = [
            'deleted' => true
        ];

        return redirect()->route('admin.categories.index', $data);
    }


    // F U N C T I O N S 

    // Contiene le regole di validazione per i form presenti in create() ed edit()
    protected function getValidationRules() {
        return [
            'name' => 'required|unique:categories,name|string|max:255'
        ];
    }
}
