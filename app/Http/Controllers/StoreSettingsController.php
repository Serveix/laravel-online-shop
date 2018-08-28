<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StoreSetting;

class StoreSettingsController extends Controller
{
    function show()
    {
        return view('hk.storeSettings')
                ->with('usdMxnExchangeRate', StoreSetting::dailyUsdMxn())
                ->with('ownExchangeRate', StoreSetting::find('exchange_rate'))
                ->with('itemRevenue', StoreSetting::find('item_revenue'))
                ->with('ivaValue', StoreSetting::find('iva_value'));
    }
    
    function update(Request $request)
    {
        $this->validate($request, [
        'ownExchangeRate' => 'required',
        'revenue' => 'required',
        'ivaValue' => 'required',
        ]);
        
        $ownExchangeRate = StoreSetting::findOrFail('exchange_rate');
        $revenue    = StoreSetting::findOrFail('item_revenue');
        $ivaValue   = StoreSetting::findOrFail('iva_value');
        
        $ownExchangeRate->value  = $request->input('ownExchangeRate');
        $ownExchangeRate->save();
        
        $revenue->value  = $request->input('revenue');
        $revenue->save();
        
        $ivaValue->value = $request->input('ivaValue');
        $ivaValue->save();
        
        return back()->withInput()->with('savedChanges', true); // redirect user back to page
        
    }
}
