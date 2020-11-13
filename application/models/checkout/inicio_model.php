<?php

class inicio_model extends Model {


    function listartodosplanos($plano_id = 0){
        $this->db->select("forma_pagamento_id, nome, nome_impressao, valor1, valor5, 
        valor6, valor10, valor11, valor12, valor23, valor24, valor_carteira_titular, valor_carteira, 
        valor_adesao, valoradcional, parcelas, (valor_adesao + valor_carteira_titular) as valortotal", false);
        $this->db->from('tb_forma_pagamento');
        $this->db->where('ativo', 't');
        $this->db->orderby('nome_impressao');
        if($plano_id > 0){
            $this->db->where('forma_pagamento_id', $plano_id); 
        }
        return $this->db->get()->result();
    }


}