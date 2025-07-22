<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RelatedLink;

class RelatedLinkController extends Controller
{
    public function index()
    {
        $links = RelatedLink::orderBy('id')->get();
        return view('admin.related_links.index', compact('links'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|max:100',
            'url' => 'required|url'
        ]);

        RelatedLink::create($request->only('label', 'url'));

        return back()->with('success', '✅ Link berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        RelatedLink::findOrFail($id)->delete();

        return back()->with('success', '🗑️ Link berhasil dihapus!');
    }
}
