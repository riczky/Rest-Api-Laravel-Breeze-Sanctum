<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;


class FormController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);

        // dd($request->all());
        $student = new Student;

        $student->nama = $request->nama;
        $student->alamat = $request->alamat;
        $student->no_telp = $request->no_telp;

        $student->save();


        return response()->json([
            'message' => 'Data Student Berhasil Ditambahkan',
            'data_student' => $student
        ], 200);
    }


    public function edit($id)
    {
        $student = Student::find($id);
        // dd($student);

        return response()->json([
            'message' => 'Sukses',
            'data_student' => $student
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required'
        ]);

        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp
        ]);

        return response()->json([
            'message' => 'Data Berhasil di Update',
            'data_student' => $student
        ], 200);
    }

    // Delete
    public function delete($id)
    {
        $student = Student::find($id)->delete();
        // dd($student);
        return response()->json([
            'message' => 'Data Berhasil di Hapus',
            'data_student' => $student
        ], 200);
    }

    // Get All Data Students
    // public function show()
    // {
    //     $student = Student::get();
    //     return response()->json([
    //         'message' => 'Data Berhasil di Tampilkan',
    //         'data_student' => $student
    //     ], 200);
    // }


    // Pagination
    public function show(Request $request)
    {
        $per_page = $request->get('per_page');

        $students = Student::paginate($per_page);

        // $collectionStudent = StudentResource::collection($students);
        foreach ($students as $key => $student) {
            $data['id'] = $student->id;
            $data['nama'] = $student->nama;
            $data['alamat'] = $student->alamat;
            $data['no_telp'] = $student->no_telp;
            $datas[]        = $data;
        }

        $dataStudent['data'] = $datas;
        // $dataStudent['data'] = $collectionStudent;
        $dataStudent['next_page_url'] = $students->nextPageUrl();

        return response()->json([
            'message' => 'Data Berhasil di Tampilkan',
            'data_student' => $dataStudent
            // 'data_student' => $collectionStudent

        ], 200);
    }
}
