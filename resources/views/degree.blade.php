@extends('layout.format')

@section('title','Degrees')

@section('content')

<h2>Degrees</h2>

<div id="degree-alert" class="alert d-none"></div>

<form id="degree-form" class="row g-2 mb-3" action="{{ route('degrees.store') }}" method="POST">
    @csrf
    <input type="hidden" id="degree-id">
    <div class="col-md-8">
        <input type="text" id="degree_title" name="degree_title" value="{{ old('degree_title') }}" class="form-control" placeholder="Degree name">
        <div id="degree-title-error" class="text-danger small mt-1"></div>
        @error('degree_title')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <button type="submit" id="save-degree" class="btn btn-success">Add Degree</button>
        <button type="button" id="cancel-edit" class="btn btn-secondary d-none">Cancel</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Degree Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="degree-table-body">
        @forelse($degrees as $degree)
            <tr data-id="{{ $degree->id }}" data-title="{{ $degree->degree_title }}">
                <td>{{ $degree->id }}</td>
                <td>{{ $degree->degree_title }}</td>
                <td>
                    <a href="{{ route('degrees.edit', $degree) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('degrees.destroy', $degree) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this degree?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No degrees found</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection
