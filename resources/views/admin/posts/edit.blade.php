<x-layouts.admin>
    @section('page_title', 'Ubah Artikel: ' . $post->title)

    <!-- Embed PostForm Livewire Component with model binding -->
    @livewire('admin.post-form', ['post' => $post])
</x-layouts.admin>
