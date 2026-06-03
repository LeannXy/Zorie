<x-layouts.dashboard>

    <div class="space-y-8">

        <h1 class="text-2xl font-bold">

            Hasil Pencarian:
            "{{ $search }}"

        </h1>


        <div>

            <h2 class="font-semibold">

                Produk

            </h2>

            @foreach ($products as $item)
                <p>{{ $item->name }}</p>
            @endforeach

        </div>


        <div>

            <h2 class="font-semibold">

                Pesanan

            </h2>

            @foreach ($orders as $item)
                <p>

                    {{ $item->order_number }}

                </p>
            @endforeach

        </div>


        <div>

            <h2 class="font-semibold">

                Pelanggan

            </h2>

            @foreach ($customers as $item)
                <p>

                    {{ $item->name }}

                </p>
            @endforeach

        </div>


        <div>

            <h2 class="font-semibold">

                Kategori

            </h2>

            @foreach ($categories as $item)
                <p>

                    {{ $item->name }}

                </p>
            @endforeach

        </div>

    </div>

</x-layouts.dashboard>
