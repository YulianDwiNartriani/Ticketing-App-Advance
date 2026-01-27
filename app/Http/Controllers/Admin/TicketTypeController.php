<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketType;

class TicketTypeController extends Controller
{
    public function index()
    {
            $ticketTypes = TicketType::all();
            return view('admin.ticket-types.index', compact('ticketTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ticket-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {
        $payload = $request->validate([
            'nama' => 'required|string|max:255|unique:ticket_types,nama',
        ]);

        if (!isset($payload['nama'])) {
            return redirect()->route('ticket-types.index')->with('error', 'tipe tiket wajib diisi.');
        }

        TicketType::create([
            'nama' => $payload['nama'],
        ]);

        return redirect()->route('admin.ticket-types.index')->with('success', 'tipe tiket berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticketType = TicketType::findOrFail($id);
         return view('admin.ticket-types.show', compact('ticketType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ticketType = TicketType::findOrFail($id);
        return view('admin.ticket-types.edit', compact('ticketType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
     {
        $ticketType = TicketType::findOrFail($id);
        $payload = $request->validate([
            'nama' => 'required|string|max:255|unique:ticket_types,nama,' . $ticketType->id,
        ]);

        $ticketType->update($payload);

        if (!isset($payload['nama'])) {
            return redirect()->route('ticket-types.index')->with('error', 'tipe tiket wajib diisi.');
        }

        $ticketTipe = TicketType::findOrFail($id);
        $ticketTipe->nama = $payload['nama'];
        $ticketTipe->save();

        return redirect()->route('admin.ticket-types.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TicketType::destroy($id);
        return redirect()->route('admin.ticket-types.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
