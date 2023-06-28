
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selecionar Usuários para Compartilhamento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Documento: {{ $document->title }}</h3>
                    <h3 class="text-lg font-semibold mb-2">Caminho do arquivo: {{ $document->file_path }}</h3>

                    <form action="{{ route('documents.share', $document->id) }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($users as $user)
                                <label for="user_{{ $user->id }}" class="flex items-center">
                                    <input type="checkbox" id="user_{{ $user->id }}" name="users[]" value="{{ $user->id }}" class="mr-2">
                                    {{ $user->name }}
                                </label>
                            @endforeach
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md mt-4">Compartilhar</button>
                    </form>
                </div>
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
