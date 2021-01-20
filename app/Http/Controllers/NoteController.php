<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    private $array = ['error' => '', 'result' => []];

    public function all(){

        //recuperando todas as notas do banco de dados
        $notes = Note::all();

        //preenchendo array
        foreach ($notes as $note){

            $this->array['result'][] = [
                'id'    => $note->id,
                'title' => $note->title
            ];
        }

        return $this->array;
    }

    public function one($id)
    {
        //buscando a nota por id
        $note = Note::find($id);
//        $note = Note::where('id', $id)->first(); //Recupera a nota do banco e pega a primeira ocorrência

        if($note){

            //adiciona nota ao array
            $this->array['result'] = $note;
        }
        else{

            $this->array['error'] = "ID não encontrado";
        }

        return $this->array;
    }

    public function new(Request $request)
    {
        //recuperando o titulo
        $title = $request->input('title');
        $body = $request->input('body');

        if($title && $body){

            //criando uma nova nota, populando e inserindo no banco
            $note = new Note();
            $note->title = $title;
            $note->body = $body;
            $note->save();

            $this->array['result'] = [

                'id' => $note->id,
                'title' => $note->title,
                'body' => $note->body

            ];

        }
        else{

            $this->array['error'] = "Erro ao cadastrar nota";
        }

        return $this->array;
    }

    public function edit(Request $request, $id)
    {

        $title = $request->input('title');
        $body = $request->input('body');

        if($id && $title && $body){

            $note = Note::find($id);

            if($note){

                //atualiza e salva a nota
                $note->title = $title;
                $note->body = $body;
                $note->save();

                $this->array['result'] = [

                    'id' => $note->id,
                    'title' => $note->title,
                    'body' => $note->body
                ];

            }
            else{

                $this->array['error'] = "A nota não existe";
            }
        }
        else{

            $this->array['error'] = "Erro ao alterar nota";
        }

        return $this->array;

    }

    public function delete($id)
    {

        $note = Note::find($id);

        if($note){

            $note->delete();
        }
        else{

            $this->array['error'] = "Nota não encontrada";
        }

        return $this->array;
    }

}
