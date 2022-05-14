<?php
    class Pengajuan_alat_model extends CI_MODEL{
        
        public function __construct(){
            $this->load->database();
        }

        public function get_list(){
            $this->db->from('dataPengajuanAlat dp');
            $this->db->select('dp.kodePengajuan, da.namaAlat, dp.hargaAlat, dp.status, dp.alasan');
            $this->db->join('dataAlat da', 'da.kodeAlat = dp.kodeAlat');
            $query = $this->db->get();

            return $query->result();
        }

        public function get($id=null){
            if(!empty($id)) $this->db->where('dp.kodePengajuan', $id);
            $$this->db->from('dataPengajuanAlat dp');
            $this->db->select('dp.kodePengajuan, da.kodeAlat, da.namaAlat, dp.hargaAlat, dp.status, dp.alasan');
            $this->db->join('dataAlat da', 'da.kodeAlat = dp.kodeAlat');
            $query = $this->db->get();

            return $query->result();
        }

        public function check_alat($kodeAlat=null){
            if(!empty($kodeAlat)) $this->db->where('kodeAlat', $kodeAlat);
            $this->db->from('dataPengajuanAlat');
            $this->db->select('*');
            $query = $this->db->get();

            return $query->result();
        }

        public function add_pengajuan($data){
            $this->db->insert('dataPengajuanAlat', $data);
        }

        public function edit_pengajuan($data,$id){
            $this->db->where('kodePengajuan', $id);
            $this->db->update('dataPengajuanAlat', $data);
        }

        public function delete_pengajuan($id){
            $this->db->where('kodePengajuan', $id);
            $this->db->delete('dataPengajuanAlat');
        }
    }