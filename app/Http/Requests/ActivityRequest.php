<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
        $status = $this->input('status');
        if (! is_string($status) || $status === '') {
            if ($this->user()?->role === 'penulis') {
                $status = 'draft';
            } else {
                $status = $this->boolean('is_active') ? 'published' : 'draft';
            }
        }

        $this->merge([
            'status' => $status,
            'is_active' => $status === 'published',
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

        $allowedStatuses = $this->user()?->role === 'penulis'
            ? 'in:draft,review'
            : 'in:draft,review,published,archived';

        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => $imageRule,
            'status' => ['required', 'string', $allowedStatuses],
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
            'title' => 'Judul Kegiatan',
            'category' => 'Kategori Kegiatan',
            'location' => 'Lokasi Kegiatan',
            'event_date' => 'Tanggal Pelaksanaan',
            'description' => 'Deskripsi Kegiatan',
            'image' => 'Foto Dokumentasi',
            'is_active' => 'Status Publish',
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
            'title.required' => 'Judul kegiatan wajib diisi.',
            'category.required' => 'Kategori kegiatan wajib dipilih.',
            'description.required' => 'Deskripsi kegiatan wajib diisi.',
            'image.required' => 'Foto dokumentasi kegiatan wajib diunggah.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus berupa JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal adalah 4MB.',
        ];
    }
}
