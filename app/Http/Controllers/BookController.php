<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->paginate(12);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        $validated['available_quantity'] = $validated['quantity'];

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Book $book)
    {
        $book->load('category', 'loans.user');
        return view('books.show', compact('book'));
    }

    public function cover(Book $book)
    {
        if (empty($book->cover_image) || !Storage::disk('public')->exists($book->cover_image)) {
            abort(404);
        }

        return Storage::disk('public')->response($book->cover_image);
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id . '|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if (!empty($book->cover_image) && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        $quantityDiff = $validated['quantity'] - $book->quantity;
        $validated['available_quantity'] = $book->available_quantity + $quantityDiff;

        $book->update($validated);

        return redirect()->route('books.show', $book)->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        if ($book->loans()->where('status', '!=', 'returned')->count() > 0) {
            return redirect()->route('books.index')->with('error', 'Buku tidak dapat dihapus karena masih ada peminjaman aktif');
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $books = Book::where('title', 'LIKE', "%$query%")
                    ->orWhere('author', 'LIKE', "%$query%")
                    ->orWhere('isbn', 'LIKE', "%$query%")
                    ->with('category')
                    ->paginate(12);

        return view('books.index', compact('books'));
    }
}
