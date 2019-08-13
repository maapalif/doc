 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Author: MIS7102
 * @Date:   2018-11-21 09:02:02
 * @Last Modified by:   dpratama
 * @Last Modified time: 2019-01-15 10:54:31
 */

class Tree extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('tree', TRUE);
        $this->load->model('Tree_model');   
		$this->is_logged_in();
	}

	public function index()
    {
        $this->require_min_level(3);

        $cek = $this->Tree_model->cekPermission($this->auth_username);

        if($cek == 1) {

            redirect('admin/');
        }
        else
        {
            $data = array(
                'title'         =>  'Documentation Home',
                'main_view'     =>  'tree/home'
            );

            $data['stylesheet'] = array(
                "https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css",
                "https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css",
                "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css",
                "https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.bootstrap4.min.css",
                "https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css",
                base_url("assets/plugins/jstree/style.css"),
                base_url('assets/plugins/jquery.filer/css/jquery.filer.css'),
                base_url('assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css'),
            );
         
            $data['javascripts'] = array(
                "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js",
                "https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js",
                "https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js",
                "https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js",
                base_url('assets/plugins/jquery.filer/js/jquery.filer.min.js')
            );

            $data['final_script'] = "
            $(document).ready(function() {
                $('#table').DataTable( {
                     
                } );
            } );
            ";
            
            $this->breadcrumb->add('Home', site_url('tree/'));
            $this->load->view('themes/template', $data);
        }

    }

    function upload(){

        $this->require_min_level(3);

        $config['upload_path']      = './assets/files/';
        $config['allowed_types']    = 'docs|docx|ppt|pptx|xls|xlsx|pdf|rar|zip|7zip|jpg|jpeg|png|gif|txt';
        $config['max_size']         = 1024;

        $this->upload->initialize($config);

        if (!file_exists( $config['upload_path'] )) {
            mkdir( $config['upload_path'] , 0777, true);
        }

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('files'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', $error['error']);
            redirect('tree/upload');
        }
        else
        {
            $upload_data =  $this->upload->data();

            //get the uploaded file date
            $raw_name   = $upload_data['raw_name'];
            $file_path  = $upload_data['file_path'];
            $file_name  = $upload_data['file_name'];
            $file_ext   = $upload_data['file_ext'];
            
            $i = $this->input; 

            $data = array(

                'c_ID'        => $i->post('id'),
                'u_Name'      => $file_name,
                'u_Path'      => $file_path,
                'u_Ext'       => $file_ext,
                'u_Raw'       => $raw_name,
                'u_CreatedBy' => $this->auth_username
    
            );

            //store pic data to the db
            $save = $this->Tree_model->save('upload', $data);
            if ($save == true){
                $this->session->set_flashdata('success','File has been added');
                helper_log("add", "menambahkan file ".$file_name."'", $this->auth_username, $this->auth_department);
                redirect('tree/');
            }
            else 
            {
                $this->session->set_flashdata('error','Something is wrong!');
                redirect('tree/upload/');
            }
        }

    }

	function getChildren()
    {
        $result = $this->Tree_model->tree_all($this->auth_department);

        $itemsByReference = array();

// Build array of item references:
        foreach($result as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
            // Children array:
            $itemsByReference[$item['id']]['children'] = array();
            // Empty data class (so that json_encode adds "data: {}" )
            $itemsByReference[$item['id']]['data'] = new StdClass();
        }

// Set items as children of the relevant parent item.
        foreach($result as $key => &$item)
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                $itemsByReference [$item['parent_id']]['children'][] = &$item;

// Remove items that were added to parents elsewhere:
        foreach($result as $key => &$item) {
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($result[$key]);
        }
        foreach ($result as $row) {
            $data[] = $row;
        }

// Encode:
        echo json_encode($data);
    }

    function getView() {
        $id = $this->input->post('id');
    	$data = array(
            'result' => $this->Tree_model->getall($id),
            'id'     => $id,
            'title'  => $this->Tree_model->getName($id),
            'desc'  => $this->Tree_model->getDesc($id),
        );

    	$this->load->view('tree/_ViewFolder', $data);
    }

    function getUpload() {
        $id = $this->input->post('id');
        $data['id'] = $id;

        $this->load->view('tree/_ViewUpload', $data);
    }

    function deleteAlert() {
        $id = $this->input->post('id');
        $data = array(
            'id'     => $id,
            'folders'  => $this->Tree_model->countfolders($id),
            'files'  => $this->Tree_model->countfiles($id),
        );

        $this->load->view('admin/_DeleteAlert', $data);
    }

    public function delete() {
        $this->require_min_level(3);
        $id = $this->uri->segment(3);
        //var_dump($id);
        $n = 1;
        $i  = $this->input;
            
        $data  = array('discard'        => $n,'u_UpdatedBy'   => $this->auth_username);
        $where = array('u_ID'   => $id);

        $update = $this->Tree_model->update('upload', $data, $where);
            if ($update == true):
                $this->session->set_flashdata('info', ' File has been removed ');
            endif;
            $file = $this->Tree_model->getfile($id);
            helper_log("delete", "menghapus file '".$file."'", $this->auth_username, $this->auth_department); 
            redirect('tree/');
    }



}