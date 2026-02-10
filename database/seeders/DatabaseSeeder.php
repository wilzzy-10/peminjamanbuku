<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@peminjamanbuku.com',
            'password' => bcrypt('password123'),
            'phone' => '081234567890',
            'address' => 'Jalan Amsterdam No. 123, Jakarta',
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create Petugas User
        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@peminjamanbuku.com',
            'password' => bcrypt('password123'),
            'phone' => '081234567895',
            'address' => 'Jalan Perpustakaan No. 200, Jakarta',
            'role' => 'petugas',
            'status' => 'active',
        ]);

        // Create Sample User (Member)
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'phone' => '081234567891',
            'address' => 'Jalan Sudirman No. 456, Jakarta',
            'role' => 'user',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'phone' => '081234567892',
            'address' => 'Jalan Gatot Subroto No. 789, Jakarta',
            'role' => 'user',
            'status' => 'active',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Novel', 'description' => 'Buku cerita fiksi dan novel'],
            ['name' => 'Pendidikan', 'description' => 'Buku-buku pelajaran dan edukasi'],
            ['name' => 'Teknologi', 'description' => 'Buku tentang teknologi dan programming'],
            ['name' => 'Biografi', 'description' => 'Buku biografi tokoh-tokoh terkenal'],
            ['name' => 'Self-Help', 'description' => 'Buku pengembangan diri dan motivasi'],
            ['name' => 'Sejarah', 'description' => 'Buku-buku sejarah dan budaya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Books
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-979-1234-01-1',
                'description' => 'Novel inspiratif tentang perjuangan pendidikan di kepulauan.',
                'category_id' => 1,
                'publisher' => 'Bentang Pustaka',
                'year' => 2005,
                'quantity' => 5,
            ],
            [
                'title' => 'Tetralogi Bumi',
                'author' => 'Tere Liye',
                'isbn' => '978-979-1234-02-2',
                'description' => 'Seri novel yang menceritakan berbagai dimensi realitas.',
                'category_id' => 1,
                'publisher' => 'Pustaka Aksara',
                'year' => 2012,
                'quantity' => 3,
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0-13-235088-4',
                'description' => 'Panduan menulis kode yang bersih dan mudah dipahami.',
                'category_id' => 3,
                'publisher' => 'Prentice Hall',
                'year' => 2008,
                'quantity' => 2,
            ],
            [
                'title' => 'Pemrograman Laravel',
                'author' => 'Muhammad Ihsan',
                'isbn' => '978-979-1234-03-3',
                'description' => 'Belajar framework Laravel dari dasar hingga advanced.',
                'category_id' => 3,
                'publisher' => 'Elex Media',
                'year' => 2023,
                'quantity' => 4,
            ],
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'isbn' => '978-1-451-64488-5',
                'description' => 'Biografi resmi pendiri Apple yang inspiratif.',
                'category_id' => 4,
                'publisher' => 'Simon & Schuster',
                'year' => 2011,
                'quantity' => 3,
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '978-0-7352-1129-8',
                'description' => 'Cara membangun kebiasaan baik dan meninggalkan yang buruk.',
                'category_id' => 5,
                'publisher' => 'Avery',
                'year' => 2018,
                'quantity' => 6,
            ],
            [
                'title' => 'Sejarah Indonesia',
                'author' => 'Slamet Mulyana',
                'isbn' => '978-979-1234-04-4',
                'description' => 'Ringkasan lengkap sejarah Indonesia dari masa prasejarah hingga modern.',
                'category_id' => 6,
                'publisher' => 'Balai Pustaka',
                'year' => 2008,
                'quantity' => 2,
            ],
        ];

        foreach ($books as $book) {
            $book['available_quantity'] = $book['quantity'];
            Book::create($book);
        }
    }
}
