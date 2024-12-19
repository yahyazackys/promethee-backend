<?php

namespace App\Http\Controllers;

use App\Models\CalonPelaksana;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('user.index', compact('data'));
    }

    public function create()
    {
        $data = User::all();
        return view('user.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:4',
            'no_hp' => 'nullable|min:4|max:14',
            'role' => 'required',
        ], [
            'name.required' => 'Nama harus diisi!',
            'email.required' => 'Email harus diisi!',
            'password.required' => 'Password harus diisi!',
            'no_hp.required' => 'No HP harus diisi!',
            'role.required' => 'Role harus diisi!',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'role' => $request->role,
            ]);

            CalonPelaksana::create([
                'nama' => $request->name,
                'email' => $request->email,
            ]);

            return redirect()->route('user')->with('success', 'Tambah Data Berhasil!');
        } catch (\Illuminate\Database\QueryException $error) {
            $errorMessage = $error->getMessage();
            return redirect()->back()->with('error', 'Tambah Data Gagal! ' . $errorMessage);
        } catch (Exception $error) {
            return redirect()->back()->with('error', 'Tambah Data Gagal!');
        }
    }

    public function edit($id)
    {
        $data = User::find($id);
        return view('user.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'nullable|min:4',
            'no_hp' => 'nullable|min:4|max:14',
            'role' => 'required',
        ], [
            'name.required' => 'Nama harus diisi!',
            'email.required' => 'Email harus diisi!',
            'password.min' => 'Password minimal 4 karakter!',
            'no_hp.min' => 'No HP minimal 4 karakter!',
            'no_hp.max' => 'No HP maksimal 14 karakter!',
            'role.required' => 'Role harus diisi!',
        ]);

        try {
            $data = User::find($id);

            // Hash password baru jika diisi
            $newPassword = $data->password; // gunakan password lama jika tidak ada input password baru
            if ($request->password) {
                $newPassword = Hash::make($request->password);
            }

            // Update data pengguna
            $data->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $newPassword,
                'no_hp' => $request->no_hp,
                'role' => $request->role,
            ]);

            return redirect()->route('user')->with('success', 'Update Data Berhasil!');
        } catch (Exception $error) {
            return redirect()->back()->with('error', 'Update Data Gagal!');
        }
    }

    public function delete($id)
    {
        try {
            User::destroy($id);
            return redirect('user');
        } catch (Exception $error) {
            return redirect()->back()->with('failed', $error->getMessage());
        }
    }
}