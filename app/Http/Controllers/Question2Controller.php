<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class Question2Controller extends Controller
{
    private const POSIBILITY_TEXT = ["Fintegra", "Homido Indonesia", "Fintegra Homido Indonesia"];

    function get(Request $request)
    {
        $validator = Validator::make($request->only(['total_note']), [
            'total_note' => [
                'numeric',
                'nullable',
                'nullable',
                'min:5'
            ]
        ]);

        if ($validator->fails()) {
            return redirect('q2')->withErrors($validator)->withInput();
        }

        $note = collect([
            3 => Question2Controller::POSIBILITY_TEXT[0],
            5 => Question2Controller::POSIBILITY_TEXT[1],
        ]);

        $total_note = (int) $request->get("total_note");

        for ($i = 3; $i < $total_note; $i++) {

            $next_number = $note->sortKeysDesc()->take(2)->pipe(function (Collection $collection) {
                list($prev, $last) = $collection->keys();
                return $prev * $last;
            });

            if ($next_number > $total_note) {
                break;
            }

            $note->put($next_number, Question2Controller::POSIBILITY_TEXT[$i % 2]);
        }

        return view('q2', [
            'special_note' => $note->toArray()
        ]);
    }
}
