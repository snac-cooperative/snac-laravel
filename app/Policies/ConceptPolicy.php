<?php

namespace App\Policies;

use App\Models\Concept;
use App\Models\User;

class ConceptPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Concept $concept): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isVocabularyEditor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Concept $concept): bool
    {
        return $user->isVocabularyEditor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Concept $concept): bool
    {
        return $user->isVocabularyEditor();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Concept $concept): bool
    {
        return $user->isVocabularyEditor();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Concept $concept): bool
    {
        return $user->isVocabularyEditor();
    }
}
