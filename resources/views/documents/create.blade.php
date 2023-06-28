<!-- resources/views/documents/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Documento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">Nome do Documento</label>
                            <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">Descrição</label>
                            <textarea name="description" id="description" class="form-input rounded-md shadow-sm"></textarea>
                            <!-- <input class="form-input rounded-md shadow-sm" name="description" id="description" value=""> -->
                        </div>

                        <div class="mb-4">
                            <label for="file" class="block font-medium text-sm text-gray-700">Arquivo</label>
                            <input type="file" name="file" id="file" accept=".pdf,.doc,.docx" class="form-input rounded-md shadow-sm">
                        </div>

                        <div>                            
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-black rounded-md border border-gray-800">Salvar</button>
                        </div>
                    </form>

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
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow'
        });

        quill.on('text-change', function() {
            var description = document.querySelector('#description');
            var delta = quill.getContents();
            description.value = JSON.stringify(delta);
        });
    </script>

</x-app-layout>
