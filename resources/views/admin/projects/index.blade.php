@extends('layouts.admin')
@section('content')
    <div class="my-4">
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <div class="d-flex justify-content-between align-items-center my-4">
        <h1>Projects</h1>
        <a class="btn btn-primary" href="{{ route('admin.projects.create') }}">Add New Project</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped
    table-hover	
    table-borderless
    table-primary
    align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Cover Image</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @forelse($projects as $project)
                    <tr class="table-primary">
                        <td scope="row">{{ $project->id }}</td>
                        <td>
                            @if ($project->cover_image)
                                <img width="100" src="{{ asset('storage/' . $project->cover_image) }}" alt="">
                            @else
                                <img width="100" src="https://picsum.photos/200/300" alt="">
                            @endif
                        </td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->slug }}</td>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('admin.projects.show', $project->slug) }}"><i
                                    class="fas fa-eye fa-sm fa-fw"></i></a>
                            <a class="btn btn-primary" href="{{ route('admin.projects.edit', $project->slug) }}"><i
                                    class="fas fa-pencil fa-sm fa-fw"></i></a>

                            <!-- Modal trigger button -->
                            <button type="button" class="btn btn-danger btn-md" data-bs-toggle="modal"
                                data-bs-target="#project-{{ $project->id }}">
                                <i class="fas fa-trash fa-sm fa-fw"></i>
                            </button>

                            <!-- Modal Body -->
                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                            <div class="modal fade" id="project-{{ $project->id }}" tabindex="-1"
                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                aria-labelledby="project-{{ $project->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="project-{{ $project->id }}"> Delete
                                                {{ $project->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this project?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <form action="{{ route('admin.projects.destroy', $project->slug) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <input class="btn btn-danger" type="submit" value="confirm">

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No Projects Yet!</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>

            </tfoot>
        </table>
    </div>
@endsection
