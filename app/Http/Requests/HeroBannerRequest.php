<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroBannerRequest extends FormRequest
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
            'is_active' => $this->boolean('is_active'),
            'order' => $this->filled('order') ? (int) $this->input('order') : 0,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        $imageRule = $this->isMethod('POST')
            ? ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096']
            : ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => $imageRule,
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
            'order' => ['required', 'integer', 'min:0', 'max:9999'],
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
            'title' => 'Judul Banner',
            'subtitle' => 'Subjudul',
            'description' => 'Deskripsi',
            'image' => 'Gambar Banner',
            'button_text' => 'Teks Tombol',
            'button_url' => 'URL Tombol',
            'is_active' => 'Status Aktif',
            'order' => 'Urutan Tampil',
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
            'title.required' => 'Judul banner wajib diisi.',
            'image.required' => 'Gambar banner wajib diunggah.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus berupa JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal adalah 4MB.',
        ];
    }
}
