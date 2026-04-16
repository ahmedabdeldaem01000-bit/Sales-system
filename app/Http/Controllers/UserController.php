<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);
        return redirect()->route('user.create')->with('success', 'تم انشاء المستخدم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (!empty($user)) {
            return view('pages.user.edit');
        } else {
            return redirect()->route('user.create')->with('error', 'خطاء في المستخدم ');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!empty($id)) {
            $user = User::findOrFail($id);

            return view('pages.user.edit', compact('user'));
        } else {
            return redirect()->route('user.create')->with('error', 'خطاء في المستخدم ');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $user= User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address']
        ]);
           return redirect()->route('user.index')->with('success', 'تم التعديل  بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
            $ids = $request->input('user'); // نتأكد إن الاسم متطابق مع الفورم

        if ($ids && is_array($ids)) {
            User::whereIn('id', $ids)->delete();
            return redirect()->route('user.index')->with('success', 'تم حذف العملاء المحددة بنجاح');
        }

        return redirect()->route('user.index')->with('error', 'لم يتم تحديد العملاء للحذف');

    }
     
}
