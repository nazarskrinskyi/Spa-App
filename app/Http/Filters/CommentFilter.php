<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CommentFilter extends AbstractFilter
{
    public const USERNAME = 'username';

    public const EMAIL = 'email';
    public const CREATED_AT = 'created_at';

    protected function getCallbacks(): array
    {
        return [
            self::USERNAME => [$this, 'username'],
            self::EMAIL => [$this, 'email'],
            self::CREATED_AT => [$this, 'created_at'],
        ];
    }

    public function username(Builder $builder, $value): void
    {
        // Реализуйте фильтрацию по полю 'User Name' (username) по алфавиту
        $builder->orderBy('username', $value);
    }

    public function created_at(Builder $builder, $value): void
    {
        // Реализуйте фильтрацию по полю 'Дата добавления' (created_at) по алфавиту
        $builder->orderBy('created_at', $value);
    }

    public function email(Builder $builder, $value): void
    {
        // Реализуйте фильтрацию по полю 'E-mail' (email) по алфавиту
        $builder->orderBy('email', $value);
    }



}
