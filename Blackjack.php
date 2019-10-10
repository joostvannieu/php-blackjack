<?php


class Blackjack
{
    private const EMPTY_HAND = 0;
    private const MIN_VALUE = 1;
    private const MAX_VALUE = 11;
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
        if ($this->isMyTurn){
            $card = random_int(self::MIN_VALUE, self::MAX_VALUE);
            $this->score += $card;
        }
    }

    public function stand()
    {
        $this->isMyTurn = false;
    }

    public function surrender()
    {
        $this->isMyTurn=false;
        $this->score = self::EMPTY_HAND;
    }

}