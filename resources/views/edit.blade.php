
@extends('layout')

@section('content')

<h3>Edit Student</h3>

<form method="POST"
      action="{{ route('students.update', $student->id) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Name:</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $student->name) }}">
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Email:</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email', $student->email) }}">
        @error('email')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Phone:</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="{{ old('phone', $student->phone) }}">
        @error('phone')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Section:</label>
        <input type="text"
               name="section"
               class="form-control"
               value="{{ old('section', $student->section) }}">
        @error('section')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label>Current Image:</label><br>

        <img src="{{ asset('image/'.$student->image) }}"
             width="100" height="100">
    </div>

    <div class="form-group">
        <label>New Image (optional):</label>

        <input type="file"
               name="image"
               class="form-control">

        @error('image')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Update Student
    </button>

    <a href="{{ route('students.index') }}"
       class="btn btn-secondary">
        Cancel
    </a>

</form>

@endsection
