<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Author: MIS7102
 * @Date:   2018-07-05 11:16:01
 * @Last Modified by:   dpratama
 * @Last Modified time: 2018-12-14 09:47:53
 */

class Entity {

	public function __construct()
	{

	}

	public function getAllEntity()
    {
    	$CI = &get_instance();
        return $CI->db->from('m_entity')
                      ->order_by('priority')
                      ->get();
    }

    public function getAllGroup()
    {
    	$CI = &get_instance();
        return $CI->db->select('entity_group')->order_by('entity_group')->order_by('priority')->group_by('entity_group')->get('m_entity');
    }

    public function checkEntity_Group($group)
    {
    	$CI = &get_instance();
        return $CI->db->get_where('m_entity', ['entity_group' => $group]);
    }

	public function getEntity($array)
    {
    	$CI = &get_instance();
        return $CI->db->from('m_entity')
                      ->where_in('entity_prefix', $array)
                      ->order_by('priority')
                      ->get();
    }

    public function getEntityByName($name)
    {
    	$CI = &get_instance();
        return $CI->db->get_where('m_entity', ['entity_name'=>$name], 1)->row();
    }

    public function getEntityByPrefix($prefix)
    {
    	$CI = &get_instance();
        return $CI->db->get_where('m_entity', ['entity_prefix'=>$prefix], 1)->row();
    }

    public function get_entityname_from_series_code($str)
	{
		$CI = &get_instance();
        $query = $CI->db->get_where('m_entity', ['entity_short'=>$str], 1);
        return ( $query->num_rows() ) ? $query->row()->entity_name : NULL;
	}

	public function get_entityname_from_location_code($str)
	{
		$CI = &get_instance();
        $query = $CI->db->get_where('m_entity', ['entity_short'=>$str], 1);

        if ( $query->num_rows() )
        {
        	$EntityName = $query->row()->entity_name;
        }
        else
        {
        	switch ($str)
	        {
		        case "1":
		            $EntityName = 'Paz Ace Indonesia';
		            break;
		        case "2":
		            $EntityName = 'Persada MultiParts';
		            break;
		        case "3":
		            $EntityName = 'Dwikarya Linindo Teknik';
		            break;
				default:
					$EntityName = null;
		    }
        }

        return $EntityName;
	}

	public function get_table_from_location_code($str)
	{
		$CI = &get_instance();
        $query = $CI->db->get_where('m_entity', ['entity_short'=>$str], 1);

        if ( $query->num_rows() )
        {
        	$EntityTbl = $query->row()->entity_tbl;
        }
        else
        {
        	switch ($str)
	        {
		        case "1":
		            $EntityTbl = NAV_TABLE_PAZ;
		            break;
		        case "2":
		            $EntityTbl = NAV_TABLE_PMP;
		            break;
		        case "3":
		            $EntityTbl = NAV_TABLE_DLT;
		            break;
				default:
					$EntityTbl = null;
		    }
        }

        return $EntityTbl;
	}

	public function get_table_from_series_code($str)
	{
		$CI = &get_instance();
        $query = $CI->db->get_where('m_entity', ['entity_short'=>$str], 1);
        return ( $query->num_rows() ) ? $query->row()->entity_tbl : NULL;
	}

	public function get_entityname_from_series_code_old($str)
	{
		if (strpos($str, 'PAI') !== false) {
    		$Entity = 'Paz Ace Indonesia';
		}
		elseif(strpos($str, 'PMP') !== false) {
    		$Entity = 'Persada MultiParts';
		}
		elseif(strpos($str, 'DLT') !== false) {
    		$Entity = 'Dwikarya Linindo Teknik';
		}
		elseif(strpos($str, 'LPI') !== false) {
    		$Entity = 'Linindo Pacific International';
		}

		return $Entity;
	}

	public function get_table_from_series_code_old($str)
	{
		if (strpos($str, 'PAI') !== false) {
    		$tbl_Entity = NAV_TABLE_PAZ;
		}
		elseif(strpos($str, 'PMP') !== false) {
    		$tbl_Entity = NAV_TABLE_PMP;
		}
		elseif(strpos($str, 'DLT') !== false) {
    		$tbl_Entity = NAV_TABLE_DLT;
		}
		elseif(strpos($str, 'LPI') !== false) {
    		$tbl_Entity = NAV_TABLE_LPI;
		}

		return $tbl_Entity;
	}

}