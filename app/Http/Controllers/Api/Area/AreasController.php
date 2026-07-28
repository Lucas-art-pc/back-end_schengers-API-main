<?php

namespace App\Http\Controllers\Api\Area;

use App\Http\Controllers\Controller;
use App\Http\Requests\AreaRequest;
use App\Models\Area;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = \DB::table('tb_areas as a')
            ->leftJoin('tb_courses as c', 'c.fk_id_area', '=', 'a.id')
            ->select(
                'a.id',
                'a.name_area',
                'a.color_area',
                'a.slug_area',
                \DB::raw('COUNT(c.id_course) as total_courses')
            )
            ->groupBy('a.id', 'a.name_area')
            ->get();
        return response()->json($areas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        $data = $request->validated();

        $area = Area::create($data);

        return response()->json([
            'data' => $area,
            'message' => 'Área de curso criada!'

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, int $id)
    {
        $area = Area::findOrFail($id);

        $area->update($request->validated());

        return response()->json([
            'message' => 'Área de curso atualizada!',
            'data' => $area
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Area::destroy($id);
        return response()->json([
            'message' => 'Área excluída com sucesso!'
        ]);
    }
}
