<?php namespace App\SystemOperations;

use Auth;
use App\Requisition;


class RequisitionNumberGenerator
{

    public function generateRequisitionNumber($service)
    {

        do {
            $institution_code = Auth::user()->institution->code;
            $digits_limit = 2;
            $current_date = date("Y");
            $random_digits = str_pad(rand(0, pow(10, $digits_limit) - 1), $digits_limit, '0', STR_PAD_LEFT);
            $requi_no = $service . $institution_code . $current_date .$random_digits;

            $requisition_no_exist = \App\InternalRequisition::where('requisition_no', $requi_no)->first();
        } while (!empty($requisition_no_exist));

        return $requi_no ;
    }
}
