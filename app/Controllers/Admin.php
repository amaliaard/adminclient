<?php

namespace App\Controllers;


class Admin extends BaseController
{
    
    public function index()
    {
        // URL API untuk mengambil data admin
        $url = 'https://latihan-url.aksi-pintar.com/api/admin';

        $client = \Config\Services::curlrequest();

        try {
            $response = $client->request('GET', $url);
            $data['admin'] = json_decode($response->getBody(), true); // Mengambil data admin dari API

            // Jika ingin menyimpan data ke database
            foreach ($data['admin'] as $adminData) {
                // Anda bisa memeriksa apakah data sudah ada di database, jika belum, simpan
                $existingAdmin = $this->adminModel->where('id_admin', $adminData['id_admin'])->first();
                if (!$existingAdmin) {
                    $this->adminModel->save($adminData); // Simpan data admin baru
                }
            }

            return view('admin', $data);
        } catch (\Exception $e) {
            // Jika terjadi error, kirim error ke view
            return view('admin', ['error' => $e->getMessage(), 'admin' => []]); // Tambahkan 'admin' sebagai array kosong
        }
    }

    public function tambahadmin()
    {
        return view('tambah-admin'); // Tampilkan form untuk tambah admin
    }

    public function sendData()
    {
        $data = [
            'id_admin' => $this->request->getPost('id'),
            'nama_admin' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash password untuk keamanan
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'role' => $this->request->getPost('role'),
        ];

        // Simpan data ke database
        $this->adminModel->save($data);
        return redirect()->to('/admin')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $data['admin'] = $this->adminModel->find($id); // Ambil data admin berdasarkan ID

        if (!$data['admin']) {
            return redirect()->to('/admin')->with('error', 'Admin tidak ditemukan.');
        }

        return view('edit-admin', $data); // Tampilkan form untuk edit admin
    }

    public function editadmin()
    {
        $data = [
            'id_admin' => $this->request->getPost('id'),
            'nama_admin' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash password
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'role' => $this->request->getPost('role'),
        ];

        // Update data di database
        $this->adminModel->update($this->request->getPost('id'), $data);
        return redirect()->to('/admin')->with('success', 'Data berhasil diperbarui!');
    }

    public function hapus($id)
    {
        // Hapus data dari database
        $this->adminModel->delete($id);
        return redirect()->to('/admin')->with('success', 'Admin berhasil dihapus!');
    }
}
