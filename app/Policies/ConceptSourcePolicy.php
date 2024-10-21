<?php

namespace App\Policies;

use App\Models\ConceptSource;
use App\Models\User;

class ConceptSourcePolicy
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
    public function view(?User $user, ConceptSource $conceptSource): bool
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
    public function update(User $user, ConceptSource $conceptSource): bool
    {
        return $user->isVocabularyEditor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ConceptSource $conceptSource): bool
    {
        return $user->isVocabularyEditor();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ConceptSource $conceptSource): bool
    {
        return $user->isVocabularyEditor();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ConceptSource $conceptSource): bool
    {
        return $user->isVocabularyEditor();
    }
}
