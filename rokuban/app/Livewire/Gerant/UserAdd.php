<?php

namespace App\Livewire\Gerant;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserAdd extends Component
{

    //All important information gerant can choose to add
    public $name, $email, $password, $first_name, $last_name, $address_line_1, $address_line_2, $postal_code, $city;
    //We don't want gerant to add another gerant so no role management when creating a new user

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255', 
            'email' => 'required|email|max:255|unique:users,email', 
            'password' => 'required|string|min:8|max:255',
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'address_line_1' => 'required|string|min:2|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'postal_code' => 'required|integer|min:1000|max:9992',
            'city' => 'required|string|min:2|max:255',
        ];
    }

    //Personnal error messages :
    protected $messages = 
    [
        'name.required' => 'Le pseudo est requis.',
        'name.max' => 'Le pseudo peut faire maximum 255 caractères',
        'email.required' => 'L\'email est requis.',
        'email.unique' => 'Ce mail est déjà utilisé dans notre base de données',
        'email.max' => 'L\'email ne peut pas dépasser 255 caractères.',
        'password.required' => 'Le mot de passe est requis.',
        'password.min' => 'Le mot de passe doit au moins faire 8 caractères',
        'password.max' => 'Le mot de passe ne peut pas dépasser 255 caractères.',
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
        'city.min' => 'Le nom de la ville doit au moins contenir 2 caractères.',
        'city.max' => 'Le nom de la ville peut contenir maximum 255 caractères',
    ];

    public function addUser()
    {
        $this->validate();

        User::create([
                'name' => $this->name,
                'email' => $this->email,
                'email_verified_at' => \Carbon\Carbon::now(),
                'password' => bcrypt($this->password),
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'postal_code' => $this->postal_code,
                'city' => $this->city,
                'role_id' => 2,
                'isActive' => 1,
        ]);

        session()->flash('message', 'Utilisateur créé avec succès.');
        return redirect()->route('gerantdashboard');
    }


    public function render()
    {
        return view('livewire.gerant.user-add')->layout('layouts.app');
    }
}
