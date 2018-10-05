<?php

namespace App\Http\Controllers;

use App\Client;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $gmaps;

    public function __construct(GMaps $gmaps)
    {
        $this->gmaps = $gmaps;
    }

    public function index()
    {

        $clients = Auth::user()->clients()->orderBy('id', 'DESC')->get();
        $client = new \GuzzleHttp\Client();
        $request = $client->get('http://battuta.medunes.net/api/country/all/?key=ffeff82d44681dc9e056c194360d8945');
        $response = json_decode($request->getBody());
        $response = (array)$response;

        foreach($response as $key => $val){
            $response[$key] = (array)$val;
        }

        return view('home', ['clients' => $clients, 'countries' => $response]);
    }

    public function addClient(Request $request)
    {
        if(isset($request->country_post) && isset($request->code)){

            $client = new \GuzzleHttp\Client();
            $request = $client->get('http://battuta.medunes.net/api/region/'.$request->code.'/all/?key=ffeff82d44681dc9e056c194360d8945');
            return json_decode($request->getBody());
        }

        if(isset($request->state_post) && isset($request->code)){

            $regionHint = substr($request->state_post, 0, 3);
            $client = new \GuzzleHttp\Client();
            $request = $client->get('https://battuta.medunes.net/api/city/'.$request->code.'/search/?region='.$regionHint.'&key=ffeff82d44681dc9e056c194360d8945');
            return json_decode($request->getBody());
        }

        $input = $request->except('_token');
        $input['user_id'] = Auth::user()->id;

        $validator = Validator::make($input, [
            'name' => 'required|max:55',
            'surname' => 'required|max:55',
            'fatherName' => 'required|max:55',
            'phone' => 'required|numeric',
            'email' => 'required|email',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',

        ]);

        if($validator->fails()){
            return redirect()->route('home')->withErrors($validator)->withInput();
        }

        $client = new Client();
        $client->fill($input);

        if($client->save()){
            return redirect()->route('home')->with('status', 'The Client is added');
        }

    }

    public function clientShow($id)
    {
        $authId = Auth::user()->id;

        $client = Client::where([['id', $id], ['user_id', $authId]])->first();

        if(empty($client)){
            return 'You are not allowed to see this client!';
        }

        $locations = $client->locations->where('timestamp', '>', time()-86400)->sortByDesc('id')->toArray();

        $config['center'] = '40.180823, 44.507702';

        if(!empty($locations)){
            $config['center'] = $locations[1]['lat'].', '.$locations[1]['long'];
        }

        $config['zoom'] = '14';
        $config['map_height'] = '500px';
//        $config['map_width'] = '400px';
        $config['geocodeCaching'] = False;
        $config['scrollweel'] = false;

        $polylineArray = [];

        $this->gmaps->initialize($config);

//        add marker
        foreach($locations as $location){
            $locString = $location['lat'].', '.$location['long'];
            $marker['position'] = $locString;
            $marker['infowindow_content'] = $client->name.' '.$client->surname.' '.$client->fatherName.', '.
                                            $client->email.', '.$client->phone;
            $this->gmaps->add_marker($marker);

            $polylineArray[] = $locString;
        }

//        add polyline
        $polyline['points'] = $polylineArray;
        $this->gmaps->add_polyline($polyline);

//        create map
        $map = $this->gmaps->create_map();

        return view('client')->with('map', $map);
    }

    public function test()
    {
        echo time();
    }
}
