<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Exception;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return view('job.index', compact('jobs'));
    }

    public function create()
    {
        $jobs = Job::all();

        return view('job.create', compact('jobs'));
    }

    // insert data to table
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pekerjaan' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'status' => 'required|in:0,1',
        ]);
    
        Job::create($validatedData);
        return redirect()->route('job')->with('success', 'Data Jobs Berhasil Ditambahkan!');
    }
    

    public function edit($id)
    {
        $jobs = Job::find($id);
    
        // tampilkan form edit dan kirim datanya
        return view('job.edit', compact('jobs'));
    }
    

    // update data selected
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:jobs,id',
            'nama_pekerjaan' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'status' => 'required|in:0,1',
        ]);
    
        $jobs = Job::find($request->id);
        $jobs->update($validatedData);
    
        return redirect()->route('job')->with('success', 'Data Jobs Berhasil Diperbarui!');
    }
    
    public function delete($id)
    {
        // query/perintah hapus data berdasarkan id
        Job::find($id)->delete();

        // kembalikan ke halaman users
        return redirect()->route('job')->with('success', 'Data Jobs Berhasil Dihapus!');
    }
}