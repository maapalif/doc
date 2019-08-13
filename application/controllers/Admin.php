<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Author: MIS7102
 * @Date:   2018-11-21 09:02:02
 * @Last Modified by:   dpratama
 * @Last Modified time: 2019-01-15 10:54:31
 */

class Admin extends MY_Controller
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

        $data = array(
            'title'         =>  'Admin Home',
            'main_view'     =>  'admin/home'
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
            });
        });
        ";
        
        $this->breadcrumb->add('Home', site_url('admin/'));
        $this->load->view('themes/v2/template', $data);

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
            redirect('admin/upload');
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
                redirect('admin/');
            }
            else 
            {
                $this->session->set_flashdata('error','Something is wrong!');
                redirect('admin/upload/');
            }
        }

    }

    //===================FOLDER NAVIGATION========================

    public function listFolder()
    {
        $this->verify_min_level(3);

        $data = array(
            'title'         =>  'List Folder',
            'data'          =>  $this->Tree_model->getTree($this->auth_department),
            'main_view'     =>  'admin/list'
        );

        $data['stylesheet'] = array(
            "https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css",
            "https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css",
            "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css",
            "https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.bootstrap4.min.css",
            "https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css",
            "https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default-dark/style.min.css",
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
            });
        });
        ";
        
        $this->breadcrumb->add('Home', site_url('admin/'));
        $this->breadcrumb->add('List Folder', site_url('admin/listFolder'));
        $this->load->view('themes/v2/template', $data);

    }

    public function addParents()
    {
        
        $this->verify_min_level(3);

        $v = $this->form_validation;
        $v->set_rules('nm_parents','Parents Name','trim|required');
        
        if($v->run() == FALSE) {

            $data = array(  

                'title'     => 'New Parents Folder',
                'main_view' => 'admin/new_parents'
            );


            $data['stylesheet'] = array(
                "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"

            );

            $data['custom_style'] = 
            "";

            $data['javascripts'] = array(
                "https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            );


            $data['final_script'] = "";


            $this->breadcrumb->add('Home', site_url('admin/'));
            $this->breadcrumb->add('Add New Parents', site_url('admin/addParents'));
            $this->load->view('themes/template',$data);

        }
        else 
        {

            $data = array(
                
                'c_Name'          =>  $this->input->post('nm_parents'),
                'c_Dept'          =>  $this->auth_department,   
                'c_CreatedBy'     =>  $this->auth_username
            );

            $ins = $this->Tree_model->save('categories', $data);
    
            if( $ins==TRUE) {
                $this->session->set_flashdata('success', 'New Parents Folder has been added');
                redirect('admin/listFolder');
            }
            else 
            {
                $this->session->set_flashdata('warning', 'There are something wrong');
                redirect('admin/addParents');
            }
            
        }
        // End masuk database
    }

    public function editParents()
    {
        
        $this->verify_min_level(3);

        $id =- $this->uri->segmen(3);

        $ci = $this->Tree_model->edit($id);
        if ($ci != false){


            $v = $this->form_validation;
            $v->set_rules('nm_parents','Parents Name','trim|required');
            
            if($v->run() == FALSE) {

                $data = array(  

                    'title'     => 'New Parents Folder',
                    'main_view' => 'admin/new_parents'
                );


                $data['stylesheet'] = array(
                    "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"

                );

                $data['custom_style'] = 
                "";

                $data['javascripts'] = array(
                    "https://code.jquery.com/ui/1.12.1/jquery-ui.js"
                );


                $data['final_script'] = "";


                $this->breadcrumb->add('Home', site_url('admin/'));
                $this->breadcrumb->add('Edit Parents Folder', site_url('admin/editParents'));
                $this->load->view('themes/template',$data);

            }
            else 
            {
                $id = $this->uri->segment(4); 

                $data = array(
                    
                    'c_Name'          =>  $this->input->post('nm_parents'),
                    'c_UpdatedBy'     =>  $this->auth_username
                );

                $where = array (

                    'c_ID' => $id
                );

                $ins = $this->Tree_model->update('categories', $data, $where);
        
                if( $ins==TRUE) {
                    $this->session->set_flashdata('success', 'New Parents Folder has been added');
                    redirect('admin/listFolder');
                }
                else 
                {
                    $this->session->set_flashdata('warning', 'There are something wrong');
                    redirect('admin/editParents');
                }
                
            }

        }
        else
        {
            $this->session->set_flashdata('error','Parent folder not found!');
            redirect('admin/listFolder');
        }   
        // End masuk database
    }

    public function addChild()
    {
        
        $this->verify_min_level(3);

        $v = $this->form_validation;
        $v->set_rules('nm_parents','Parents Name','required');
        $v->set_rules('nm_child','Parents Name','trim|required');
        
        if($v->run() == FALSE) {

            $data = array(  

                'title'     => 'New Parents Folder',
                'parents'   => $this->Tree_model->getParents($this->auth_department),
                'main_view' => 'admin/new_child'
            );


            $data['stylesheet'] = array(
                "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css",
                "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"

            );

            $data['custom_style'] = 
            "";

            $data['javascripts'] = array(
                "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.min.js",
                "https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            );


            $data['final_script'] = "
                $(document).ready(function() {
                    $('.select2').select2();
                }); 
            ";


            $this->breadcrumb->add('Home', site_url('admin/'));
            $this->breadcrumb->add('Add New Child', site_url('admin/addChild'));
            $this->load->view('themes/template',$data);

        }
        else 
        {

            $data = array(
                
                'c_Name'        =>  $this->input->post('nm_child'),
                'c_ParentID'    =>  $this->input->post('nm_parents'),
                'c_Dept'        =>  $this->auth_department,   
                'c_CreatedBy'   =>  $this->auth_username
            );

            $ins = $this->Tree_model->save('categories', $data);
    
            if( $ins==TRUE) {
                $this->session->set_flashdata('success', 'New Child Folder has been added');
                redirect('admin/listFolder');
            }
            else 
            {
                $this->session->set_flashdata('warning', 'There are something wrong');
                redirect('admin/addParents');
            }
            
        }
        // End masuk database
    }

    public function editChild()
    {
        
        $this->verify_min_level(3);

        $id =- $this->uri->segmen(3);

        $ci = $this->Tree_model->edit($id);
        if ($ci != false){


            $v = $this->form_validation;
            $v->set_rules('nm_parents','Parents Name','trim|required');
            
            if($v->run() == FALSE) {

                $data = array(  

                    'title'     => 'New Parents Folder',
                    'main_view' => 'admin/new_parents'
                );


                $data['stylesheet'] = array(
                    "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"

                );

                $data['custom_style'] = 
                "";

                $data['javascripts'] = array(
                    "https://code.jquery.com/ui/1.12.1/jquery-ui.js"
                );


                $data['final_script'] = "";


                $this->breadcrumb->add('Home', site_url('admin/'));
                $this->breadcrumb->add('Edit Child Folder', site_url('admin/editChild'));
                $this->load->view('themes/template',$data);

            }
            else 
            {
                $id = $this->uri->segment(4); 

                $data = array(
                    
                    'c_Name'          =>  $this->input->post('nm_parents'),
                    'c_ParentID'      =>  $this->input->post('nm_parents'), 
                    'c_UpdatedBy'     =>  $this->auth_username
                );

                $where = array (

                    'c_ID' => $id
                );

                $ins = $this->Tree_model->update('categories', $data, $where);
        
                if( $ins==TRUE) {
                    $this->session->set_flashdata('success', 'New Parents Folder has been added');
                    redirect('admin/listFolder');
                }
                else 
                {
                    $this->session->set_flashdata('warning', 'There are something wrong');
                    redirect('admin/editParents');
                }
                
            }

        }
        else
        {
            $this->session->set_flashdata('error','Parent folder not found!');
            redirect('admin/listFolder');
        }   
        // End masuk database
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

    public function delete() {
        $this->require_min_level(1);
        $id = $this->uri->segment(3);
        //var_dump($id);
        $n = 1;
        $i  = $this->input;
            
        $data  = array('discard'        => $n,'c_UpdatedBy'   => $this->auth_username);
        $where = array('c_ID'   => $id);

        $update = $this->Tree_model->update('categories', $data, $where);
            if ($update == true):
                $this->session->set_flashdata('info', 'Folder has been removed ');
            endif;
            redirect('admin/listFolder');
    }

    //===================USER PERMISSION========================

    public function listPermission()
    {
        $this->require_min_level(3);

        $data = array(
            'title'         =>  'List User Permission',
            'data'          =>  $this->Tree_model->getUser(),
            'main_view'     =>  'admin/list_user'
        );

        $data['stylesheet'] = array(
            "https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css",
            "https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css",
            "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css",
            "https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.bootstrap4.min.css",
            "https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css",
            "https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default-dark/style.min.css",
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
            });
        });
        ";
        
        $this->breadcrumb->add('Home', site_url('admin/'));
        $this->breadcrumb->add('List Folder', site_url('admin/listFolder'));
        $this->load->view('themes/v2/template', $data);

    }


    public function addPermission()
    {
        
        $this->verify_min_level(3);

        $v = $this->form_validation;
        $v->set_rules('user','username','required');
        
        if($v->run() == FALSE) {

            $data = array(  

                'title'     => 'New User Permission',
                'user'      =>  $this->Tree_model->alluser(),
                'main_view' => 'admin/new_user'
            );


            $data['stylesheet'] = array(
                "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"

            );

            $data['custom_style'] = 
            "";

            $data['javascripts'] = array(
                "https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            );


            $data['final_script'] = "";


            $this->breadcrumb->add('Home', site_url('admin/'));
            $this->breadcrumb->add('Add User Permission', site_url('admin/addPermission'));
            $this->load->view('themes/template',$data);

        }
        else 
        {

            $data = array(
                
                'p_User'          =>  $this->input->post('user'),
                'p_CreatedBy'     =>  $this->auth_username 
            );

            $ins = $this->Tree_model->save('permission', $data);
    
            if( $ins==TRUE) {
                $this->session->set_flashdata('success', 'New User Permission has been added');
                redirect('admin/listPermission');
            }
            else 
            {
                $this->session->set_flashdata('warning', 'There are something wrong');
                redirect('admin/addPermission');
            }
            
        }
        // End masuk database
    }

    public function deleteUser() {
        $this->require_min_level(3);
        $id = $this->uri->segment(3);
        //var_dump($id);
        $n = 1;
        $i  = $this->input;
            
        $data  = array('banned'        => $n, 'p_UpdatedBy'     =>  $this->auth_username);
        $where = array('p_ID'   => $id);

        $update = $this->Tree_model->update('permission', $data, $where);
            if ($update == true):
                $this->session->set_flashdata('info', ' Data Sewa Bangunan has been removed ');
            endif;
            redirect('admin/listPermission');
    }
}