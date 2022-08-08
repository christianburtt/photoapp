<?php

namespace App\Controllers;

use Google_Client;

class Home extends BaseController
{
    public function index(){
            helper('form');
    
            if (!$this->session->logged_in) {
                echo view('outheader.php');
                echo view('login.php');
                return view('outfooter.php');
                // die();
            } else {
    
                return view('welcome_message.php');
                // echo view('header.php');
                // echo view('nav.php');
                // echo view('homesidebar.php');
                // echo view('home/dashboard.php');
                // return view('footer.php');
            }
        }   

    
    public function register(){
        if(!$this->request->getPost('submitting')){
            helper('form');
        
            echo view('outheader.php');
            echo view('register.php');
            return view('outfooter.php');
        }else{
            //it's been submitted.
            $data['err']=[];

            //manual validation
            if(!$this->validate([
                'name'=>'required',
                'email'=>'required|valid_email|is_unique[users.email]',
                'pw'=>'required|min_length[8]|'
            ],[
                'name'=>[
                    'required'=>'Nume și Prenume sunt necesar.'
                ],
                'email'=>[
                    'required'=>'Email e necesar.',
                    'valid_email'=>'Email e format gresit',
                    'is_unique'=>'Email e deja folosit'
                ],
                'pw'=>[
                    'required'=>'Parola e necesar',
                    'min_length'=>'Minim 8 litere/numere'
                ]
            ])){
                $data['err'] = $this->validator->getErrors();
                $this->validator->reset();
                log_message('debug',print_r($data['err'],true));
                helper('form');

                echo view('outheader.php');
                echo view('register.php',$data);
                return view('outfooter.php');
            }
            $userModel = new \App\Models\UserModel();
            $u_id = $userModel->add_user($this->request->getPost('name'),
                substr($this->request->getPost('email'),0,stripos($this->request->getPost('email'),"@")),
                $this->request->getPost('email'),$this->request->getPost('pw'),5);
            $data['code'] = $userModel->getVerficationCode($u_id);
            if($u_id ){
                if($userModel->sendVerification($u_id, view('verification_email.php',$data))){
                    return redirect()->to('/');

                }
                echo "Error sending email.";
            }
            echo "Error creating user";
            
            // return view('welcome_message.php');
            // echo view('header.php');
            // echo view('nav.php');
            // echo view('welcome.php',$data);
            // return view('footer.php');
            
        }
        
    }

    public function verify($code){
        // log_message('debug',print_r($code));
        $userModel = new \App\Models\UserModel();
        $data['user'] = $userModel->verifyUser($code);
        echo view('outheader.php');
        echo view('verify_done.php',$data);
        return view('outfooter.php');
    }

    public function googleLogin(){
        $client = new Google_Client(['client_id'=>'280987633492-vggneilvh8a3d7c0jtdoikqjpm40k6ca.apps.googleusercontent.com']);
        $payload = $client->verifyIdToken($this->request->getPost('credential'));
        if($payload){
            print_r($payload);
            $userModel = new \App\Models\UserModel();
            
            $this->session->user = $userModel->verifyGoogleUser($payload['email'],$payload['name']);
            if($this->session->user !== null) {
                $this->session->logged_in = true;
                return redirect()->to('/');
            }else{
                
            }
        }else{
            die("error with google");
        }
    }


    public function login() {
        $userModel = new \App\Models\UserModel();
        $email = $this->request->getPost('email');
        $pw = $this->request->getPost('password');
        $user = $userModel->login($email, $pw);

        if ($user) {
            $this->session->logged_in = true;
            $this->session->user = $user;           
           
        }
        return redirect()->to('/');
    }

    public function logout() {
        //$this->Log_model->access_log($this->session->email, "logout");
        $this->session->logged_in = false;
        $this->session->destroy();
        return redirect()->to('/');
    }
}
