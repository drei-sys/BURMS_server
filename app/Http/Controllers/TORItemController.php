<?php

namespace App\Http\Controllers;

use App\Models\TORRequest;
use App\Models\TORItem;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

class TORItemController extends Controller
{    
    public function store(Request $request): Response
    {
        $torRequestId = $request->torRequestId;        
        $enrollmentItems = $request->enrollmentItems;

        $data = [];
        foreach ($enrollmentItems as $enrollmentItem) {            

            $rating = 0;
            if(isset($enrollmentItem['grade'])){
                $rating = $enrollmentItem['grade']['rating'];
            }

            array_push($data, [
                'tor_request_id' => $torRequestId,
                'sy_id' => $enrollmentItem['sy_id'],                                
                'subject_code' => $enrollmentItem['subject_code'],
                'subject_name' => $enrollmentItem['subject_name'],
                'rating' => $rating,
                'credits' => $enrollmentItem['subject_unit'],
                'completion_grade' => "-",
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        TORItem::insert($data);

        TORRequest::find($torRequestId)->update([
            'remarks' => 'Claim your TOR on school.',
            'status' => 'Approved',
        ]);        

        return response()->noContent();
    }    
}
