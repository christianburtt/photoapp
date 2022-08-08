<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Models for user
 * @package App\Models
 */
class UserModel extends Model {

    protected $db;
    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->db = \Config\Database::connect();
    }


    /**
     *function get_user()
     *
     *This function retrieves a user from the DB based on user ID#
     *
     *@param int $u_id the ID# of the user
     *@return object the user object or null
     */
    public function get_user($u_id = '') {
        //there is no user with ID# 0
        if ($u_id == '') return NULL;

        //get the info from the DB and return it.
        $builder = $this->db->table('users');
        $builder->where('u_id', $u_id);
        $result = $builder->get()->getRow();

        return $result;
    }


    /**
     *function add_user()
     *
     *adds a user to the DB
     *
     * @param string name
     *@param string username
     *@param string email
     *@param string password
     *@param int access level
     *@return string new user ID
     */
    public function add_user($name, $username, $email, $password, $access) {
        if ($name == '') return '';
        $pw = password_hash($password, PASSWORD_DEFAULT); //more secure
        $u_id = uniqid();
        $data = array(
            'u_id' => $u_id,
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'pw' => $pw,
            'access' => $access
        );
        $this->db->table('users')->insert($data);

        $d2 = [
            'user_id'=>$u_id,
            'verification_string'=>hash('sha512',$u_id)
        ];
        $this->db->table('user_verification')->insert($d2);
            
            
        return $u_id;
    }

    /**
     * Send verification Email
     * sends a validation email to the requested user
     * @param string user ID
     * @param string html email text
     * @return bool true on successful send
     */
    public function sendVerification($u_id, $email_html){
        $user = $this->db->table('users')->where('u_id',$u_id)->get()->getRow();
        // $verify_string = $this->db->table('user_verification')->where('user_id',$u_id)->get()->getRow();
        $email = \Config\Services::email();

        /**
         * TBD
         * update with SMTP / email settings from new server
         * 
         */
        $config = array(
            'mailType'=>'html',
            'protocol'=>'smtp',
            'SMTPHost'=>'kleinburtts.com',
            'SMTPUser'=>'christian@kleinburtts.com',
            'SMTPPass'=>'Addysen08',
            'SMTPPort'=>465,
            'SMTPCrypto'=>'TLS'
        );
        $email->initialize($config);
        $email->setFrom('christian@kleinburtts.com', 'Verify');
        $email->setTo($user->email);
        
        $email->setSubject('Verify Email Test');
        $email->setMessage($email_html);
        
        $didSend = $email->send();
        
        // log_message('debug','Sending email error: '.$email->printDebugger());
        return $didSend;
    }

    /**
     * get verification code
     * this code goes into the verification email
     * @param string user ID
     * @return string verification code
     */
    public function getVerficationCode($u_id){
        $user_verify = $this->db->table('user_verification')->where('user_id',$u_id)->get()->getRow();
        return $user_verify->verification_string;
    }

    /**
     * verifies user in DB
     * @param string verification code
     * @return object user on success
     */
    public function verifyUser($code){

        $codeCheck = $this->db->table('user_verification')->where('verification_string',$code)->get()->getRow();
        if(!$codeCheck) return null;
        $this->db->table('users')->where('u_id',$codeCheck->user_id)->set('verified',1)->update();
        $this->db->table('user_verification')->where('uv_id',$codeCheck->uv_id)->delete();

        return $this->get_user($codeCheck->user_id);
    }

    /**
     *function login()
     *
     *This function facilitates the login of a user.
     *
     *@param string $email the full email address of the user
     *@param string $password the plain-text password of the user
     *@return object the user object if it matches or null
     */
    function login($email, $password) {

        //check for the email match first
        $builder = $this->db->table('users');
        $builder->where('email', $email);
        $builder->orWhere('username', $email);
        $builder->limit(1);

        $resultdb = $builder->get()->getRow();
        //if we have a match, return the user object
        if ($resultdb != null) {

            //check for password first

            if (password_verify($password, $resultdb->pw)) {
                //$this->Log_model->access_log($email,'login');
                // log_message('debug','Logged in');

                return $resultdb; //done!
            } else {
                //the new password exists, but it doesn't match
                //error_log('newpw does note match');
                //$this->Log_model->access_log($email,'denied');
                log_message('debug', 'Bad PW');

                return null;
            }
        } else {
            //error_log('No User Found');
            //no user with that username/email
            //$this->Log_model->access_log($email,'denied');
            log_message('debug', 'User not found');

            return null;
        }
    }

    /**
     * function list_users()
     *
     * Returns a list of all users in the DB
     *
     *@param string access filter optional
     *@return array of objects for all users
     */
    public function list_users($access_filter = '') {
        //$this->db->select('u_id, email, access');
        $builder = $this->db->table('users');
        if ($access_filter != '') $builder->like('access', $access_filter);
        $query = $builder->get();
        $all_users = $query->getResult();

        return $all_users;
    }

   
    /**
     * update user
     * udpates all parts
     * 
     * @param user id
     * @param name
     * @param username
     * @param email
     * @param access level
     * @param office id
     * @return affected rows
     * 
     */
    public function update_user($user_id, $name, $uname, $email, $access) {
        if (!$user_id) return 0;

        $data = array(
            'name' => $name,
            'username' => $uname,
            'email' => $email,
            'access' => $access
        );
        $builder = $this->db->table('users');
        $builder->where('u_id', $user_id);
        $builder->update($data);
        return $this->db->affectedRows();
    }


    /**
     *function update_pw
     *
     * updates users password
     *
     *@param int u_id user id
     *@param string pw password, plain text
     *@return bool true on success
     */
    public function update_pw($u_id, $pw) {
        if ($u_id == 0) return false;
        //$pw = sha1("M1ha1".$pw);
        $pw = password_hash($pw, PASSWORD_DEFAULT);
        $data = array('pw' => $pw);
        $builder = $this->db->table('users');
        $builder->where('u_id', $u_id);
        $builder->update($data);
        return true;
    }

    /**
     * function update_email
     *
     * updates users email
     *
     *@param int u_id user id
     *@param string email, email
     *@return bool true on success
     */
    public function update_email($u_id, $email) {
        if ($u_id == 0) return false;
        if (!$email) return false;

        $data = array('email' => $email);
        $builder = $this->db->table('users');

        $builder->where('u_id', $u_id);
        $builder->update($data);
        return true;
    }

    /**
     * function update_access
     *
     * changes user's access level
     *
     *@param int u_id user id
     *@param int access users new access
     *@return bool true on success
     */
    public function update_access($u_id, $access) {
        if ($u_id == 0) return false;
        $data = array('access' => $access);
        $builder = $this->db->table('users');

        $builder->where('u_id', $u_id);
        $builder->update($data);
        return true;
    }
}
