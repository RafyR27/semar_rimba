<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationProfileRequest extends FormRequest
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
        $nullable = ['email', 'telepon', 'whatsapp', 'instagram_url', 'tiktok_url', 'google_maps_url'];

        $merged = [];

        foreach ($nullable as $field) {
            $value = $this->input($field);

            if (! is_string($value)) {
                $value = '';
            }

            if (trim($value) === '') {
                $merged[$field] = null;
            }
        }

        if ($merged !== []) {
            $this->merge($merged);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'nama_organisasi' => ['required', 'string', 'max:255'],
            'deskripsi_singkat' => ['required', 'string', 'max:1000'],
            'sejarah' => ['required', 'string', 'max:5000'],
            'visi' => ['required', 'string', 'max:2000'],
            'misi' => ['required', 'string', 'max:5000'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'google_maps_url' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
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
            'nama_organisasi' => 'Nama Organisasi',
            'deskripsi_singkat' => 'Deskripsi Singkat',
            'sejarah' => 'Sejarah Organisasi',
            'visi' => 'Visi',
            'misi' => 'Misi',
            'alamat' => 'Alamat Sekretariat',
            'email' => 'Email',
            'telepon' => 'Nomor Telepon',
            'whatsapp' => 'Nomor WhatsApp',
            'instagram_url' => 'URL Instagram',
            'tiktok_url' => 'URL TikTok',
            'google_maps_url' => 'URL Google Maps',
            'logo' => 'Logo Organisasi',
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
            'nama_organisasi.required' => 'Nama organisasi wajib diisi.',
            'deskripsi_singkat.required' => 'Deskripsi singkat organisasi wajib diisi.',
            'sejarah.required' => 'Sejarah organisasi wajib diisi.',
            'visi.required' => 'Visi organisasi wajib diisi.',
            'misi.required' => 'Misi organisasi wajib diisi.',
            'alamat.required' => 'Alamat sekretariat wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'instagram_url.url' => 'URL Instagram harus berupa tautan yang valid.',
            'tiktok_url.url' => 'URL TikTok harus berupa tautan yang valid.',
            'google_maps_url.url' => 'URL Google Maps harus berupa tautan yang valid.',
            'logo.image' => 'File yang diunggah harus berupa gambar.',
            'logo.mimes' => 'Format logo harus berupa JPG, JPEG, PNG, atau WEBP.',
            'logo.max' => 'Ukuran logo maksimal adalah 4MB.',
        ];
    }
}
