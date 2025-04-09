<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Crear un nuevo libro.
     */
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    /**
     * Mostrar un libro específico.
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Actualizar un libro existente.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|required|string|max:255',
            'stock' => 'nullable|integer|min:0',
        ]);

        $book->update($validated);
        return response()->json($book, 200);
    }

    /**
     * Eliminar un libro.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }
}
