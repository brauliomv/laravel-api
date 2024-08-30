<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentsController extends Controller
{
    public function index(){
        $students = Student::get();
        if($students->isEmpty()){
            $data = [
                'response' => 'No se han encontrado registros',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }

        $data = [
            'response' => $students,
            'status' => 200
        ];

        return response()->json($data['response'],200);
    }

    public function store(StoreStudentRequest $request){

        Student::create($request->all());

        return response()->json([
            'message' => 'Registro creado correctamente',
            'status' => 201
        ], 201);

    } 

    public function show($id){
        $student = Student::where('id',$id)->get();

        if($student->isEmpty()){
            $data = [
                'message' => 'No se ha encontrado la información, este registro no existe',
                'status' => 400
            ];

            return response()->json($data, 400);
        }


        $data = [
            'message' => 'Mostrando datos',
            'response' => $student,
            'status' => 200
        ];

        return response()->json($data,200);
    }

    public function update(UpdateStudentRequest $request, $id){
        $student = Student::find($id);//Busca al estudiante

        if($student === null){
            $data = [
                'message' => 'No se ha encontrado la información',
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $student->update($request->all());
        $data = [
            'message' => 'Datos actualizados correctamente',
            'response' => $student,
            'status' => 200,
        ];

        return response()->json($data, 200);
    }

    public function destroy($id){
        $student = Student::find($id);

        if($student === null){
            $data = [
                'message' => 'Este registro no existe',
                'status' => 400,
            ];

            return response()->json($data, 400);
        }

        $student->delete();

        $data = [
            'message' => 'Registro eliminado correctamente',
            'status' => 200
        ];

        return response()->json($data,200);
    }
}
