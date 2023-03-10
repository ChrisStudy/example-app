<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Office;
use Yajra\DataTables\DataTables;


class OfficesDisplayController extends Controller
{
    public function indexFiltering (Request $request) {
        $office_array = Office::distinct()->orderBy('offices', 'desc')->get('offices')->pluck('offices');
        $table_array = Office::distinct()->orderBy('tables', 'desc')->get('tables')->pluck('tables');
        $price_array = Office::distinct()->orderBy('price', 'desc')->get('price')->pluck('price');
        // $max_price = Office::max('price');
        // $min_price = Office::min('price');
        $sqm_array = Office::distinct()->orderBy('sqm', 'desc')->get('sqm')->pluck('sqm');
        // $max_sqm = Office::max('sqm');

        if ($request->ajax()) {
            $offices =  Office::select('*');
            return Datatables::of($offices)
                      ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('office'))) {
                            $instance->where('offices', $request->get('office'));
                        }
                        if (!empty($request->get('table'))) {
                            $instance->where('tables', $request->get('table'));
                        }
                        if (!empty($request->get('price_a')) or !empty($request->get('price_b'))) {
                            if (!empty($request->get('price_a')) && empty($request->get('price_b')))
                            {
                                $instance->whereBetween('price',[$request->get('price_a'),Office::max('price')]);
                            } elseif (empty($request->get('price_a')) && !empty($request->get('price_b')))
                            {
                                $instance->whereBetween('price',[$request->get('price_b'),Office::max('price')]);
                            } elseif (!empty($request->get('price_a')) && !empty($request->get('price_b')))
                            {
                                if ( $request->get('price_a') > $request->get('price_b'))
                                {
                                    $instance->whereBetween('price',[$request->get('price_b'),$request->get('price_a')]);
                                } elseif ( $request->get('price_a') < $request->get('price_b'))
                                {
                                    $instance->whereBetween('price',[$request->get('price_a'),$request->get('price_b')]);
                                } else {
                                    $instance->where('price',$request->get('price_a'));
                                }
                            } 
                        }
                        if (!empty($request->get('size_a')) or !empty($request->get('size_b'))) {
                            if (!empty($request->get('size_a')) && empty($request->get('size_b')))
                            {
                                $instance->whereBetween('sqm',[$request->get('size_a'),Office::max('sqm')]);
                            } elseif (empty($request->get('size_a')) && !empty($request->get('size_b')))
                            {
                                $instance->whereBetween('sqm',[$request->get('size_b'),Office::max('sqm')]);
                            } elseif (!empty($request->get('size_a')) && !empty($request->get('size_b')))
                            {
                                if ( $request->get('size_a') > $request->get('size_b'))
                                {
                                    $instance->whereBetween('sqm',[$request->get('size_b'),$request->get('size_a')]);
                                } elseif ( $request->get('size_a') < $request->get('size_b'))
                                {
                                    $instance->whereBetween('sqm',[$request->get('size_a'),$request->get('size_b')]);
                                } else {
                                    $instance->where('sqm',$request->get('size_a'));
                                }
                            } 
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('name', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['offices'])
                    ->make(true);
        }
        $offices = Office::all();
        return view('import',array(
        'offices'=>$offices,
        'office_array' => $office_array,
        'table_array' => $table_array,
        'price_array' => $price_array,
        'sqm_array' => $sqm_array
    ));
    }
}
