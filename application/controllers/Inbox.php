<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inbox extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('M_Inbox');
	}


	//ini customer
	// public function index()
	// {
	// 	$detilPesan = $this->M_Inbox->detilPesan();
	// 	$pemilik = $this->M_Inbox->getPemilik();
	// 	$pesan = $this->M_Inbox->getAllPesan();
	// 	$data = [
	// 		'detilPesan' => $detilPesan,
	// 		'pemilik' => $pemilik,
	// 		'pesan' => $pesan
	// 	];
	//     $this->load->view('template/header');
	//     $this->load->view('InboxCustomer',$data);
	//     $this->load->view('modalInbox/customer/EntryPesan',$data);
	//     $this->load->view('modalInbox/customer/LihatPesan',$data);
	//     $this->load->view('modalInbox/customer/HapusPesan',$data);
	//     $this->load->view('template/footer');
	// }

	//ini pemilik
	public function index()
	{
		$merge = $this->M_Inbox->getMerge();
		$detilPesan = $this->M_Inbox->detilPesan();
		$customer = $this->M_Inbox->getCustomer();
		$pesan = $this->M_Inbox->getAllPesan();
		$data = [
			'merge' => $merge,
			'detilPesan' => $detilPesan,
			'customer' => $customer,
			'pesan' => $pesan
		];
	    $this->load->view('template/header');
	    $this->load->view('InboxPemilik',$data);
	    $this->load->view('modalInbox/pemilik/LihatPesan',$data);
	    $this->load->view('modalInbox/pemilik/balasPesan',$data);
	    $this->load->view('modalInbox/pemilik/prosesPesan',$data);
	    $this->load->view('template/footer');
	}

	public function kirimPesan()
	{
		$idpesan = $this->input->post('idpesan');
		$tglpesan = $this->input->post('tglpesan');
		$penerima = $this->input->post('penerima');
		$jenispesan = $this->input->post('jenispesan');
		$isipesan = $this->input->post('isipesan');

		$tglpesan = date("Y/m/d");

		$status = "Submitted";

		$data = array(
			'idpesan' => $idpesan,
			'iduser' =>$penerima,
			'tglpesan'=> $tglpesan,
			'jenispesan' =>$jenispesan,
			'isi' => $isipesan,
			'status' => $status
		);

		$result = $this->M_Inbox->InsertPesan($data);

		$data = NULL;
		if ($result){
			$this->session->set_flashdata('pesan','Pesan Berhasil Dikirim');
	   		redirect('Inbox');
		}else{
			$this->session->set_flashdata('pesanGagal','Pesan Tidak Berhasil Disimpan');
    		redirect('Inbox');
		}
	}

	public function hapusPesan($idpesan)
	{
		$this->M_Inbox->deletePesan($idpesan);
		$this->session->set_flashdata('pesan','Pesan Berhasil Dihapus');
		redirect('Inbox');
	}


////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////PEMILIK//////////////////////////////////////////////////////


	public function prosesPesan()
	{
		$idpesan = $this->input->post('iduser');

		$status = "On Process";

		$data = array(
			'status' => $status
		);

		$result = $this->M_Inbox->prosesPesan($idpesan,$data);

		$data = NULL;
		if (!$result){
			$this->session->set_flashdata('pesan','Pesan Berhasil Diproses');
	   		redirect('Inbox');
		}else{
			$this->session->set_flashdata('pesanGagal','Pesan Tidak Berhasil Diproses');
    		redirect('Inbox');
		}	
	}

	public function balasPesan()
	{
		$idpesan = $this->input->post('idpesan');
		$tglpesan = $this->input->post('tglpesan');
		$penerima = $this->input->post('penerima');
		$jenispesan = $this->input->post('jenispesan');
		$isipesan = $this->input->post('isipesan');

		$tglpesan = date("Y/m/d");

		$status="Submitted";

		$data = array(
			'idpesan' => $idpesan,
			'iduser' =>$penerima,
			'tglpesan'=> $tglpesan,
			'jenispesan' =>$jenispesan,
			'isi' => $isipesan,
			'status' => $status
		);

		$result = $this->M_Inbox->InsertPesan($data);

		$data = NULL;
		if ($result){
			$this->session->set_flashdata('pesan','Pesan Berhasil Dikirim');
	   		redirect('Inbox');
		}else{
			$this->session->set_flashdata('pesanGagal','Pesan Tidak Berhasil Disimpan');
    		redirect('Inbox');
		}
	}

}
