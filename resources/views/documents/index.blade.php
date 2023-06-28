<!-- resources/views/documents/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciador de Documentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        
                        <form action="{{ route('documents') }}" method="GET">
                            <div>
                                <div class="flex items-center">                            
                                    <input type="text" name="search" name="title" id="title" value="{{ request('title') }}" class="mr-2 rounded-md border-gray-300" placeholder="Pesquisar...">
                                    <input type="date" name="created_at" id="created_at" value="{{ request('created_at') }} class="mr-2 rounded-md border-gray-300" placeholder="Pesquisar...">
                                    
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Buscar</button>
                                    
                                </div>  
                            </div>

                            <!-- @if(!empty($documents)) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <!-- @foreach($documents as $document) -->
                                        <div class="p-4 bg-gray-100 rounded-md document-item">
                                            <h3 class="text-lg font-semibold mb-2">{{ $document->title }}</h3>
                                            <h3 class="text-lg font-semibold mb-2">{{ $document->file_path }}</h3>

                                            <a href="{{ route('documents.download', $document->id) }}" class="text-blue-500">Download</a>
                            
                                            <form action="{{ route('documents.share-users', $document->id) }}" method="POST" class="inline">
                                                @csrf
                                                <!-- <button type="submit" class="text-blue-500">Compartilhar</button> -->
                                            <a href="{{ route('documents.share-users', $document->id) }}" class="text-blue-500">Compartilhar</a>

                                            </form>
                                            <form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Tem certeza de que deseja excluir este documento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500">Excluir</button>
                                            </form>
                                        </div>
                                    <!-- @endforeach -->
                                </div>
                            <!-- @else
                                <p class="text-gray-600">Nenhum documento encontrado.</p>
                            @endif -->
                        </form>
                    </div>                    

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Obtém o elemento de entrada de texto de pesquisa
    const searchInput = document.getElementById('search-input');

    // Adiciona um ouvinte de evento de digitação no campo de pesquisa
    searchInput.addEventListener('input', function() {
        const searchQuery = searchInput.value.toLowerCase();
        const documentElements = document.getElementsByClassName('document-item');

        // Itera sobre os elementos dos documentos e mostra/oculta com base no texto da pesquisa
        for (let i = 0; i < documentElements.length; i++) {
            const documentElement = documentElements[i];
            const documentTitle = documentElement.getAttribute('data-title').toLowerCase();
            const documentFilePath = documentElement.getAttribute('data-file-path').toLowerCase();
            
            // Verifica se o título ou o caminho do arquivo contêm o texto da pesquisa
            if (documentTitle.includes(searchQuery) || documentFilePath.includes(searchQuery)) {
                documentElement.style.display = 'block';  // Exibe o elemento
            } else {
                documentElement.style.display = 'none';   // Oculta o elemento
            }
        }
    });
</script>

