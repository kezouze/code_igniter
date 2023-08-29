<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function index()
    {
        $this->load->view('welcome');
    }

    public function deconnect()
    {
        session_destroy();
        redirect('Welcome/');
    }

    public function infos()
    {
        $data['all_data'] = $this->Pros_model->get_all();
        $this->load->view('espace_salons/info_salon', $data);
    }

    public function details()
    {
        $data['id'] = $_GET['id'];
        $data['all_data'] = $this->Pros_model->get_all_where_id($_GET['id']);
        $data['name'] = $data['all_data'][0]->name;
        $data['likes'] = $data['all_data'][0]->likes;

        if (!$data['all_data'] || !is_numeric($data['id']) || $data['id'] < 1 || !$data['name']) {
            redirect('/Welcome/quatreCentQuatre');
            return;
        }

        $this->load->view('espace_salons/details_salon', $data);
    }

    public function likes()
    {
        $id_pro = $_GET['id'];
        $isLiked = $this->Pros_model->isLiked($_SESSION['id'], $id_pro);

        if (isConnected() && !$isLiked && $_SESSION['type'] == 'client') {
            $this->Pros_model->set_nb_likes($id_pro, $_SESSION['id']);
            $response = array(
                'likes' => $this->Pros_model->get_all_where_id($id_pro)[0]->likes // Ça marche somehow
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // la redirection ne marche pas
            redirect('Users/');
            // die();
            // header('Location: http://[::1]/coiffhair/Welcome/');
        }
    }

    public function quatreCentQuatre()
    {
        $this->load->view('404');
    }
}
