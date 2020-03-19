<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pedido_resumen_model extends CI_Model
{

    function subtotalImpuestos($venta_id)
    {
        $this->db->select('afip.afip_id, SUM(detail.net_price) as net_price, SUM(detail.iva_amount) AS iva_amount', false);
        $this->db->join('afip_ivas as afip', 'detail.id_iva = afip.id_iva');
        $this->db->where('detail.id_order', $venta_id);
        $this->db->where('detail.active', ACTIVE);
        $this->db->group_by('detail.id_iva');
        $query = $this->db->get('ordered_products AS detail');
        return $query->result();
    }
}

/* End of file Pedido_resumen_model.php */
/* Location: ./application/models/Pedido_resumen_model.php */
