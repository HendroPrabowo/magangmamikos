<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        $user_role = $user->role;
        $role = null;
        $premium = null;

        if($user_role == 1) $role = 'Pemilik Kos';
        elseif ($user_role == 2) $role = 'Anak Kos';
        else $role = 'Admin';

        if($user->is_premium == 0) $premium = 'No';
        else $premium = 'Yes';

        return [
            'id'        => $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
            'role'      => $role,
            'credit'    => $user->credit,
            'is_premium'    => $premium,
            'api_token'     => $user->api_token,
            'registered'    => $user->created_at->diffForHumans(),
        ];
    }
}
