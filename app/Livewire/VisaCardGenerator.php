<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VisaCardGenerator extends Component
{
    public $cardNumber;

    public function mount()
    {
        $this->generate();
    }

    public function generate()
    {
        $number = '4';
        for ($i = 0; $i < 14; $i++) {
            $number .= mt_rand(0, 9);
        }
        $number .= $this->calculateLuhnCheckDigit($number);
        $this->cardNumber = $this->formatCardNumber($number);
    }

    private function calculateLuhnCheckDigit($number)
    {
        $sum = 0;
        $numDigits = strlen($number);
        $parity = $numDigits % 2;

        for ($i = 0; $i < $numDigits; $i++) {
            $digit = (int) $number[$i];
            if ($i % 2 === $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            $sum += $digit;
        }

        return (10 - ($sum % 10)) % 10;
    }

    private function formatCardNumber($number)
    {
        return trim(chunk_split($number, 4, ' '));
    }

    public function render()
    {
        return view('livewire.visa-card-generator');
    }
}
