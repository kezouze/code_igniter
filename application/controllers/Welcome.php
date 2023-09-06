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
        $data['likeBtnColor'] = "#2f4f4f";
        if (isConnected() && isset($_SESSION['id_user'])) {
            $data['isLiked'] = $this->Pros_model->isLiked($_SESSION['id_user'], $data['id']);
            if ($data['isLiked'] == 1) {
                $data['likeBtnColor'] = "#0964cc";
            } else if ($data['isLiked'] == 0) {
                $data['likeBtnColor'] = "#2f4f4f";
            }
        }

        if (!$data['all_data'] || !is_numeric($data['id']) || $data['id'] < 1 || !$data['name']) {
            redirect('/Welcome/quatreCentQuatre');
            return;
        }

        $this->load->view('espace_salons/details_salon', $data);
    }

    public function likes()
    {
        $id_pro = $_GET['id'];

        if (isset($_SESSION['id_user'])) {
            $id_user = $_SESSION['id_user'];
            $isLineLike = $this->Pros_model->count_isLiked($id_user, $id_pro);
        } else {
            $id_user = null;
            $isLineLike = 0;
        }

        if (!isConnected() || $_SESSION['type'] !== "client" || $id_user == null) {
            $response = array(
                'likes' => $this->Pros_model->get_all_where_id($id_pro)[0]->likes,
                'redirect' => true
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {

            // Gère l'ajout de like si l'utilisateur n'a pas encore liké
            if ($isLineLike == 0) {
                $this->Pros_model->set_new_line_likes($id_user, $id_pro, 1);
                $this->Pros_model->set_pro_likes_up($id_pro);
                $response = array(
                    'likes' => $this->Pros_model->get_all_where_id($id_pro)[0]->likes,
                    'color' => "#0964cc"
                );
                header('Content-Type: application/json');
                echo json_encode($response);
            } else {
                $isLiked = $this->Pros_model->isLiked($id_user, $id_pro);
                // Gère le cas où l'utilisateur a déjà liké
                if ($isLiked == 0) {
                    $this->Pros_model->set_pro_likes_up($id_pro);
                    $this->Pros_model->set_liked($id_user, $id_pro, 1);
                    $response = array(
                        'likes' => $this->Pros_model->get_all_where_id($id_pro)[0]->likes,
                        'color' => "#0964cc"
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
                // Gère le cas où l'utilisateur veut retirer son like
                else if ($isLiked == 1) {
                    $this->Pros_model->set_pro_likes_down($id_pro);
                    $this->Pros_model->set_liked($id_user, $id_pro, 0);
                    $response = array(
                        'likes' => $this->Pros_model->get_all_where_id($id_pro)[0]->likes,
                        'color' => "#2f4f4f"

                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }
        }
    }

    public function quatreCentQuatre()
    {
        $this->load->view('404');
    }

    public function about()
    {
        $this->load->view('about');
    }

    public function prestations()
    {
        $data['name'] = $this->Pros_model->get_all_where_id($_GET['id'])[0]->name;
        $data['all_prestas'] = $this->Pros_model->get_prestas_where_id_pro($_GET['id']);

        $this->load->view('espace_salons/info_prestations', $data);
    }
}
