<?php

namespace App\Http\Controllers;
use App\Bucket;
use App\Ball;
use DB;

use Illuminate\Http\Request;

class BallBucketController extends Controller
{
    public function index()
    {
       
        $balls = Ball::all();
        
        //result
        $buckets = Bucket::with('balls')->get();
        // dd($buckets);
        return view('welcome', compact('buckets', 'balls'));

    }

    public function createBucket(Request $request)
    {
        
        $this->validate($request,[
            'bucketName'=>"required|string|max:10|unique:buckets,name",
            'bucketVolume'=>"required|integer",
           
        ]);

        $data = [
            'name' => $request->input('bucketName'),
            'volume' => $request->input('bucketVolume'),
          
        ];
            // dd($data);
        Bucket::create($data);
        return redirect()->back()->with('success', 'Bucket created successfully!');
      
    }


    public function createBall(Request $request)
    {
        
        $this->validate($request,[
            'name'=>"required|string|max:10",
            'size'=>"required|integer",
           
        ]);

        $data = [
            'color' => $request->input('name'),
            'size' => $request->input('size'),
          
        ];
        // dd($data);
        Ball::create($data);
        return redirect()->back()->with('success', 'Ball created successfully!');
      
    }
    

public function storeSuggestedBalls(Request $request)
{
    $selectedBallsss = $request->input('selectedBalls');
    $quantity = $request->input('quantity');
    $selectedBalls = json_decode($selectedBallsss, true) ?? [];
    $maxCapacityBuckets = Bucket::orderBy('volume', 'desc')->get();
// dd($maxCapacityBuckets);

    //loop for check bucket capacity
    foreach ($maxCapacityBuckets as $maxCapacityBucket) {
        $totalSuggestedSize = 0;

        foreach ($selectedBalls as $key => $color) {
           
            $totalSize = Ball::where('color', $color)->sum('size');
            $totalSuggestedSize += $totalSize * $quantity[$key];
        }
        // dd($totalSuggestedSize);

        // Check if the  suggested size is smaller than or equal to the current bucket capacity
        if ($totalSuggestedSize <= $maxCapacityBucket->volume) {
            // Check if space in the current bucket
            $currentBucketSize = DB::table('bucket_suggestion')
                ->where('bucket_id', $maxCapacityBucket->id)
                ->join('balls', 'bucket_suggestion.ball_id', '=', 'balls.id')
                ->sum(DB::raw('balls.size * bucket_suggestion.quantity'));

            $remainingCapacity = $maxCapacityBucket->volume - $currentBucketSize;
            // dd($remainingCapacity);

            // If  space is available  then  store the balls 
            if ($remainingCapacity >= $totalSuggestedSize) {
                foreach ($selectedBalls as $key => $color) {
                    $balls = Ball::where('color', $color)->get();
                    
                    foreach ($balls as $ball) {
                        DB::table('bucket_suggestion')->insert([
                            'bucket_id' => $maxCapacityBucket->id,
                            'ball_id' => $ball->id,
                            'quantity' => $quantity[$key],
                        ]);
                    }
                }

                return response()->json(['message' => 'Data stored successfully']);
            }
            // Continue  to check the next bucket
            continue;
        }
    }

    // If no  bucket is found
    return response()->json(['error' => 'No available bucket with sufficient capacity']);
}

}
