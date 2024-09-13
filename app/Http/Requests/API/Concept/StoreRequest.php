<?php

namespace App\Http\Requests\API\Concept;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'preferred_term' => 'required:string',
            'category_id' => 'required',
            'alternate_terms' => 'array',
            'alternate_terms.*' => 'string',
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        // Get validated data
        $validated = $this->validated();

        // Build the terms array with the alternate terms
        $terms = collect($validated['alternate_terms'] ?? [])
            ->map(function ($term) {
                return [
                    'text' => $term,
                    'preferred' => false,
                ];
            })
            ->toArray();

        // Add the preferred term to the terms array
        $terms[] = [
            'text' => $validated['preferred_term'],
            'preferred' => true,
        ];

        // Add the newly structured terms array
        $this->merge([
            'terms' => $terms,
        ]);

        // Remove preferred term and alternate_terms
        unset($this['preferred_term']);
        unset($this['alternate_terms']);
    }
}
