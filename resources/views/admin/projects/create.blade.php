@extends('layouts.admin')

@section('content')

    <h1>Add a new Project</h1>
    <form action="{{ route('admin.projects.store') }} " method="post" enctype="multipart/form-data">
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                placeholder="add title" aria-describedby="titleHelper">
            <small id="titleHelper" class="text-muted">must be unique, max 100 charecters</small>
        </div>
        @error('title')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input type="file" name="cover_image" id="cover_image"
                class="form-control @error('cover_image') is-invalid @enderror" placeholder=""
                aria-describedby="coverImageHelper">
            <small id="coverImageHelper" class="text-muted">Add your cover image</small>
        </div>
        @error('cover_image')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <div class="mb-3">
            <label for="type_id" class="form-label">types</label>
            <select class="form-select form-select-md @error('type_id') 'is-invalid' @enderror" name="type_id"
                id="type_id">
                <option selected>Select one</option>

                @foreach ($types as $type)
                    <option value="{{ $type->id }}" {{ old('type_id') ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach

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
                        <option value="{{ $technology->id }}">{{ $technology->name }}</option>
                    @endif
                @empty
                    <option value="" disabled>Sorry no Technologies in the system yet!</option>
                @endforelse

            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label @error('description') is-invalid @enderror">description</label>
            <textarea name="description" id="description" class="form-control" rows="5"></textarea>
        </div>
        @error('description')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
        @enderror

        <button type="submit" class="btn btn-primary">Add</button>

    </form>

@endsection
