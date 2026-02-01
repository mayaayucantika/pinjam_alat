<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Category;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tools = Tool::with('category')
            ->latest()
            ->paginate(12);
        
        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tools', 'public');
        }

        $tool = Tool::create($validated);
        ActivityLogger::logCreate($tool, 'Menambahkan alat baru: ' . $tool->name);

        return redirect()->route('tools.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    public function show(Tool $tool)
    {
        $tool->load('category');
        return view('tools.show', compact('tool'));
    }

    public function edit(Tool $tool)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $oldValues = $tool->getAttributes();
        
        if ($request->hasFile('image')) {
            if ($tool->image) {
                Storage::disk('public')->delete($tool->image);
            }
            $validated['image'] = $request->file('image')->store('tools', 'public');
        }

        $tool->update($validated);
        ActivityLogger::logUpdate($tool, $oldValues, 'Memperbarui alat: ' . $tool->name);

        return redirect()->route('tools.index')
            ->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy(Tool $tool)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $toolName = $tool->name;
        
        if ($tool->image) {
            Storage::disk('public')->delete($tool->image);
        }

        ActivityLogger::logDelete($tool, 'Menghapus alat: ' . $toolName);
        $tool->delete();

        return redirect()->route('tools.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
