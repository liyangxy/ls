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

    public function edit(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        return view('user_addresses.create_and_edit', ['address' => $user_address]);
    }

    public function update(UserAddress $user_address, UserAddressRequest $request)
    {
        $this->authorize('own', $user_address);
        $data = $request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]);

        if ($data['province'] != $user_address->province || $data['city'] != $user_address->city || $data['district'] != $user_address->district) {
            $provinceCode = SimpleDistrict::where('name', $data['province'])->select('code')->first();
            $cityCode = SimpleDistrict::where('name', $data['city'])->where('parent_code', $provinceCode->code)->select('code')->first();
            $districtCode = SimpleDistrict::where('name', $data['district'])->where('parent_code', $cityCode->code)->select('code')->first();
            $data['province_code'] = $provinceCode->code;
            $data['city_code'] = $cityCode->code;
            $data['district_code'] = $districtCode->code;
        }
        \Log::info(json_encode($data));
        $user_address->update($data);

        return redirect()->route('user_addresses.index');
    }

    public function destroy(UserAddress $user_address)
    {
        $this->authorize('own', $user_address);
        $user_address->delete();
        return [];
    }


}
