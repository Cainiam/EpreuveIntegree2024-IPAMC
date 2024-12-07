<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserEdit extends Component
{
    public $userId, $name, $email, $first_name, $last_name, $address_line_1, $address_line_2, $postal_code, $city, $isActive;

    //Loading User by his ID
    public function mount($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->address_line_1 = $user->address_line_1;
        $this->address_line_2 = $user->address_line_2;
        $this->postal_code = $user->postal_code;
        $this->city = $user->city;
        $this->isActive = $user->isActive;
    }

    //Editing rules :
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255', 
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->userId)], 
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'postal_code' => 'required|integer|min:1000|max:9992',
            'city' => 'required|string|max:255',
            'isActive' => 'required',
        ];
    }

    //Personnal error messages :
    protected $messages = 
    [
        'name.required' => 'Le pseudo est requis.',
        'name.max' => 'Le pseudo ne peut dépasser 255 caractères',
        'email.required' => 'L\'email est requis.',
        'email.unique' => 'Ce mail est déjà utilisé dans notre base de données',
        'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
        'first_name.required' => 'Le prénom est requis.',
        'first_name.min' => 'Le prénom doit faire au moins 2 caractères.',
        'first_name.max' => 'Le prénom doit faire au maximum 255 caractères.',
        'last_name.required' => 'Le nom est requis.',
        'last_name.min' => 'Le nom doit faire au moins 2 caractères.',
        'last_name.max' => 'Le nom doit faire au maximum 255 caractères.',
        'address_line_1.required' => 'L\'addresse est requise.',
        'address_line_1.min' => 'L\'addresse doit faire au moins 2 caractères.',
        'address_line_1.max' => 'L\'addresse doit faire au maximum 255 caractères.',
        'address_line_2.max' => 'L\'addresse doit faire au maximum 255 caractères.',
        'postal_code.required' => 'Le code postal est requis.',
        'postal_code.integer' => 'Le code postal doit être écrit en chiffre entier.',
        'postal_code.min' => 'Le code postal ne peut être inférieur à 1000.',
        'postal_code.max' => 'Le code postal ne peut être supérieur à 9992.',
        'city.required' => 'Le nom de la ville est requis',
        'city.max' => 'Le nom de la ville peut contenir maximum 255 caractères',
    ];

    public function updateUser()
    {
        $this->validate();

        $user = User::findOrFail($this->userId);
        $user->update(
            [
                'name' => $this->name,
                'email' => $this->email,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'postal_code' => $this->postal_code,
                'city' => $this->city,
            ]
        );

        session()->flash('message', 'Utilisateur mis à jour.');

        return redirect()->route('gerantdashboard');
    }

    public function render()
    {
        return view('livewire.gerant.user-edit')->layout('layouts.app');
    }
}
