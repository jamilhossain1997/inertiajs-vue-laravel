<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SMS\SmsProvider;

class SmsController extends Controller {
    protected $smsProvider;

    public function __construct(SmsProvider $smsProvider)
    {
        $this->smsProvider = $smsProvider;
    }

    public function send(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
            'country_code' => 'required|string', 
        ]);

        $phone = $request->input('phone');
        $message = $request->input('message');
        $countryCode = strtoupper($request->input('country_code'));

        try {
            $success = $this->smsProvider->send($countryCode, $phone, $message);

            if ($success) {
                return response()->json(['success' => true, 'message' => 'SMS sent successfully.']);
            }

            return response()->json(['success' => false, 'message' => 'Failed to send SMS.'], 500);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
