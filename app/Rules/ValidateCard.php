<?php

namespace App\Rules;

use App\CardGame;
use Illuminate\Contracts\Validation\Rule;

class ValidateCard implements Rule
{
    private $deckOfCards;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(CardGame $cardGame)
    {
        $this->deckOfCards = $cardGame->getDeckOfCards();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value as $card) {
            if (!in_array($card, $this->deckOfCards)) return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'One or more of your entered card is Invalid, Valid cards are: 2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A';
    }
}
