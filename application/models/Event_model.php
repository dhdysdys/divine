<?php
    class Event_model extends CI_MODEL{
        
        public function __construct(){
            $this->load->database();
        }

        public function get($id=null){
            if(!empty($id)) $this->db->where('kodeEvent', $id);
            $this->db->from('dataEventBaru');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function add_event($data){
            $this->db->insert('dataEventBaru', $data);

            return $this->db->insert_id();
        }

        public function add_alat_event($data){
            $this->db->insert('dataTransaksiAlatEvent', $data);

            return 1;
        }

    }