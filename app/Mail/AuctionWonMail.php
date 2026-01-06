<?php

namespace App\Mail;

use App\Models\AuctionItem;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AuctionWonMail extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;
    public $transaction;

    public function __construct(AuctionItem $auction, Transaction $transaction)
    {
        $this->auction = $auction;
        $this->transaction = $transaction;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Selamat! Anda Memenangkan Lelang - ' . $this->auction->title,
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.auction-won',
        );
    }

    public function attachments()
    {
        return [];
    }
}