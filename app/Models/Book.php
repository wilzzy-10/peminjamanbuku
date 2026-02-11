<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'category_id',
        'publisher',
        'year',
        'quantity',
        'available_quantity',
        'cover_image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function isAvailable()
    {
        return $this->available_quantity > 0;
    }

    public function getDisplayCoverUrlAttribute(): ?string
    {
        if (!empty($this->cover_image)) {
            if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
                return $this->cover_image;
            }

            if (Storage::disk('public')->exists($this->cover_image)) {
                return route('books.cover', $this);
            }

            if (File::exists(public_path($this->cover_image))) {
                return asset($this->cover_image);
            }
        }

        $titleKey = $this->normalizeCoverKey($this->title ?? '');
        if ($titleKey === '') {
            return null;
        }

        // Manual aliases for titles whose file names are not 1:1 with titles.
        foreach (self::manualCoverAliases() as $aliasKey => $path) {
            if (str_contains($titleKey, $aliasKey)) {
                return asset($path);
            }
        }

        $titleCompact = str_replace(' ', '', $titleKey);

        foreach (self::publicCoverMap() as $cover) {
            $coverCompact = str_replace(' ', '', $cover['key']);
            if (
                str_contains($titleKey, $cover['key']) ||
                str_contains($cover['key'], $titleKey) ||
                str_contains($titleCompact, $coverCompact) ||
                str_contains($coverCompact, $titleCompact)
            ) {
                return asset($cover['path']);
            }
        }

        return null;
    }

    protected static function publicCoverMap(): array
    {
        static $cache = null;

        if ($cache !== null) {
            return $cache;
        }

        $cache = [];
        $imageDir = public_path('images');

        if (!File::exists($imageDir)) {
            return $cache;
        }

        foreach (File::files($imageDir) as $file) {
            $fileName = $file->getFilename();
            if (!Str::startsWith(Str::lower($fileName), 'cover-')) {
                continue;
            }

            $base = pathinfo($fileName, PATHINFO_FILENAME);
            $base = Str::replaceFirst('cover-', '', $base);
            $key = self::normalizeCoverKey($base);

            if ($key === '') {
                continue;
            }

            $cache[] = [
                'key' => $key,
                'path' => 'images/' . $fileName,
            ];
        }

        return $cache;
    }

    protected static function manualCoverAliases(): array
    {
        return [
            'laskar pelangi' => 'images/cover-laskarpelangi.jpg',
            'bumi manusia' => 'images/cover-tetralogibumi.jpg',
        ];
    }

    protected static function normalizeCoverKey(string $text): string
    {
        $text = Str::lower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/i', ' ', $text);
        $text = preg_replace('/\s+/', ' ', (string) $text);

        return trim((string) $text);
    }
}
