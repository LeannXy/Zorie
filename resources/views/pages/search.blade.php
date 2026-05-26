<x-layouts.dashboard>

    <div class="space-y-8">

        <h1 class="text-2xl font-bold">

            Search Results:
            "{{ $search }}"

        </h1>


        <div>

            <h2 class="font-semibold">

                Products

            </h2>

            @foreach ($products as $item)
                <p>{{ $item->name }}</p>
            @endforeach

        </div>


        <div>

            <h2 class="font-semibold">

                Orders

            </h2>

            @foreach ($orders as $item)
                <p>

                    {{ $item->order_number }}

                </p>
            @endforeach

        </div>


        <div>

            <h2 class="font-semibold">

                Customers

            </h2>

            @foreach ($customers as $item)
                <p>

                    {{ $item->name }}

                </p>
            @endforeach

        </div>


        <div>

            <h2 class="font-semibold">

                Categories

            </h2>

            @foreach ($categories as $item)
                <p>

                    {{ $item->name }}

                </p>
            @endforeach

        </div>

    </div>

</x-layouts.dashboard>
