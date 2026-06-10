<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // List of allowed university domains
        $allowedDomains = ['ju.edu.et', 'uonbi.ac.ke', 'aau.edu.et', 'mu.edu.et'];
        $domainPattern = implode('|', array_map('preg_quote', $allowedDomains));

        return [
            'name' => ['required', 'string', 'max:255'],
            'student_id' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@('.$domainPattern.')$/',
            ],
            'department' => ['required', 'string', 'max:100'],
            'graduation_year' => ['required', 'integer', 'min:'.date('Y'), 'max:'.(date('Y') + 6)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Only university email addresses are allowed (.edu.et or .ac.ke domains)',
            'student_id.unique' => 'This student ID is already registered',
            'graduation_year.min' => 'Graduation year must be current or future year',
        ];
    }
}
