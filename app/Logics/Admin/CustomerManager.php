<?php

namespace App\Logics\Admin;

use App\Events\RegisterCustomer;
use App\Helpers\StringHelper;
use App\Models\Cart;
use App\Models\Customer;
use App\Traits\ImageTrait;
use App\Traits\StorageTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerManager
{
    use StorageTrait;
    use ImageTrait;

    /**
     * Update customer profile
     * @param mixed $customer
     * @param mixed $parameters
     * @param mixed $avatar
     * @return void
     */
    public function updateCustomerProfile($customer, $parameters, $avatar = null)
    {
        $old_avatar_path = null;
        $avatar_path = $customer->avatar;
        if ($avatar) {
            $old_avatar_path = $customer->avatar;
            $extension = $avatar->getClientOriginalExtension();
            $avatar = $this->resizeImage($avatar->getRealPath(), AVATAR_WIDTH);
            $avatar_path = $this->uploadFileByStream($avatar, CUSTOMER_DIR . '/' . $customer->id . '/' . Str::random(25) . '.' . $extension);
        }

        $parameters += [
            'avatar' => $avatar_path
        ];

        Customer::where('id', $customer->id)->update($parameters);

        if ($old_avatar_path) {
            // Remove old file
            $this->deleteFile($old_avatar_path);
        }
    }

    /**
     * get image
     * @param mixed $id
     * @param string $typeImage
     * @return mixed
     */
    public function getImage($id, $typeImage = 'avatar')
    {
        try {
            $customer = Customer::withTrashed()->find($id, [$typeImage . ' as image', 'gender']);
            if (empty($customer)) {
                return response()->file(base_path() . '/public/images/user-default.png');
            }

            if (empty($customer->image)) {
                $image = response()->file(base_path() . '/public/images/user-default.png');
            } else {
                $image = Storage::disk(FILESYSTEM)->response($customer->image);
            }
            return $image;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * get all user
     * @param $request
     * @return $users
     */
    public function getCustomerList($request)
    {
        $columns = [
            'customers.*',
            'communes.name as commune_name',
            'districts.name as district_name',
            'prefectures.name as prefecture_name'
        ];

        $users = Customer::select(
            $columns,
        )
            ->leftjoin('communes', 'communes.id', 'customers.commune_id')
            ->leftjoin('districts', 'districts.id', 'customers.district_id')
            ->leftjoin('prefectures', 'prefectures.id', 'customers.prefecture_id');

        $stringHelper = new StringHelper();
        if (isset($request->id)) {
            $users->where('customers.id', $request->id);
        }
        if (isset($request->keyword)) {
            $keyword = $stringHelper->formatStringWhereLike($request->keyword);
            $users->where(DB::raw('CONCAT_WS(" ", customers.first_name, customers.last_name)'), 'LIKE', '%' . $keyword . '%');
        }
        if (isset($request->email)) {
            $email = $stringHelper->formatStringWhereLike($request->email);
            $users->where('email', 'LIKE', '%' . $email . '%');
        }
        if (isset($request->phone)) {
            $phone = $stringHelper->formatStringWhereLike($request->phone);
            $users->where('phone', 'LIKE', '%' . $phone . '%');
        }
        if (isset($request->gender)) {
            $users->whereIn('gender', $request->gender);
        }
        if (isset($request->birthday)) {
            $birthday = Carbon::createFromFormat('d/m/Y', $request->birthday)->format('Y-m-d');
            $users->where('birthday', $birthday);
        }
        if ($request->has('deleted')) {
            $users = $users->onlyTrashed();
        }

        if ($request->sort === 'hometown') {
            $direction = in_array($request->direction, ['asc', 'desc']) ? $request->direction : 'asc';
            $users = $users->orderBy('prefectures.name', $request->direction)
                ->orderBy('districts.name', $request->direction)
                ->orderBy('communes.name', $request->direction);
        }
        return $users;
    }

    /**
     * create customer profile
     * @param $parameters
     * @param $avatar
     */
    public function createCustomerProfile($parameters, $avatar = null, $password)
    {
        // create customer
        $customer = Customer::create($parameters);
        Cart::create(['customer_id' => $customer->id]);
        $avatar_path = null;

        if ($avatar) {
            $extention = $avatar->getClientOriginalExtension();
            $avatar = $this->resizeImage($avatar->getRealPath(), AVATAR_WIDTH);
            $avatar_path = $this->uploadFileByStream($avatar, CUSTOMER_DIR . '/' . $customer->id . '/' . Str::random(25) . '.' . $extention);
        }

        $customer->update([
            'avatar' => $avatar_path
        ]);
        $customer->password = $password;

        event(new RegisterCustomer($customer, $password));
    }
}

?>
