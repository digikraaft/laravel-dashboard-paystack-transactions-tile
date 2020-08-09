<?php

namespace Digikraaft\PaystackTransactionsTile;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class PaystackTransactionsTileComponent extends Component
{
    use WithPagination;

    /** @var string */
    public string $position;

    /** @var string|null */
    public ?string $title;

    public $perPage;

    /** @var int|null */
    public ?int $refreshInSeconds;

    public function mount(string $position, $perPage = 5, ?string $title = null, int $refreshInSeconds = null)
    {
        $this->position = $position;
        $this->perPage = $perPage;
        $this->title = $title;
        $this->refreshInSeconds = $refreshInSeconds;
    }

    public function render()
    {
        $transactions = collect(PaystackTransactionsStore::make()->getData());
        $paginator = $this->getPaginator($transactions);

        return view('dashboard-paystack-transactions-tile::tile', [
            'transactions' => $transactions->skip(($paginator->firstItem() ?? 1) - 1)->take($paginator->perPage()),
            'paginator' => $paginator,
            'refreshIntervalInSeconds' => $this->refreshInSeconds ?? config('dashboard.tiles.paystack.transactions.refresh_interval_in_seconds') ?? 1800,
        ]);
    }

    public function getPaginator(Collection $transactions): LengthAwarePaginator
    {
        return new LengthAwarePaginator($transactions, $transactions->count(), $this->perPage, $this->page);
    }

    public function paginationView()
    {
        return 'dashboard-paystack-transactions-tile::pagination';
    }
}
