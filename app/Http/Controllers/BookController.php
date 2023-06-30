<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Laravel\Ui\Presets\React;
use SebastianBergmann\CodeUnit\FunctionUnit;

class BookController extends Controller
{
    //書籍一覧
    public function index(Request $request)
    {
        $books = Book::with(['Author', 'Category'])->sortable()->simplePaginate(5);
        return view('book.index', compact('books'));
    }

    //書籍新規登録
    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
      
        return view('book.create', compact('authors', 'categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, Book::$rules);
        $book = new Book([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'author_id' => $request->input('author_id'),
            'category_id' => $request->input('category_id'),
        ]);
        if($book->save()){
            $request->session()->flash('success', __('書籍を新規登録しました'));
        }else{
            $request->session()->flash('error', __('書籍の新規登録に失敗しました'));
        }
    return redirect()->route('book.index');
    }

    //書籍編集
    public function edit($id)
    {
        $book = Book::find($id);
        $authors = Author::all();
        $categories = Category::all();
        return view('book.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, Book::$rules);
        $book = Book::find($id);
        $colomns = array_keys(Book::$rules);
        foreach($colomns as $colomn){
            $book->$colomn = $request->input($colomn);
            
        }
        
        if($book->save()){
            $request->session()->flash('succes', __('書籍を更新しました'));
        }else{
            $request->session()->flash('error', __('書籍の更新に失敗しました'));
        }
        return redirect()->route('book.index');
    }
}
