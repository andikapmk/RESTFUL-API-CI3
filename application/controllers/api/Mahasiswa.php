<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';

class Mahasiswa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mahasiswa');
    }
    public function index_get()
    {
        $id = $this->get('id');

        if ($id === null) {
            $mahasiswa = $this->mahasiswa->getMahasiswa();
        } else {

            $mahasiswa = $this->mahasiswa->getMahasiswa($id);
        }

        if ($mahasiswa) {
            $this->response(
                [
                    'status' => true,
                    'data siswa' => $mahasiswa
                ],
                REST_Controller::HTTP_OK
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'message' => 'id tidak ditemukan.'
                ],
                REST_Controller::HTTP_NOT_FOUND
            );
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response(
                [
                    'status' => false,
                    'message' => 'provide an id!'
                ],
                REST_Controller::HTTP_BAD_REQUEST
            );
        } else {

            if ($this->mahasiswa->deleteMahasiswa($id)) {

                $this->response(
                    [
                        'status' => true,
                        'message' => 'deleted.',
                        'id' => $id
                    ],
                    REST_Controller::HTTP_OK
                );
            } else {

                $this->response(
                    [
                        'status' => false,
                        'message' => 'id not found !'
                    ],
                    REST_Controller::HTTP_BAD_REQUEST
                );
            }
        }
    }
    public function index_post()
    {
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];
        if ($this->mahasiswa->createMahasiswa($data) > 0) {
            $this->response(
                [
                    'status' => true,
                    'message' => 'new data siswa created !'
                ],
                REST_Controller::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'message' => 'failed data siswa created !'
                ],
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];
        if ($this->mahasiswa->updateMahasiswa($data, $id) > 0) {
            $this->response(
                [
                    'status' => true,
                    'message' => 'new data siswa updated !'
                ],
                REST_Controller::HTTP_CREATED
            );
        } else {
            $this->response(
                [
                    'status' => false,
                    'message' => 'failed data siswa updated !'
                ],
                REST_Controller::HTTP_BAD_REQUEST
            );
        }
    }
}
