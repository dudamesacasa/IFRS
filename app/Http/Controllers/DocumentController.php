<?php

namespace App\Http\Controllers;


use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Relacionamentos;

use Illuminate\Support\Facades\Validator;
use PHPRtfLite\Rtf;
use PHPRtfLite\Standard\Font;
use PHPRtfLite\Standard\Paragraph;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $documents = Document::where('user_id', $userId)->get();

        if($request){
            $query = Document::query();
    
            if ($request->filled('title')) {
                $query->where('title', 'LIKE', '%' . $request->input('title') . '%')->where('user_id', $userId);
            }
            
            if ($request->filled('created_at')) {
                $query->where('created_at', '=', $request->input('created_at'))->where('user_id', $userId);
            }
            
    
            $documents = $query->get();
        } else {
            $documents = Document::where('user_id', $userId)->get();
        }

        
        return view('documents.index', compact('documents'));
    }

    public function list()
    {
        $userId = Auth::id();
        $documents = Document::where('user_id', $userId)->get();
        return view('documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,txt|max:2048',
            // 'description' => 'required',
        ]);
     
        if (!empty($request->input('description'))) {
           
            $rtf = new Rtf();           
            
            $description = $request->input('description');            
          
            $paragraph = new Paragraph($rtf);            
            
            $paragraph->setText($description);            
           
            $rtf->addParagraph($paragraph);
            
            $filePath = storage_path('app/public/documents/' . $request->input('title') . '.rtf');
            
            $rtf->save($filePath);

            $document = new Document();
            $document->title = $request->input('title');
            
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $extension;

                $file->storeAs('public/documents', $fileName);

                $document->file_path = 'documents/' . $fileName;
            }

            $document->save();                 
            
           
        } else {
            $user = Auth::user();
            $document = new Document();
            $document->title = $request->input('title');
            $document->user_id = $user->id;
            $document->user_name = $user->name;

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $file = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $extension;

                $file->storeAs('public/documents', $fileName);

                $document->file_path = 'documents/' . $fileName;
            }

            $document->save();
        }

        return redirect()->back()->with('success', 'Documento incluido com sucesso!');

    }

    public function create()
    {
        return view('documents.create');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $file_path = $document->file_path;
        $document->delete();
        Storage::delete('public/' . $file_path);
        return redirect()->route('documents')->with('success', $file_path);
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);

        $filePath = '' . $document->file_path;

        return response()->download(storage_path('app/public/' . $filePath), $document->title);
    }

    public function shareUsers(Document $document)
    {
        $users = User::all(); 
        
        return view('documents.share-users', compact('document', 'users'));
    }

    public function share(Request $request, Document $document)
    {
            
            $selectedUsers = $request->input('users'); // IDs dos usuários selecionados
            $usuarioPai = Auth::id();

            foreach ($selectedUsers as $usuarioFilho) {
                Relacionamentos::create([
                    'id_documento' => $document->id,
                    'usuario_pai' => $usuarioPai,
                    'usuario_filho' => $usuarioFilho,
                ]);
            }

        return redirect()->back()->with('success', 'Documento compartilhado com sucesso!');

    }

    public function edit(Request $request)
    {

    }
}
