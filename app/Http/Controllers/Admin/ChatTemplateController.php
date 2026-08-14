<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatTemplate;
use Illuminate\Http\Request;

class ChatTemplateController extends Controller
{
    public function index()
    {
        $templates = ChatTemplate::with(['businessCategory', 'affiliate'])->latest()->get();
        $categories = \App\Models\BusinessCategory::all();
        return view('admin.chat-templates.index', compact('templates', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'business_category_id' => 'required|exists:business_categories,id',
        ]);

        ChatTemplate::create($validated);

        return redirect()->back()->with('success', 'Template chat berhasil ditambahkan.');
    }

    public function update(Request $request, ChatTemplate $chat_template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'business_category_id' => 'required|exists:business_categories,id',
        ]);

        $chat_template->update($validated);

        return redirect()->back()->with('success', 'Template chat berhasil diupdate.');
    }

    public function destroy(ChatTemplate $chat_template)
    {
        $chat_template->delete();

        return redirect()->back()->with('success', 'Template chat berhasil dihapus.');
    }
}
