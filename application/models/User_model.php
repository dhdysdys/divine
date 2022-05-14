<?php
    class User_model extends CI_MODEL{
        
        public function __construct(){
            $this->load->database();
        }

        public function get(){
            $this->db->from('dataUser');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function check_user($where=array()){
            $this->db->from('dataUser');
            $this->db->select('*');
            if(!empty($where)) $this->db->where($where);
            $query = $this->db->get();

            return $query->result();
        }

        public function get_user_without_admin(){
            $this->db->from('dataUser');
            $this->db->select('*');
            $this->db->where('namaUser != "admin"');
            $query = $this->db->get();

            return $query->result();
        }

        public function add_user($data){
            $this->db->insert('dataUser', $data);
        }

        public function delete_user($id){
            $this->db->where('kodeAdmin', $id);
            $this->db->delete('dataUser');
        }
    }