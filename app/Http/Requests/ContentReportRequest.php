<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $allowedStatuses = $this->user()?->role === 'penulis'
            ? ['all', 'draft', 'review', 'published', 'archived']
            : ['all', 'review', 'published', 'archived'];

        return [
            'start_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'end_date' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'type' => ['nullable', 'string', Rule::in(['all', 'activity', 'berita'])],
            'status' => ['nullable', 'string', Rule::in($allowedStatuses)],
        ];
    }

    /**
     * Return normalized filter values.
     *
     * @return array{start_date: string|null, end_date: string|null, type: string, status: string}
     */
    public function filters(): array
    {
        $validated = $this->validated();

        return [
            'start_date' => isset($validated['start_date']) && $validated['start_date'] !== '' ? (string) $validated['start_date'] : null,
            'end_date' => isset($validated['end_date']) && $validated['end_date'] !== '' ? (string) $validated['end_date'] : null,
            'type' => isset($validated['type']) && $validated['type'] !== '' ? (string) $validated['type'] : 'all',
            'status' => isset($validated['status']) && $validated['status'] !== '' ? (string) $validated['status'] : 'all',
        ];
    }

    /**
     * Get custom validation messages in Indonesian.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date.date' => 'Tanggal mulai tidak valid.',
            'start_date.date_format' => 'Format tanggal mulai harus YYYY-MM-DD.',
            'end_date.date' => 'Tanggal akhir tidak valid.',
            'end_date.date_format' => 'Format tanggal akhir harus YYYY-MM-DD.',
            'end_date.after_or_equal' => 'Tanggal akhir harus sama atau setelah tanggal mulai.',
            'type.in' => 'Jenis konten laporan tidak valid.',
            'status.in' => 'Filter status tidak tersedia untuk peran Anda.',
        ];
    }
}
