<?php

namespace App\Http\Controllers;

use App\BookingOptional;
use App\Optional;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BookingOptionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.add_new_optional');
    }


    public function storenewoptional(Request $request)
    {
        $test = $request->all();

        $data = Optional::create([
           'nome' => $request->nome,
           'column_name' => strtolower(str_replace(" ", "_", $request->nome)),
           'prezzo_per_unita' => $request->prezzo_per_unita,
           'updated_at' => null,
           'created_at' => null
        ]);

            Schema::table('booking_optionals',
                function (Blueprint $table) use ($test)
                {
                    $table->integer(strtolower(str_replace(" ", "_", $test['nome'])))->nullable();
                }
            );

    }

    public function optionalcreate($id)
    {
        $optionals = Optional::all();

        $booking_id = $id;

        return view('dashboard.optional_booking', compact('optionals','booking_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $optional = new BookingOptional();

        $optional->booking_id = $request->booking_id;

        $optional->coffee_break = $this->coffee_break($request->coffee_break);
        // dd($optional->coffee_break);
        $optional->quick_lunch = $request->quick_lunch;

        $optional->save();

        return redirect('/dashboard/bookings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingOptional  $bookingOptional
     * @return \Illuminate\Http\Response
     */
    public function show(BookingOptional $bookingOptional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingOptional  $bookingOptional
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingOptional $bookingOptional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingOptional  $bookingOptional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingOptional $bookingOptional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingOptional  $bookingOptional
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingOptional $bookingOptional)
    {
        //
    }

    public function coffee_break($num)
    {
        $dati =  Optional::where('column_name','=','coffee_break')->get();

        foreach($dati as $data){
            $prezzo = $data->prezzo_per_unita;
        }

        $price = $prezzo*$num;
        return $price;
    }
}
