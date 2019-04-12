<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\SimpleDistrict;
use App\Http\Requests\UserAddressRequest;
use Carbon\Carbon;

class UserAddressesController extends Controller
{
    public function index(Request $request)
    {
        return view('user_addresses.index', [
            'addresses' => $request->user()->addresses,
        ]);
    }

    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }

    public function store(UserAddressRequest $request)
    {
        $user = \Auth::user();
        \Log::info($request->all());
        $data = $request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]);
        $provinceCode = SimpleDistrict::where('name', $data['province'])->select('code')->first();
        $cityCode = SimpleDistrict::where('name', $data['city'])->where('parent_code', $provinceCode->code)->select('code')->first();
        $districtCode = SimpleDistrict::where('name', $data['district'])->where('parent_code', $cityCode->code)->select('code')->first();
        // if ($districtCode->code != $data['zip']) {
        //     throw new \Exception("邮政编码填写不正确");
        // }
        $data['province_code'] = $provinceCode->code;
        $data['city_code'] = $cityCode->code;
        $data['district_code'] = $districtCode->code;
        $data['user_id'] = $user->id;
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        \Log::info(json_encode($data));
        $insertRes = UserAddress::insert($data);
        return redirect()->route('user_addresses.index');
    }



}
