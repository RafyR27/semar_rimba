<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BeritaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug((string) ($this->input('slug') ?: $this->input('judul'))),
            'is_published' => $this->boolean('is_published'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $thumbnailRule = $this->isMethod('POST')
            ? ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096']
            : ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'];

        return [
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'konten' => ['required', 'string'],
            'thumbnail' => $thumbnailRule,
            'tanggal_terbit' => ['nullable', 'date'],
            'is_published' => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'judul' => 'Judul Berita',
            'slug' => 'Slug',
            'konten' => 'Isi Berita',
            'thumbnail' => 'Gambar Berita',
            'tanggal_terbit' => 'Tanggal Publikasi',
            'is_published' => 'Status Publikasi',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'judul.required' => 'Judul berita wajib diisi.',
            'konten.required' => 'Isi berita wajib diisi.',
            'thumbnail.required' => 'Gambar berita wajib diunggah.',
            'thumbnail.image' => 'File yang diunggah harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar harus berupa JPG, JPEG, PNG, atau WEBP.',
            'thumbnail.max' => 'Ukuran gambar maksimal adalah 4MB.',
        ];
    }
}
