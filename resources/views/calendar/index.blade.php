<x-layouts.main title="Skagesundvegen 63 - Kalender">
    <main class="max-w-3xl m-auto mt-5">


        @auth

            <x-ui.primary-box class="new-event">

                <x-calendar.new-event />

            </x-ui.primary-box>

        @endauth


        <div class="all-events flex flex-col gap-5">

            @foreach ($events as $event)

                <x-ui.primary-box class="single-event">

                    <x-calendar.standard-event :$event :$users />

                </x-ui.primary-box>

            @endforeach

        </div>



    </main>
</x-layouts.main>
