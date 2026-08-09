<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function index(): View
    {
        $persons = Person::with(['father', 'mother', 'spouse'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.persons.index', compact('persons'));
    }

    public function create(): View
    {
        return view('admin.persons.create', [
            'person' => new Person(),
            'fathers' => Person::where('gender', 'L')->orderBy('name')->get(),
            'mothers' => Person::where('gender', 'P')->orderBy('name')->get(),
            'spouses' => Person::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('persons', 'public');
        }

        $person = Person::create($data);

        $this->syncSpouse($person, $data['spouse_id'] ?? null);

        return redirect()->route('admin.persons.index')->with('status', 'Data berhasil ditambahkan.');
    }

    public function edit(Person $person): View
    {
        return view('admin.persons.edit', [
            'person' => $person,
            'fathers' => Person::where('gender', 'L')->where('id', '!=', $person->id)->orderBy('name')->get(),
            'mothers' => Person::where('gender', 'P')->where('id', '!=', $person->id)->orderBy('name')->get(),
            'spouses' => Person::where('id', '!=', $person->id)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Person $person): RedirectResponse
    {
        $data = $this->validateData($request, $person);

        if ($request->hasFile('photo')) {
            if ($person->photo) {
                Storage::disk('public')->delete($person->photo);
            }

            $data['photo'] = $request->file('photo')->store('persons', 'public');
        }

        $person->update($data);

        $this->syncSpouse($person, $data['spouse_id'] ?? null);

        return redirect()->route('admin.persons.index')->with('status', 'Data berhasil diperbarui.');
    }

    public function destroy(Person $person): RedirectResponse
    {
        if ($person->photo) {
            Storage::disk('public')->delete($person->photo);
        }

        Person::where('spouse_id', $person->id)->update(['spouse_id' => null]);
        Person::where('father_id', $person->id)->update(['father_id' => null]);
        Person::where('mother_id', $person->id)->update(['mother_id' => null]);

        $person->delete();

        return redirect()->route('admin.persons.index')->with('status', 'Data berhasil dihapus.');
    }

    private function validateData(Request $request, ?Person $person = null): array
    {
        $notSelf = $person ? 'not_in:'.$person->id : '';

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:L,P'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'father_id' => array_filter(['nullable', 'exists:persons,id', $notSelf]),
            'mother_id' => array_filter(['nullable', 'exists:persons,id', $notSelf]),
            'spouse_id' => array_filter(['nullable', 'exists:persons,id', $notSelf]),
        ]);
    }

    private function syncSpouse(Person $person, ?int $spouseId): void
    {
        // Detach the person's previous spouse (recorded on the other side), if any.
        $previousSpouseId = Person::where('spouse_id', $person->id)->value('id');

        if ($previousSpouseId && $previousSpouseId !== $spouseId) {
            Person::whereKey($previousSpouseId)->update(['spouse_id' => null]);
        }

        if ($spouseId) {
            // Detach the new spouse's existing partner, if any, before linking them.
            $newSpousePreviousPartnerId = Person::whereKey($spouseId)->value('spouse_id');

            if ($newSpousePreviousPartnerId && $newSpousePreviousPartnerId !== $person->id) {
                Person::whereKey($newSpousePreviousPartnerId)->update(['spouse_id' => null]);
            }

            Person::whereKey($spouseId)->update(['spouse_id' => $person->id]);
        }
    }
}
