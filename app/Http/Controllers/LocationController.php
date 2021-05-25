<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use App\Models\Vaccination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function index() {
        /**
         * load all locations and relations with eager loading
         */
        $locations = Location::with(['vaccinations'])->get();
        return $locations;
    }

    public function findById(int $id) {
        $location = Location::where('id',$id)->
        with(['vaccinations'])->first();
        return $location;
    }

    public function findByPLZ(int $plz) {
        $location = Location::where('plz',$plz)->
        with(['vaccinations'])->first();
        return $location;
    }

    public function checkPLZ(int $plz) {
        $location = Location::where('plz',$plz)->first();
        return $location != null ? response()->json(true,200) : response()->json(false,200);
    }

    public function findBySearchTerm(string $searchTerm)
    {
        return Location::with(['vaccinations'])
            ->where('plz', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('place', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('street', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('streetnumber', 'LIKE', '%' . $searchTerm . '%')
            ->orWhereHas('vaccinations', function ($query) use ($searchTerm)
            {
                $query
                    ->where('start', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('date', 'LIKE', '%' . $searchTerm . '%');
            })->get();
    }

    /**
     * create new Location
     */
    public function save(Request $request) : JsonResponse  {
        $request = $this->parseRequest($request);
        /*+
        *  use a transaction for saving model including relations
        * if one query fails, complete SQL statements will be rolled back
        */
        DB::beginTransaction();
        try {
            $locations = Location::create($request->all());
            if (isset($request['vaccinations']) && is_array($request['vaccinations'])) {
                foreach ($request['vaccinations'] as $vaccination) {
                    $object =
                        Vaccination::firstOrNew([
                            'id'=>$vaccination['id'],
                            'date'=>$vaccination['date'],
                            'start'=>$vaccination['start'],
                            'end'=>$vaccination['end'],
                            'amount'=>$vaccination['amount'],
                            'location_id'=>$vaccination['location_id'],
                            'created_at' => $vaccination['created_at'],
                            'updated_at' => $vaccination['updated_at'],
                        ]);
                    $locations->users()->save($object);
                }
            }

            DB::commit();
            // return a vaild http response
            return response()->json($locations, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("saving location failed: " . $e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $id) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $location = Location::with(['vaccinations'])
                ->where('id', $id)->first();
            if ($location != null) {
                $request = $this->parseRequest($request);
                $location->update($request->all());
            }
            DB::commit();
            $location = Location::with(['vaccinations'])
                ->where('id', $id)->first();
            // return a vaild http response
            return response()->json($location, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating location failed: " . $e->getMessage(), 420);
        }
    }

    private function parseRequest(Request $request): Request
    {
        $datetime = new \DateTime($request->published);
        $request['published'] = $datetime;
        return $request;
    }

    /**
     * returns 200 if location deleted successfully, throws excpetion if not
     */
    public function delete(string $id) : JsonResponse
    {
        $location = Location::where('id', $id)->first();
        if ($location != null) {
            $location->delete();
        }
        else
            throw new \Exception("location couldn't be deleted - it does not exist");
        return response()->json('location (' . $id . ') successfully deleted', 200);
    }
}
