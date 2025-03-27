<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningMaterials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LearningMaterialsController extends Controller
{
    // Display all approved materials (for students)
    public function index()
    {
        $materials = LearningMaterial::approved()->get();
        return view('learning_materials.index', compact('materials'));
    }

    // Show upload form (for teachers)
    public function create()
    {
        return view('learning_materials.create');
    }

    // Store uploaded material (for teachers)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240' // Max 10MB
        ]);

        $path = $request->file('file')->store('learning_materials');

        LearningMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
            'status' => 'pending'
        ]);

        return redirect()->route('learning_materials.index')->with('success', 'Material uploaded successfully. Awaiting approval.');
    }

    // Show pending materials for approval (for staff)
    public function pending()
    {
        $materials = LearningMaterial::where('status', 'pending')->get();
        return view('learning_materials.pending', compact('materials'));
    }

    // Approve a material (for staff)
    public function approve($id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->update(['status' => 'approved', 'approved_by' => Auth::id()]);

        return redirect()->back()->with('success', 'Material approved.');
    }

    // Reject a material (for staff)
    public function reject($id)
    {
        $material = LearningMaterial::findOrFail($id);
        $material->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Material rejected.');
    }

    // Download a material (for students)
    public function download($id)
    {
        $material = LearningMaterial::approved()->findOrFail($id);
        return Storage::download($material->file_path);
    }
}
