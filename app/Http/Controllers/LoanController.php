<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Loan::with(['user', 'book'])->get();
    }

    /**
     * Crear un nuevo préstamo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        // Verifica que el libro tenga stock disponible
        $book = \App\Models\Book::find($validated['book_id']);
        if ($book->stock <= 0) {
            return response()->json(['message' => 'No hay stock disponible para este libro'], 400);
        }

        // Reduce el stock del libro
        $book->decrement('stock');

        // Crea el préstamo
        $loan = Loan::create($validated);
        return response()->json($loan, 201);
    }

    /**
     * Mostrar un préstamo específico.
     */
    public function show(Loan $loan)
    {
        return $loan->load(['user', 'book']);
    }

    /**
     * Actualizar un préstamo existente.
     */
    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'return_date' => 'nullable|date',
        ]);

        // Si se está devolviendo el libro, incrementa el stock
        if (isset($validated['return_date']) && !$loan->return_date) {
            $loan->book->increment('stock');
        }

        $loan->update($validated);
        return response()->json($loan, 200);
    }

    /**
     * Eliminar un préstamo.
     */
    public function destroy(Loan $loan)
    {
        // Si el préstamo no tiene fecha de devolución, incrementa el stock
        if (!$loan->return_date) {
            $loan->book->increment('stock');
        }

        $loan->delete();
        return response()->json(null, 204);
    }
}
