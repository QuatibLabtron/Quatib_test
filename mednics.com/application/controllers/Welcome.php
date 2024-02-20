<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('image_lib');
        $this->load->helper('pdf_helper');
        $this->load->library('email');
        //$this->load->library('email');
        $this->load->library('email');
    }
	public function index()
	{
		$this->load->view('welcome_message');
	}  
    function pdf()
    {
        $data['name']="rajakumar";   
        $this->load->view('pdfreport', $data);
    }
    public function create_user(){
        $this->load->view('create_user');
    }
    public function store_user(){ 
        $email=$this->input->post('email');
        $password=$this->input->post('pwd');
        $data=array('email'=>$email,'password'=>$password);
        //print_r($data);exit();
        $this->db->insert('users',$data);
        $result=$this->db->insert_id();
        
        $this->email->from('quatib@labo.best', 'test');
        $this->email->to('quatib@labo.best');
        //$this->email->cc('another@another-example.com');
        //$this->email->bcc('them@their-example.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send();  
        
        if($result){
            echo "success";
        }
    } 
    public function user_index(){
        try
        {
            $data['user'] = $this->db->get('users')->result();
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
            catch (\Exception $e)
        {
            die($e->getMessage());
        } 
    }
}