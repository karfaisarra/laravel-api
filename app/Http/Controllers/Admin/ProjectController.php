<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->get();
        //dd($projects);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('cover_image')) {

            $cover_image = Storage::put('uploads', $data['cover_image']);
            //dd($cover_image);
            $data['cover_image'] = $cover_image;
        }

        $projectSlug = Project::slugGenerator($data['title']);
        $data['slug'] = $projectSlug;
        //dd($data);
        
        $project = Project::create($data);
        if($request->has('technologies')){

            $project->technologies()->attach($data['technologies']);

        }

        return to_route('admin.projects.index')->with('message', "Project: $project->title added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //dd($request);

        $data = $request->validated();
        if ($request->hasFile('cover_image')) {
            // dd($request->has('cover_image'));
            // dd($project->cover_image);
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            // dd($request->cover_image);
            $cover_image = Storage::put('uploads', $data['cover_image']);
            //dd($cover_image);
            $data['cover_image'] = $cover_image;
        }

        $projectSlug = Project::slugGenerator($data['title']);

        $data['slug'] = $projectSlug;

        $project->update($data);

        if($request->has('technologies')){
            $project->technologies()->sync($data['technologies']);
        } else {
            $project->technologies()->sync([]);
        }
        return to_route('admin.projects.index')->with('message', "Project: $project->title updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }
        $project->delete();
        return to_route('admin.projects.index')->with('message', "Project: $project->title Deleted successfully");;
    }
}
