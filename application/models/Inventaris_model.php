<?php
    class Inventaris_model extends CI_MODEL{
        
        public function __construct(){
            $this->load->database();
        }

        public function get($id=null){
            if(!empty($id)) $this->db->where('kodeAlat', $id);
            $this->db->from('dataAlat');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function add_alat($data){
            $this->db->insert('dataAlat', $data);
        }

        public function edit_alat($data,$id){
            $this->db->where('kodeAlat', $id);
            $this->db->update('dataAlat', $data);
        }

        public function delete_alat($id){
            $this->db->where('kodeAlat', $id);
            $this->db->delete('dataAlat');
        }
    }