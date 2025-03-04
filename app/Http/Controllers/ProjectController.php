<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('merchant.project.index', compact('projects'));
    }

    public function create()
    {
        return view('merchant.project.create');
    }

    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->validated());
        return redirect()->route('merchant.project.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('merchant.project.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('merchant.project.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return redirect()->route('merchant.project.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('merchant.project.index')->with('success', 'Project deleted successfully.');
    }
}
