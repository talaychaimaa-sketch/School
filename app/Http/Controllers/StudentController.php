<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        return view('index', compact('students'));
    }
    public function create()
{
    return view('create');
}
public function store(Request $request)
{
    $validateData = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|max:255',
        'phone' => 'required',
        'section' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg',
    ]);

    $image = $request->file('image');

    $destinationPath = 'image/';

    $profileImage = date('YmdHis').".".$image->getClientOriginalExtension();

    $image->move($destinationPath, $profileImage);

    $validateData['image'] = $profileImage;

    $students = Student::create($validateData);

    return redirect('/students');
}
public function show(Student $student)
{
    return view('show', compact('student'));
}
public function edit(Student $student)
    {
        return view('edit', compact('student'));
    }

    // 6. Modifier les informations d'un étudiant
    public function update(Request $request, Student $student)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'section' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg',
        ]);

        if ($request->hasFile('image')) {

            $destinationPath = public_path('image');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Supprimer l'ancienne image
            if ($student->image &&
                File::exists($destinationPath . '/' . $student->image)) {
                File::delete($destinationPath . '/' . $student->image);
            }

            // Enregistrer la nouvelle image
            $image = $request->file('image');

            $profileImage = date('YmdHis') . '.' .
                $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $validateData['image'] = $profileImage;
        }

        $student->update($validateData);

        return redirect()->route('students.index');
    }

    // 7. Supprimer un étudiant
    public function destroy(Student $student)
    {
        $imagePath = public_path('image/' . $student->image);

        if ($student->image && File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $student->delete();

        return redirect()->route('students.index');
    }
}