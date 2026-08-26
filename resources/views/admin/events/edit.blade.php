<x-layouts.admin>
    @section('page_title', 'Ubah Event: ' . $event->title)

    <!-- Embed EventForm Livewire Component with model binding -->
    @livewire('admin.event-form', ['event' => $event])
</x-layouts.admin>
