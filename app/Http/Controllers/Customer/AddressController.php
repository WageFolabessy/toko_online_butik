<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->latest()->get();
        return view('customer.profile.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('customer.profile.addresses.create');
    }

    public function store(AddressRequest $request)
    {
        $request->user()->addresses()->create($request->validated());
        return redirect()->route('customer.profile.alamat.index')->with('success', 'Alamat baru berhasil ditambahkan.');
    }

    public function edit(Address $alamat)
    {
        Gate::authorize('update', $alamat);
        return view('customer.profile.addresses.edit', ['address' => $alamat]);
    }

    public function update(AddressRequest $request, Address $alamat)
    {
        Gate::authorize('update', $alamat);
        $alamat->update($request->validated());
        return redirect()->route('customer.profile.alamat.index')->with('success', 'Alamat berhasil diperbarui.');
    }

    public function destroy(Address $alamat)
    {
        Gate::authorize('delete', $alamat);
        $alamat->delete();
        return redirect()->route('customer.profile.alamat.index')->with('success', 'Alamat berhasil dihapus.');
    }
}
