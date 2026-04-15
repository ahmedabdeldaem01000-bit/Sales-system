<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class RestoreController extends Controller
{
 public function print($id) {
    $order = Order::with(['items.product', 'employee'])->findOrFail($id);
    return view('inventory', compact('order'));
}
public function restoreProducts(){
    $users=User::with('order');
    return view('restore',compact('users'));
}
}
// 