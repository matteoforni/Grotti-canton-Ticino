<?php


class InputManager
{
    /**
     * Funzione che rimuove da una stringa tutti i caratteri che potrebbero essere malevoli.
     * @param $input L'input da pulire.
     * @return string L'input pulito.
     */
    public function checkInput($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);

        return $input;
    }
}