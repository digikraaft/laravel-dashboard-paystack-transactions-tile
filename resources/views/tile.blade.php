<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="grid grid-rows-auto-1 gap-2 h-auto">
        @isset($title)
            <h1 class="font-bold">
                {{ $title }} <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @else
            <h1 class="font-bold">
                Paystack Transactions <span class="text-dimmed">({{$paginator->total()}})</span>
            </h1>
        @endisset
        <ul class="self-center divide-y-2 divide-canvas">
            @foreach($transactions as $transaction)
                <li class="py-1">
                    <div class="my-2">
                        <div class="font-bold">
                            Amount: {{ $transaction['currency'] }} {{ $transaction['amount'] }}
                        </div>
                        <div class="text-sm {{ ($transaction['status']=='success')? 'text-green-700' : 'text-red-700' }}">
                            Status: {{ $transaction['status'] }}
                        </div>
                        <div class="text-sm">
                            Reference: <a href="https://dashboard.paystack.com/#/transactions/{{ $transaction['id'] }}" target="_blank">
                                {{ $transaction['reference'] }}
                            </a>
                        </div>
                        <div class="text-sm text-dimmed">
                            Customer:
                            <a href="mailto:{{$transaction['customer']}}">
                                {{$transaction['customer']}}
                            </a>
                        </div>
                        <div class="text-sm text-dimmed">
                            Date: {{$transaction['createdAt']}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{$paginator}}
    </div>
</x-dashboard-tile>
