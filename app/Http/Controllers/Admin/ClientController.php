<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->get();
        return view('admin.home.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.home.clients.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'link' => 'nullable|url',
        ]);

        $data = $request->only(['name', 'link']);

        if ($request->hasFile('logo')) {
            $imageName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('assets/img/client'), $imageName);
            $data['logo'] = 'assets/img/client/' . $imageName;
        }

        Client::create($data);

        return redirect()->route('admin.home_clients.index')->with('success', 'Client added successfully!');
    }

    public function edit(Client $client)
    {
        return view('admin.home.clients.form', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'link' => 'nullable|url',
        ]);

        $data = $request->only(['name', 'link']);

        if ($request->hasFile('logo')) {
            // Delete old logo (optional, currently logic might need adjustment if using physical paths)
            $imageName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('assets/img/client'), $imageName);
            $data['logo'] = 'assets/img/client/' . $imageName;
        }

        $client->update($data);

        return redirect()->route('admin.home_clients.index')->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        if ($client->logo) {
            Storage::disk('public')->delete($client->logo);
        }
        $client->delete();

        return redirect()->route('admin.home_clients.index')->with('success', 'Client deleted successfully!');
    }
}
