<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    //著者一覧
    public function index()
    {
        $authors = Author::orderBy('id', 'asc')->simplePaginate(5);
        return view('author.index', compact('authors'));
    }

    //著者新規登録
    public function create()
    {
        return view('author.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, Author::$rules);
        $author = new Author([
            'name' => $request->input('name'),
        ]);
        if ($author->save()) {
            $request->session()->flash('success', __('著者を新規登録しました'));
        }else{
            $request->session()->flash('error', __('著者の新規登録に失敗しました'));
        }

        return redirect()->route('author.index');
    }

    //著者表示
    public function show($id)
    {
        $author = Author::find($id);
        return view('author.show', compact('author'));
    }

    //著者編集
    public function edit($id)
    {
        $author = Author::find($id);
        return view('author.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, Author::$rules);
        $author = Author::find($id);
        $author->name = $request->input('name');
        
        if($author->save()){
            $request->session()->flash('success', __('著者を更新しました'));
        }else{
            $request->session()->flash('error', __('著者の更新に失敗しました'));
        }
        return redirect()->route('author.index');
    }

}
