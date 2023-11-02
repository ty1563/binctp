<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseExport;
use App\Purchase;


class ExcelController extends Controller
{
    public function downloadPurchase($purchaseId)
    {
        $purchase = Purchase::findOrFail($purchaseId);
        return Excel::download(new PurchaseExport($purchase), 'purchase_' . $purchaseId . '.xlsx');
    }
}
