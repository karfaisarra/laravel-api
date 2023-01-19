@extends('layouts.admin')

@section('content')
    <h1>Edit the Project</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.projects.update', $project->slug) }} " method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                placeholder="add title" aria-describedby="titleHelper" value="{{ old('title', $project->title) }}">
            <small id="titleHelper" class="text-muted">must be unique, max 100 charecters</small>
        </div>
        @error('title')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <div class="mb-3 d-flex gap-4">
            <img width="140" src="{{ asset('storage/' . $project->cover_image) }}" alt="">
            <div>
                <label for="cover_image" class="form-label">Cover Image</label>
                <input type="file" name="cover_image" id="cover_image"
                    class="form-control @error('cover_image') is-invalid @enderror" placeholder=""
                    aria-describedby="coverImageHelper">
                <small id="coverImageHelper" class="text-muted">Add your cover image</small>
            </div>
        </div>
        @error('cover_image')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <div class="mb-3">
            <label for="type_id" class="form-label">types</label>
            <select class="form-select form-select-lg @error('type_id') 'is-invalid' @enderror" name="type_id"
                id="type_id">
                <option value="">Untyped</option>

                @forelse ($types as $type)
                    <option value="{{ $type->id }}"
                        {{ $type->id == old('type_id', $project->type ? $project->type->id : '') ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @empty
                    <option value="">Sorry, no types in the system.</option>
                @endforelse

            </select>
        </div>
        @error('type_id')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <div class="mb-3">
            <label for="" class="form-label">Technologies</label>
            <select multiple class="form-select form-select-md" name="technologies[]" id="technologies">
                <option value="" disabled>Select one</option>
                @forelse ($technologies as $technology)
                    @if ($errors->any())
                        <option value="{{ $technology->id }}"
                            {{ in_array($technology->id, old('technologies', [])) ? 'selected' : '' }}>
                            {{ $technology->name }}
                        </option>
                    @else
                        <option value="{{ $technology->id }}"
                            {{ $project->technologies->contains($technology->id) ? 'selected' : '' }}>
                            {{ $technology->name }}</option>
                    @endif
                @empty
                    <option value="" disabled>Sorry no Technologies in the system yet!</option>
                @endforelse

            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                rows="5">{{ old('description', $project->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        @error('description')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror
    </form>
@endsection
