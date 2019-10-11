<?php


class Blackjack
{
    private const EMPTY_HAND = 0;
    private const MIN_VALUE = 1;
    private const MAX_VALUE = 11;
    private const BLACKJACK = 21;
    private const DEALER_STAND = 16;
    private $score;
    private $isMyTurn;

    public function __construct($score, $isMyTurn)
    {
        $this->score = $score;
        $this->isMyTurn = $isMyTurn;
    }

    public function getScore(): int
    {
        return $this->score;
    }
    public function setScore($score): void
    {
        $this->score = $score;
    }
    public function getIsMyTurn(): bool
    {
        return $this->isMyTurn;
    }
    public function setIsMyTurn($isMyTurn): void
    {
        $this->isMyTurn = $isMyTurn;
    }


    public function hit(): void
    {
        if ($this->isMyTurn && $this->score < self::BLACKJACK){
            $card = random_int(self::MIN_VALUE, self::MAX_VALUE);
            $this->score += $card;
        }

        if ($this-> score > self::BLACKJACK) {
            $this->isMyTurn = false;
        } elseif ($this -> score == self::BLACKJACK){
            $this->isMyTurn = false;
            //$_POST["stand"] = "stand";
            //$_SERVER["PHP_SELF"];
        }
    }

    public function stand()
    {
        if ($this->isMyTurn) {
            $this->isMyTurn = false;
        }
    }

    public function surrender()
    {
        if ($this->isMyTurn) {
            $this->isMyTurn = false;
        }
    }

}