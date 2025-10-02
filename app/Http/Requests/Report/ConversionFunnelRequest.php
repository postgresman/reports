<?php

namespace App\Http\Requests\Report;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConversionFunnelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $admin = \auth()->user()->role->name === 'admin';

        return [
            'startDate' => ['required', 'date', 'before_or_equal:endDate'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
            'markets' => ['required', 'array'],
            'markets.*' => ['required', 'integer', $admin ? Rule::exists('markets', 'id') : Rule::in(\auth()->user()->markets->pluck('id'))],
        ];
    }
}
