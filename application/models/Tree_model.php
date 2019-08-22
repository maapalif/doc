<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Tree_model extends CI_Model
{
	
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	//fetch all pictures from db
	public function getall($id){
		$query = $this->db2->query("SELECT * FROM upload WHERE c_ID = $id AND discard = 0 ");
		return $query->result();
	}

  public function countfiles($id){
    $query = $this->db2->query("SELECT * FROM upload WHERE c_ID = $id AND discard = 0 ");
    return $query->num_rows();
  }

  public function getName($id){
    $query = $this->db2->query("SELECT c_Name FROM categories WHERE c_ID = $id AND discard = 0");
    return ($query->num_rows()) ? $query->row()->c_Name : 0;
  }

  public function countfolders($id){
    $query = $this->db2->query("SELECT c_Name FROM categories WHERE c_ParentID = $id AND discard = 0");
    return $query->num_rows();
  }

  public function getNameDel($id){
    $query = $this->db2->query("SELECT c_Name FROM categories WHERE c_ID = $id");
    return ($query->num_rows()) ? $query->row()->c_Name : 0;
  }

  public function getDesc($id){
    $query = $this->db2->query("SELECT c_Desc FROM categories WHERE c_ID = $id AND discard = 0");
    return ($query->num_rows()) ? $query->row()->c_Desc : 0;
  }

  public function getParents($dept){
    $query = $this->db2->select('c_ID as ID, C_Name as ParentsName')
                       ->from('categories')
                       ->where('discard', 0)
                       ->where('c_Dept', $dept)
                       ->order_by('C_Name', "Asc")
                       ->get();

    return $query->result();
  }

  public function user2($user){

      $query = $this->db->select("b.firstname as First, b.middlename as Mid, b.lastname as Last ")
                        ->from('users a')
                        ->join('users_profile b', 'b.user_id = a.user_id', 'LEFT')
                        ->where('a.username', $user)
                        ->where('a.banned','0')
                        ->limit(1)
                        ->get();
      return ($query->num_rows()) ? $query->row()->First.' '.$query->row()->Last : 0;

  }

  public function tree_all($dept) {
      $query = $this->db2->select("c_ID as id, c_Name as name, c_Name as text, c_ParentID as parent_id")
                         ->from('categories')
                         ->where('discard', 0)
                         ->where('C_Dept', $dept)
                         ->order_by('c_ID', 'ASC')
                         ->get();

      $result = $query->result_array();
      foreach ($result as $row) {
          $data[] = $row;
      }
      return $data;
  }

  public function getParentName($id,$dept) {
      $query = $this->db2->select("c_Name as PName")
                         ->from('categories')
                         ->where('discard', 0)
                         ->where('c_Dept', $dept)
                         ->where('c_ID', $id)
                         ->get();

      return ($query->num_rows()) ? $query->row()->PName : 0;
  }

  public function getTree($dept) {
      $query = $this->db2->select("c_ID as ID, c_Name as Name, c_ParentID as ParentID, c_Desc as Desc")
                         ->from('categories')
                         ->where('discard', 0)
                         ->where('C_Dept', $dept)
                         ->order_by('c_ParentID', 'ASC')
                         ->order_by('c_Name', 'ASC')
                         ->get();

      return $query->result();
  }

  public function getUser() {
      $query = $this->db2->select("p_ID as ID, p_User as User")
                         ->from('permission')
                         ->where('banned', 0)
                         ->get();

      return $query->result();
  }

   public function getfile($id){
    $query = $this->db2->select("u_Name")
                       ->from('upload')
                       ->where('u_ID', $id)
                       ->get();

    return ($query->num_rows()) ? $query->row()->u_Name : 0;
  }

  public function getidfile($id){
    $query = $this->db2->select("u_ID")
                       ->from('upload')
                       ->where('c_ID', $id)
                       ->get();

    return ($query->num_rows()) ? $query->row()->u_ID : 0;
  }

  public function edit($id) {
      $query = $this->db2->select("c_ID as ID, c_Name as Name, c_ParentID as ParentID, c_Desc as Desc")
                         ->from('categories')
                         ->where('discard', 0)
                         ->where('c_ID', $id)
                         ->get();

      if($query){
          return $query->row();
      }else{
          return false;
      }
  }

  public function alluser(){

        $query = $this->db->select(" a.username, a.email as Email, b.firstname, b.middlename, b.lastname ")
                          ->from('users a')
                          ->join('users_profile b', 'b.user_id = a.user_id', 'LEFT')
                          ->where('banned','0')
                          ->order_by('b.firstname', 'ASC')
                          ->get();
        return $query->result();

    }

  public function cekPermission($user) {
      $query = $this->db2->select("p_User")
                         ->from('permission')
                         ->where('banned', 0)
                         ->where('p_User', $user)
                         ->limit(1)
                         ->get();

      return $query->num_rows();
  }

  public function cekParentID($id,$dept) {
      $query = $this->db2->select("c_Name as PName")
                         ->from('categories')
                         ->where('discard', 0)
                         ->where('c_Dept', $dept)
                         ->where('c_ParentID', $id)
                         ->get();

      return $query->num_rows();
  }

  public function getUserPermission($id) {
      $query = $this->db2->select("p_User")
                         ->from('permission')
                         ->where('p_ID', $id)
                         ->limit(1)
                         ->get();

      return ($query->num_rows()) ? $query->row()->p_User : 0;
  }

  public function save ($table, $data) {
        
      $this->db2->insert($table, $data);
      
      if($this->db2->affected_rows()){
          return true;
      }else{
          return false;
      }
  }

  public function update ($table, $data, $where) {
      
      $this->db2->update($table, $data, $where);
      
      if($this->db2->affected_rows()){
          return true;
      }else{
          return false;
      }
  }

  public function save_log($param)
    {
        $sql        = $this->db2->insert_string('log',$param);
        $ex         = $this->db2->query($sql);
        return $this->db->affected_rows($sql);
    }

  public function getLog($dept)
    {
        $query = $this->db2->select(" l_ID as ID, l_User as User, l_Time as Time, l_Desc as Desc, l_Dept as Dept ")
                          ->from('log')
                          ->where('l_Dept',$dept)
                          ->order_by('l_Time', 'DESC')
                          ->get();
        return $query->result();
    }  
	
}