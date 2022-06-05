<?php
    class Pengajuan_alat_model extends CI_MODEL{
        
        public function __construct(){
            $this->load->database();
        }

        public function get_list(){
            $this->db->from('dataAlatBaru');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function get($id=null){
            if(!empty($id)) $this->db->where('kodeAlat', $id);
            $this->db->from('dataAlatBaru');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function check_alat($namaAlat=null){
            if(!empty($kodeAlat)) $this->db->where('namaAlat', $namaAlat);
            $this->db->from('dataAlatBaru');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function get_reject_note($namaAlat){
            $this->db->where('status = 2 AND namaAlat LIKE "'.$namaAlat.'"');
            $this->db->from('dataAlatBaru');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function add_pengajuan($data){
            $this->db->insert('dataAlatBaru', $data);
        }

        public function edit_pengajuan($data,$id){
            $this->db->where('kodeAlat', $id);
            $this->db->update('dataAlatBaru', $data);
        }

        public function delete_pengajuan($id){
            $this->db->where('kodeAlat', $id);
            $this->db->delete('dataAlatBaru');
        }
    }