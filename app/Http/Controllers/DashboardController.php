<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function view(User $user)
    {
        $userData = User::With(['grade'])->get();
        return view('dashboard.dashboard', compact('userData'));
    }
    public function viewAdd(Grade $grade)
    {    $gradeData = $grade->get();
        return view('dashboard.add-user',compact('gradeData'));
    }
    public function add(Request $request, User $user)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user->create($data);
        return redirect(route('dashboard.view'))->with('success', 'Data user berhasil ditambahkan');
    }
    public function viewEdit(User $user, Grade $grade)
    {   $gradeData = $grade->get();
        return view('dashboard.edit-user', compact('user','gradeData'));
    }
    public function edit(Request $request, User $user)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user->update($data);
        return redirect(route('dashboard.view'))->with('success', 'Data user berhasil diubah');
    }
    public function delete(User $user,)
    {
        $user->delete();
        return redirect(route('dashboard.view'))->with('success', 'Data user berhasil diubah');
    }

    public function loginView()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }



        return redirect()->back();
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        return redirect()->intended('/login');
    }
}
