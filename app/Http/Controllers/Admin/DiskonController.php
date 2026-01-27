<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Diskon;
use App\Models\Event; 

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $diskons = Diskon::with('event')->orderBy('created_at', 'desc')->get();

            //$diskons = Diskon::all();
            return view('admin.diskon.index', compact('diskons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::orderBy('judul')->get();

        return view('admin.diskon.create', compact('events'));
        // kalau global pakai:
         //return view('admin.diskon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
        $payload = $request->validate([
            'nama' => 'required|string|max:255',
            'nilai' => 'required|integer|min:0|max:100',
            'aktif' => 'nullable|boolean',
            'event_id' => 'nullable|exists:events,id',
            'mulai_at'    => 'required|date',
            'berakhir_at' => 'required|date|after_or_equal:mulai_at',
        ]);

        if (!empty($payload['aktif']) && $payload['aktif']) {
            Diskon::where('aktif', true)->update(['aktif' => false]);
        }

        Diskon::create($payload);

        return redirect()->route('admin.diskons.index')->with('success', 'Diskon berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diskon = Diskon::findOrFail($id);
        return view('admin.diskon.show', compact('diskon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diskon = Diskon::findOrFail($id);
        $events = Event::orderBy('judul')->get();

        return view('admin.diskon.edit', compact('diskon', 'events'));

        // kalau global pakai:
        // $diskon = Diskon::findOrFail($id);
        // return view('admin.diskon.edit', compact('diskon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
     {
        $diskon = Diskon::findOrFail($id);

        $payload = $request->validate([
            'nama' => 'required|string|max:255',
            'nilai' => 'required|integer|min:0|max:100',
            'aktif' => 'nullable|boolean',
            'event_id' => 'nullable|exists:events,id',
            'mulai_at'    => 'required|date',
            'berakhir_at' => 'required|date|after_or_equal:mulai_at',
        ]);

         if (!empty($payload['aktif']) && $payload['aktif']) {
            Diskon::where('aktif', true)
                ->where('id', '!=', $diskon->id)
                ->update(['aktif' => false]);
        }

        $diskon->update($payload);

        return redirect()->route('admin.diskons.index')->with('success', 'Diskon berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Diskon::destroy($id);
        return redirect()->route('admin.diskons.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
