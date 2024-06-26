<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\CatatanKeuangan;
use App\Models\Category;
use App\Models\Galery;
use App\Models\JamBuka;
use App\Models\Menu;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\Team;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $data['page_title'] = 'Dashboard';

        return view('dashboard', $data);
    }

    public function index(Request $request)
    {
        $data['page_title'] = 'Home';
        $data['testimoni'] = Testimoni::get();
        $data['galery'] = Galery::get();
        $data['category'] = Category::get();
        $data['menu'] = Menu::get();
        $data['jambuka'] = JamBuka::get();
        $data['team'] = Team::get();
        $data['about'] = About::first();
        $data['table'] = Table::orderBy('name','asc')->get();

        return view('landing/index', $data);
    }

    public function bookTable(Request $request)
    {
        if (Auth::check() == null) {
            return redirect('/login');
        }

        try {
            $new = new Reservation();
            $new->name = Auth::user()->name;
            $new->id_user = Auth::user()->id;
            $new->id_table = $request->id_table;
            $new->no_tlp = $request->no_tlp;
            $new->count_people = $request->count_people;
            $new->date = $request->datetime;
            $new->count_people = $request->people;
            $new->status = 1;
            $new->save();

            return redirect()->back()->with('success','Success Reservation!');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('failed','Failed Reservation!');
        }
    }
//     public function bookTable(Request $request)
//     {
//         // Validate the form data
//         $validatedData = $request->validate([
//             'name' => 'required',
//             'email' => 'required|email',
//             'phone' => 'required|numeric',
//             'date' => 'required',
//             'time' => 'required',
//             'people' => 'required|numeric',
//             'message' => 'required',
//         ]);

//         // Extract the form data
//         $name = $validatedData['name'];
//         $email = $validatedData['email'];
//         $phone = $validatedData['phone'];
//         $date = $validatedData['date'];
//         $time = $validatedData['time'];
//         $people = $validatedData['people'];
//         $message = $validatedData['message'];

//         // Format the message for WhatsApp
//         $whatsappMessage = "
// 🌟👋 Halo! Saya ingin melakukan reservasi untuk $people orang pada $date 📅 pukul $time 🕰️.
// 👤 Nama       : $name
// 📧 Email      : $email
// 📞 Nomor HP   : $phone
// 💬 Pesan      : $message
// 🌟 Terima kasih! 🌟
// ";

//         // Encode the message for the URL
//         $encodedMessage = urlencode($whatsappMessage);

//         // Target WhatsApp number
//         $whatsappNumber = "6281264761015"; // Replace with the target WhatsApp number

//         // URL to redirect to WhatsApp with the prepared message
//         $whatsappUrl = "https://api.whatsapp.com/send/?phone=$whatsappNumber&text=$encodedMessage";

//         // Redirect the user to the WhatsApp URL
//         return redirect()->away($whatsappUrl);
//     }
}
