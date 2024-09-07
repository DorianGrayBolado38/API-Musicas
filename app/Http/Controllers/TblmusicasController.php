<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\tblmusicas;


class TblmusicasController extends Controller
{
    //construir o crud.
    
    //Mostrar todos os registros da tabela livros
    //Crud -> Read(leitura) Select/Visualizar

    public function index()
    {
        $regBook = tblmusicas::all();
        $contador = $regBook->count();
    
        return response()->json([
            'musicas' => $regBook,
            'count' => $contador
        ]);
    }
    
    //Mostrar um tipo de registro especifico
    //Crud -> Read(leitura) Select/Visualizar
    //A função show busca a id e retorna se o livros foram localizados por id.

    public function show(string $id)
    {
        $regBook = tblmusicas::find($id);
    
        if ($regBook) {
            return response()->json($regBook);
        } else {
            return response()->json(['message' => 'Música não localizada.'], Response::HTTP_NOT_FOUND);
        }
    }
    

    //Cadastrar registros
    //Crud -> Create(criar/cadastrar)
    public function store(Request $request)
    {
        $regBook = $request->all();
    
        $validator = Validator::make($regBook, [
            'nomeMusica' => 'required|string|max:255',
            'generoMusica' => 'required|string|max:100',
            'albumMusica' => 'required|string|max:255', // Corrigido para string
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
    
        $regBookCad = tblmusicas::create($regBook);
    
        return response()->json($regBookCad, Response::HTTP_CREATED);
    }
    

    //Alterar registros
    //Crud -> update(alterar)
    public function update(Request $request, string $id)
{
    $regBook = $request->all();

    $validator = Validator::make($regBook, [
        'nomeMusica' => 'required|string|max:255',
        'generoMusica' => 'required|string|max:100',
        'albumMusica' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
    }

    $regBookBanco = tblmusicas::find($id);

    if (!$regBookBanco) {
        return response()->json(['message' => 'Música não encontrada.'], Response::HTTP_NOT_FOUND);
    }

    $regBookBanco->update($regBook);

    return response()->json($regBookBanco, Response::HTTP_OK);
}


    //Deletar os registros
    //Crud -> delete(apagar)
    public function destroy(string $id)
    {
        $regBook = tblmusicas::find($id);
    
        if (!$regBook) {
            return response()->json(['message' => 'Música não encontrada.'], Response::HTTP_NOT_FOUND);
        }
    
        $regBook->delete();
    
        return response()->json(['message' => 'Música deletada com sucesso.'], Response::HTTP_NO_CONTENT);
    }
    

    //Crud
    //C reate
    //r ead
    //u pdate
    //d elete

}
