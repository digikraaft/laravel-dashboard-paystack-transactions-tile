<?php

namespace Digikraaft\PaystackTransactionsTile;

use Digikraaft\Paystack\Paystack;
use Digikraaft\Paystack\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchTransactionsDataFromPaystackApi extends Command
{
    protected $signature = 'dashboard:fetch-transactions-data-from-paystack-api';

    protected $description = 'Fetch data for paystack transactions tile';

    public function handle()
    {
        Paystack::setApiKey(config('dashboard.tiles.paystack.secret_key', env('PAYSTACK_SECRET')));

        $this->info('Fetching Paystack transactions ...');

        $transactions = Transaction::list(
            config('dashboard.tiles.paystack.transactions.params') ?? [
                'perPage' => 5,
            ]
        );

        $transactions = collect($transactions->data)
            ->map(function ($transaction) {
                return [
                    'amount' => $this->formatMoney($transaction->amount),
                    'currency' => $transaction->currency,
                    'reference' => $transaction->reference,
                    'status' => $transaction->status,
                    'customer' => $transaction->customer->email,
                    'id' => $transaction->id,
                    'createdAt' => Carbon::parse($transaction->created_at)
                        ->setTimezone('UTC')
                        ->format("d.m.Y"),
                ];
            })->toArray();

        PaystackTransactionsStore::make()->setData($transactions);

        $this->info('All done!');

        return 0;
    }

    /**
     * @param string $amount
     * @return float
     */
    public function formatMoney(string $amount): string
    {
        return number_format(($amount), 2, '.', ',');
    }
}
