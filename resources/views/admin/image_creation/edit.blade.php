@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Image</h2>
    
    <form action="{{ route('image_creation.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="text">Add Text</label>
            <input type="text" name="text" class="form-control" id="text" placeholder="Enter text">
        </div>
        
        <div class="form-group">
            <label for="font">Select Font</label>
            <select name="font" id="font" class="form-control">
                <option value="Arial">Arial</option>
                <option value="Times New Roman">Times New Roman</option>
                <option value="Helvetica">Helvetica</option>
                <!-- Add more fonts as needed -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="logo">Upload Logo</label>
            <input type="file" name="logo" class="form-control-file" id="logo">
        </div>
        
        <button type="submit" class="btn btn-success">Create Image</button>
    </form>
</div>
@endsection
