<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;

use App\Models\TORRequest;
use App\Models\TORItem;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

class TORItemController extends Controller
{    
    public function store(Request $request): JsonResponse
    {
        $torRequestId = $request->torRequestId;        
        $enrollmentItems = $request->enrollmentItems;

        $data = [];
        foreach ($enrollmentItems as $enrollmentItem) {            

            $rating = 0;
            if(isset($enrollmentItem['grade'])){
                $rating = $enrollmentItem['grade']['equivalent'];
            }

            array_push($data, [
                'tor_request_id' => $torRequestId,
                'sy_id' => $enrollmentItem['sy_id'],                                
                'subject_id' => $enrollmentItem['subject_id'],
                'rating' => $rating,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        TORItem::insert($data);

        TORRequest::where('id', $torRequestId)->update([
            'remarks' => 'Claim your TOR on school.',
            'status' => 'Approved',
        ]);

        // $torRequest = TORRequest::create([            
        //     'student_id' => auth()->user()->id,
        //     'reason' => $request->reason,
        //     'status' => $request->status,            
        //     'created_by' => auth()->user()->id,
        //     'updated_by' => auth()->user()->id,            
        // ]);

        return response()->json([]);
    }    
}
