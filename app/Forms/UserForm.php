<?php

namespace App\Forms;

use App\Models\User;

class UserForm extends AbstractForm
{
    private const SUBSCRIBER_ROLE_ID = 2;

    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', 'Имя',
                [
                    'validationRule' => 'required',
                ]);

        $this->formBuilder
            ->add('email', 'email', 'Электронная почта',
                [
                    'validationRule' => 'required|email',
                ]
            );

        $this->formBuilder
            ->add('password', 'password', 'Пароль',
                [
                    'validationRule' => 'required|min:6',
                ]
            );

        $this->formBuilder
            ->add('select', 'role', 'Роль',
                [
                    'options' => $this->getUserRoles(),
                    'validationRule' => 'required',
                ]);
    }

    private function getUserRoles()
    {
        // Todo implement getUserRoles method
        return [];
    }

    public function fill(User $user)
    {
        // Todo implement fill method
        return $this;
    }
}
