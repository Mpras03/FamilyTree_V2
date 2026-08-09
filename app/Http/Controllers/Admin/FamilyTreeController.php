<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class FamilyTreeController extends Controller
{
    public function index(): View
    {
        $persons = Person::orderBy('birth_date')->get()->keyBy('id');

        $processed = [];

        $roots = $persons
            ->filter(function (Person $person) use ($persons) {
                if ($person->father_id || $person->mother_id) {
                    return false;
                }

                // A parentless person married to someone with recorded parents is
                // "marrying into" a traceable line — attach them there instead of
                // treating them as their own trunk.
                if ($person->spouse_id) {
                    $spouse = $persons->get($person->spouse_id);

                    if ($spouse && ($spouse->father_id || $spouse->mother_id)) {
                        return false;
                    }
                }

                return true;
            })
            ->sortBy('name');

        $tree = [];

        foreach ($roots as $root) {
            if (in_array($root->id, $processed, true)) {
                continue;
            }

            $tree[] = $this->buildUnit($root, $persons, $processed);
        }

        return view('admin.family-tree.index', compact('tree'));
    }

    /**
     * Build a couple/single-person node together with its descendant units.
     *
     * @param  Collection<int, Person>  $persons
     * @param  array<int, int>  $processed
     */
    private function buildUnit(Person $person, Collection $persons, array &$processed): array
    {
        $members = [$person];
        $processed[] = $person->id;

        if ($person->spouse_id && ! in_array($person->spouse_id, $processed, true)) {
            $spouse = $persons->get($person->spouse_id);

            if ($spouse) {
                $members[] = $spouse;
                $processed[] = $spouse->id;
            }
        }

        usort($members, fn (Person $a, Person $b) => ($a->gender === 'P' ? 1 : 0) <=> ($b->gender === 'P' ? 1 : 0));

        $memberIds = array_map(fn (Person $member) => $member->id, $members);

        $children = $persons
            ->filter(fn (Person $p) => in_array($p->father_id, $memberIds, true) || in_array($p->mother_id, $memberIds, true))
            ->sortBy('birth_date');

        $childUnits = [];

        foreach ($children as $child) {
            if (in_array($child->id, $processed, true)) {
                continue;
            }

            $childUnits[] = $this->buildUnit($child, $persons, $processed);
        }

        return [
            'members' => $members,
            'children' => $childUnits,
        ];
    }
}
