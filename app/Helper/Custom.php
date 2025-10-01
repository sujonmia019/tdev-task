<?php

use App\Constants\Role;
use Illuminate\Support\Facades\Storage;

define('PLAN_IMAGE_PATH','plan');
define('CURRENCY',[
    'USD' => '$',
    'EUR' => '€',
    'GBP' => '£',
    'JPY' => '¥',
    'INR' => '₹',
    'KRW' => '₩',
    'RUB' => '₽',
    'TRY' => '₺',
    'VND' => '₫',
    'NGN' => '₦',
    'BRL' => 'R$',
    'CAD' => 'C$',
    'AUD' => 'A$',
    'NZD' => 'NZ$',
    'CHF' => 'CHF',
    'AED' => 'د.إ',
    'SAR' => '﷼',
]);
define('PAYMENT_GATEWAY',[
    'stripe' => 'Stripe',
    'paypal' => 'Paypal'
]);

if(!function_exists('userVerifiedLabel')){
    function userVerifiedLabel($isVerified){
        if($isVerified){
            return '<span class="badge bg-label-primary me-1">Verified</span>';
        }
        return '<span class="badge bg-label-danger me-1">Not-Verified</span>';
    }
}

if(!function_exists('otpCode')){
    function otpCode(){
        $otp = rand(100000, 999999);
        return $otp;
    }
}

if(!function_exists('userRoleRoute')){
    function userRoleRoute(){
        $role = auth()->user()->role;
        if($role === Role::ADMIN_ROLE){
            return route('admin.dashboard');
        }
        return route('user.dashboard');
    }
}

if(!function_exists('dateFormat')){
    function dateFormat($date, $format = 'd-m-Y h:i a'){
        return date($format, strtotime($date));
    }
}

if (!function_exists('tableImage')) {
    function tableImage($image, $name, $class = null, $style = null){
        $style_data = $style != null ? $style : 'width: 60px';
        return $image ? "<img src='".filePath($image)."' class='".$class."' alt='".$name."' style='".$style_data."'/>"
        : "<img src='".asset('/')."assets/img/default.svg' alt='Default Image' style='width:40px;'/>";
    }
}

if (!function_exists('filePath')) {
    function filePath($path, $disk = 'public'){
        if(app()->environment('production')){
            return asset('public/storage/'.$path);
        }
        return Storage::disk($disk)->url($path);
    }
}
