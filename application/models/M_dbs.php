<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dbs extends CI_Model
{
	var $table = 'tbl_dbs';
	var $column_order = array(null, 'file_name', 'module', 'tgl_data', 'file_size', 'upload_time', null); //set column field database for datatable orderable
	var $column_search = array('file_name', 'module', 'tgl_data', 'file_size', 'upload_time'); //set column field database for datatable searchable 
	var $order = array(); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	private function _get_datatables_query()
	{
		//add custom filter here
		if (input('filename') != '') {
			$this->db->like('file_name', input('filename'));
		}
		if (input('module') != '') {
			$this->db->like('module', input('module'));
		}
		if (input('tgl_awal') != '' && input('tgl_akhir') != '') {
			$this->db->where('tgl_data >=', parse_tgl(input('tgl_awal')));
			$this->db->where('tgl_data <=', parse_tgl(input('tgl_akhir')));
		}

		$this->db->from($this->table);
		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		$max_tgl = $this->db->query('SELECT MAX(tgl_data) as tgl_data FROM tbl_dbs')->row_array();
		if(input('filename') == '' && input('module') == '' &&input('tgl_awal') == '' && input('tgl_akhir') == ''){
			$this->db->where('tgl_data = \'' . $max_tgl['tgl_data'] . '\'');
		}
		$this->db->order_by('tgl_data desc');

		// if (isset($_POST['order'])) // here order processing
		// {
		// 	$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		// } else if (isset($this->order)) {
		// 	$order = $this->order;
		// 	$this->db->order_by(key($order), $order[key($order)]);
		// }
	}

	public function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
}
