<?php

namespace App\Policies;

use App\Models\ShoppingCartItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShoppingCartItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ShoppingCartItem $shoppingCartItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShoppingCartItem $shoppingCartItem): bool
    {
        return $user->id === $shoppingCartItem->shoppingCart->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShoppingCartItem $shoppingCartItem): bool
    {
        return $user->id === $shoppingCartItem->shoppingCart->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShoppingCartItem $shoppingCartItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShoppingCartItem $shoppingCartItem): bool
    {
        return false;
    }
}
