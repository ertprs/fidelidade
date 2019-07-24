-- USUARIO E SENHA
ALTER TABLE ponto.tb_paciente ADD COLUMN usuario character varying(50);
ALTER TABLE ponto.tb_paciente ADD COLUMN senha character varying(50);

--27/10
CREATE TABLE ponto.tb_financeiro_parceiro
(
  financeiro_parceiro_id serial NOT NULL,
  razao_social character varying(200),
  fantasia character varying(200),
  endereco_ip character varying(200),
  cnpj character varying(20),
  cpf character varying(11),
  cep character varying(9),
  logradouro character varying(200),
  numero character varying(20),
  complemento character varying(100),
  bairro character varying(100),
  municipio_id integer,
  celular character varying(15),
  telefone character varying(15),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  tipo_logradouro_id integer,
  CONSTRAINT tb_financeiro_parceiro_pkey PRIMARY KEY (financeiro_parceiro_id)
);


ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN carencia_exame integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN carencia_consulta integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN carencia_especialidade integer;
ALTER TABLE ponto.tb_financeiro_parceiro ADD COLUMN convenio_id integer;


CREATE TABLE ponto.tb_exames_fidelidade
(
  exames_fidelidade_id serial NOT NULL,
  agenda_exames_id integer,
  paciente_fidelidade_id integer,
  parceiro_id integer,
  data date,
  ativo boolean DEFAULT true,
  procedimento_convenio_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_exames_fidelidade_pkey PRIMARY KEY (exames_fidelidade_id)
);

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN paciente_parceiro_id integer;
ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN data_atendimento date;
ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN grupo text;

--04/11
INSERT INTO ponto.tb_perfil(perfil_id, nome, ativo) VALUES (4,'VENDEDOR', TRUE);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor5 numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor10 numeric(10,2);
ALTER TABLE ponto.tb_paciente ADD COLUMN vendedor integer;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao numeric(10,2);
ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN excluido boolean DEFAULT false;

--20/11
-- ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN paciente_dependente_id integer;
ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN paciente_titular_id integer;

--21/11

ALTER TABLE ponto.tb_empresa ADD COLUMN iugu_token text;

--22/11

CREATE TABLE ponto.tb_paciente_contrato_parcelas_iugu
(
  paciente_contrato_parcelas_iugu_id serial NOT NULL,
  paciente_contrato_parcelas_id integer,
  url text,
  pdf text,
  invoice_id text,
  identification text,
  data date,
  ativo boolean DEFAULT true,
  situacao boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_paciente_contrato_parcelas_iugu_pkey PRIMARY KEY (paciente_contrato_parcelas_iugu_id)
);

--24/11
ALTER TABLE ponto.tb_empresa ADD COLUMN email text;
--25/11
ALTER TABLE ponto.tb_empresa ADD COLUMN modelo_carteira integer;

-- 06/01/2018

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_vendedor_mensal numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_vendedor numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_gerente_mensal numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_gerente numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_seguradora numeric(10,2);


CREATE TABLE ponto.tb_ambulatorio_gerente_operador
(
  ambulatorio_gerente_operador_id serial,
  operador_id integer,
  gerente_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  empresa_id integer,
  CONSTRAINT tb_ambulatorio_gerente_operador_pkey PRIMARY KEY (ambulatorio_gerente_operador_id)
);


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_perfil WHERE nome = 'GERENTE DE VENDAS');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_perfil(perfil_id, nome)
        VALUES (5, 'GERENTE DE VENDAS');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();

-- 13/01/2018

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN carencia_exame_mensal boolean  DEFAULT false;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN carencia_consulta_mensal boolean  DEFAULT false;
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN carencia_especialidade_mensal boolean  DEFAULT false;

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN carencia_liberada boolean DEFAULT true;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN financeiro_credor_devedor_id integer;
-- 15/01/2018
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN conta_id integer;
ALTER TABLE ponto.tb_paciente ADD COLUMN grau_parentesco text;
-- 30/01/2018
ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN pessoa_juridica boolean DEFAULT false;

-- 02/02/2018
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN consulta_avulsa numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN taxa_adesao boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente ADD COLUMN consulta_avulsa numeric(10,2);

CREATE TABLE ponto.tb_consultas_avulsas
(
  consultas_avulsas_id serial NOT NULL,
  paciente_id integer,
  data date,
  valor numeric(10,2),
  data_vencimento date,
  charge_id text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  carencia_liberada boolean DEFAULT true,
  CONSTRAINT tb_consultas_avulsas_pkey PRIMARY KEY (consultas_avulsas_id)
);

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN taxa_adesao boolean DEFAULT false;

CREATE TABLE ponto.tb_consultas_avulsas
(
  consultas_avulsas_id serial NOT NULL,
  paciente_id integer,
  data date,
  ativo boolean DEFAULT true,
  pago boolean DEFAULT false,
  valor numeric(10,2),
  data_vencimento date,
  charge_id text,
  invoice_id text,
  url text,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  operador_atualizacao integer,
  data_atualizacao timestamp without time zone,
  carencia_liberada boolean DEFAULT true,
  CONSTRAINT tb_consultas_avulsas_pkey PRIMARY KEY (consultas_avulsas_id)
);

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN adesao_digitada text;

ALTER TABLE ponto.tb_paciente ALTER COLUMN cpf TYPE character varying(18);
ALTER TABLE ponto.tb_financeiro_credor_devedor ALTER COLUMN cpf TYPE character varying(18);
ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN excluido boolean DEFAULT false;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN excluido boolean DEFAULT false;


ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN data_cartao_iugu date;

CREATE TABLE ponto.tb_paciente_cartao_credito
(
  paciente_cartao_credito_id serial NOT NULL,
  paciente_id integer,
  card_number text,
  card_csv integer,
  mes text,
  ano text,
  first_name text,
  last_name text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_paciente_cartao_credito_pkey PRIMARY KEY (paciente_cartao_credito_id)
);

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN pago_cartao boolean DEFAULT false;

ALTER TABLE ponto.tb_paciente_contrato_parcelas_iugu ADD COLUMN status text;

ALTER TABLE ponto.tb_paciente_contrato_parcelas_iugu ADD COLUMN codigo_lr text;

-- 18/04/2018
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN juros numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN multa_atraso numeric(10,2);

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN observacao text;

-- 27/04/2018

ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN tipo text;


UPDATE ponto.tb_consultas_avulsas
   SET tipo= 'EXTRA'
 WHERE tipo is null;


ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN consulta_coop numeric(10,2);

UPDATE ponto.tb_forma_pagamento
   SET consulta_coop= consulta_avulsa
 WHERE consulta_coop is null;

ALTER TABLE ponto.tb_paciente ADD COLUMN consulta_coop numeric(10,2);


UPDATE ponto.tb_paciente
   SET consulta_coop= consulta_avulsa
 WHERE consulta_coop is null;

-- 30/04/2018
ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN utilizada boolean DEFAULT FALSE;

ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN data_utilizada date;
-- 03/04/2018

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN consulta_avulsa boolean DEFAULT false;

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN consulta_tipo text;

-- 03/04/2018

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN valor numeric(10,2);

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN parceiro_convenio_id integer;

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN operador_pagamento integer;

-- 04/04/2018
ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN data_pagamento timestamp without time zone;

ALTER TABLE ponto.tb_exames_fidelidade ADD COLUMN pagamento_confirmado boolean DEFAULT false;

-- 16/05/2018
ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN manual boolean DEFAULT false;

ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN manual boolean DEFAULT false;

-- 20/07/2018
ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN observacao text;

-- Dia 23/07/2018
ALTER TABLE ponto.tb_paciente ADD COLUMN cpf_responsavel_flag boolean DEFAULT false;

-- Dia 31/07/2018
ALTER TABLE ponto.tb_paciente ADD COLUMN codigo_paciente character varying(100);
ALTER TABLE ponto.tb_paciente ADD COLUMN parceiro_id integer;

-- Dia 07/08/2018
ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN ativo_admin boolean DEFAULT true;

ALTER TABLE ponto.tb_paciente ADD COLUMN financeiro_parceiro_id integer;

-- Dia 12/09/2018
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor_adesao numeric(10,2);

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN data_cartao_cadastro timestamp without time zone;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN operador_cartao_cadastro integer;

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN data_cartao_exclusao timestamp without time zone;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN operador_cartao_exclusao integer;


ALTER TABLE ponto.tb_paciente ADD COLUMN credor_devedor_id integer;

ALTER TABLE ponto.tb_paciente_cartao_credito ALTER COLUMN card_csv TYPE text;

--Dia 10/10/2018
INSERT INTO ponto.tb_perfil(perfil_id, nome, ativo) VALUES (6,'REPRESENTANTE COMERCIAL', TRUE);

CREATE TABLE ponto.tb_ambulatorio_representante_operador
(
  ambulatorio_representante_operador_id serial,
  gerente_id integer,
  representante_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  empresa_id integer,
  CONSTRAINT tb_ambulatorio_representante_operador_pkey PRIMARY KEY (ambulatorio_representante_operador_id)
);

CREATE TABLE ponto.tb_forma_rendimento
(
  forma_rendimento_id serial NOT NULL,
  nome character varying(100) NOT NULL,
  ativo boolean NOT NULL DEFAULT true,
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_forma_rendimento_pkey PRIMARY KEY (forma_rendimento_id)
);

ALTER TABLE ponto.tb_paciente ADD COLUMN forma_rendimento_id integer;

CREATE TABLE ponto.tb_forma_rendimento_comissao
(
  forma_rendimento_comissao_id serial NOT NULL,
  nome text,
  plano_id integer,
  forma_rendimento_id integer,
  inicio_parcelas integer,
  fim_parcelas integer,
  valor_comissao numeric(10,2),
  ativo boolean NOT NULL DEFAULT true,
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_forma_rendimento_comissao_pkey PRIMARY KEY (forma_rendimento_comissao_id)
);
-- Dia 11/10/2018

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor11 numeric(10,2);

UPDATE ponto.tb_forma_pagamento SET valor11 = 0.00
WHERE valor11 is null;

-- Dia 05/11/2018

UPDATE ponto.tb_paciente_contrato
   SET 
       excluido=true
 WHERE ativo_admin = false;


-- 13/01/2018
ALTER TABLE ponto.tb_empresa ADD COLUMN cadastro integer;
ALTER TABLE ponto.tb_paciente ADD COLUMN financeiro character varying(200);
ALTER TABLE ponto.tb_paciente ADD COLUMN ligacao character varying(200);


ALTER TABLE ponto.tb_paciente ADD COLUMN cpffinanceiro character varying(16);

 

CREATE TABLE ponto.tb_paciente_conta_debito
(
  paciente_conta_debito_id serial NOT NULL,
  paciente_id integer,
  conta_agencia text,
  codigo_operacao text,
  conta_numero text,
  conta_digito text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_paciente_conta_debito_pkey PRIMARY KEY (paciente_conta_debito_id)
);


CREATE TABLE ponto.tb_sicov_caixa
(
  sicov_caixa_id serial NOT NULL,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_sicov_caixa_pkey PRIMARY KEY (sicov_caixa_id)
);


ALTER TABLE ponto.tb_empresa ADD COLUMN codigo_convenio_banco text;

ALTER TABLE ponto.tb_empresa ADD COLUMN tipo_carencia text;

ALTER TABLE ponto.tb_forma_entradas_saida ADD COLUMN conta_interna boolean DEFAULT false;

-- 13/01/2019
ALTER TABLE ponto.tb_empresa ADD COLUMN cadastro integer;
ALTER TABLE ponto.tb_paciente ADD COLUMN financeiro character varying(200);
ALTER TABLE ponto.tb_paciente ADD COLUMN ligacao character varying(200);


ALTER TABLE ponto.tb_paciente ADD COLUMN cpffinanceiro character varying(16);

-- 07/02/2019
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor_carteira numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor_carteira_titular numeric(10,2);



--06/05/2019

ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN contador_impressao integer;
ALTER TABLE ponto.tb_paciente_contrato_dependente ALTER COLUMN contador_impressao SET NOT NULL;
ALTER TABLE ponto.tb_paciente_contrato_dependente ALTER COLUMN contador_impressao SET DEFAULT 0;

 
ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN data_ultima_impressao timestamp without time zone;


--07/05/2019

ALTER TABLE ponto.tb_empresa ADD COLUMN alterar_contrato boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN alterar_contrato SET DEFAULT false;


ALTER TABLE ponto.tb_empresa ADD COLUMN confirm_outra_data boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN confirm_outra_data SET DEFAULT false;

--09/05/2019
ALTER TABLE ponto.tb_empresa ADD COLUMN financeiro_maior_zero boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN financeiro_maior_zero SET DEFAULT false;

--10/05/2019

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN qtd_dias integer DEFAULT 365;
 
--15/05/2019

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_1 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_1 SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_2 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_2 SET DEFAULT false;


ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN forma_rendimento_id integer;

ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN vendedor_id integer;


--16/05/2019

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN debito boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN debito SET DEFAULT false;

--17/05/2019

ALTER TABLE ponto.tb_entradas ADD COLUMN paciente_contrato_parcelas_id integer;

--20/05/2019


ALTER TABLE ponto.tb_empresa ADD COLUMN cadastroempresa boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN cadastroempresa SET DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN cadastro_empresa_flag boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN cadastro_empresa_flag SET DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN excluir_entrada_saida boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN excluir_entrada_saida SET DEFAULT false;


--24/05/2019



ALTER TABLE ponto.tb_paciente_contrato_parcelas_iugu ADD COLUMN empresa_id integer;

--27/05/2019

-- Table: ponto.tb_qtd_funcionarios_empresa

-- DROP TABLE ponto.tb_qtd_funcionarios_empresa;

CREATE TABLE ponto.tb_qtd_funcionarios_empresa
(
  qtd_funcionarios_empresa_id serial NOT NULL,
  forma_pagamento_id integer,
  valor double precision,
  parcelas integer,
  qtd_funcionarios character varying(222),
  empresa_id integer,
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  operador_atualizacao integer,
  data_atualizacao timestamp without time zone,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_qtd_funcionarios_empresa_pkey PRIMARY KEY (qtd_funcionarios_empresa_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_qtd_funcionarios_empresa
  OWNER TO postgres;




ALTER TABLE ponto.tb_paciente ADD COLUMN empresa_id integer;

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN empresa_iugu boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN empresa_iugu SET DEFAULT false;

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN debito boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN debito SET DEFAULT false;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_iugu ADD COLUMN empresa_id integer;


--28/05/2019

ALTER TABLE ponto.tb_saldo ADD COLUMN paciente_contrato_parcelas_id integer;

--31/05/2019

ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN pago_todos_iugu boolean;
ALTER TABLE ponto.tb_paciente_contrato ALTER COLUMN pago_todos_iugu SET DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN renovar_contrato_automatico boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN renovar_contrato_automatico SET DEFAULT true;


--03/06/2019

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN parcela_verificadora boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN parcela_verificadora SET DEFAULT false;

 
--05/06/2019


CREATE TABLE ponto.tb_impressoes_contratro_dependente
(
  impressoes_contratro_dependente_id integer NOT NULL DEFAULT nextval('ponto.tb_impressoes_contratro_depen_impressoes_contratro_dependen_seq'::regclass),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  paciente_contrato_id integer,
  paciente_id integer,
  ativo boolean DEFAULT true,
  paciente_contrato_dependente_id integer,
  CONSTRAINT tb_impressoes_contratro_dependente_pkey PRIMARY KEY (impressoes_contratro_dependente_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_impressoes_contratro_dependente
  OWNER TO postgres;


ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN ultimo_operador_impressao integer;


---07/06/2019


ALTER TABLE ponto.tb_entradas ADD COLUMN empresa_cadastro_id integer;
ALTER TABLE ponto.tb_entradas ADD COLUMN nome_empresa_cadastro character varying(222);
ALTER TABLE ponto.tb_saldo ADD COLUMN empresa_cadastro_id integer;
ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN empresa_cadastro_id integer;
 
--28/06/2019


ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN nome_impressao text;

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_3 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_3 SET DEFAULT false;
 
ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_4 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_4 SET DEFAULT false;

--04/07/2019
ALTER TABLE ponto.tb_empresa ADD COLUMN titular_flag boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN titular_flag SET DEFAULT false;

--12/07/2019
ALTER TABLE ponto.tb_empresa ADD COLUMN client_id character varying(222);
ALTER TABLE ponto.tb_empresa ADD COLUMN client_secret character varying(222);


ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_5 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_5 SET DEFAULT false;


 
CREATE TABLE ponto.tb_paciente_contrato_parcelas_gerencianet
(
  paciente_contrato_parcelas_gerencianet_id integer NOT NULL DEFAULT nextval('ponto.tb_paciente_contrato_parcelas_paciente_contrato_parcelas_iu_seq'::regclass),
  paciente_contrato_parcelas_id integer,
  link text,
  pdf text,
  charge_id text,
  data date,
  ativo boolean DEFAULT true,
  situacao boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  status text,
  empresa_id integer,
  CONSTRAINT tb_paciente_contrato_parcelas_gerencianet_id_pkey PRIMARY KEY (paciente_contrato_parcelas_gerencianet_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet
  OWNER TO postgres;

--16/07/2019

ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN "charge_id_GN" text;
ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN "pdf_GN" text;

ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN "link_GN" text;
 

--05/06/2019

CREATE TABLE ponto.tb_impressoes_contratro_dependente
(
  impressoes_contratro_dependente_id serial NOT NULL,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  paciente_contrato_id integer,
  paciente_id integer,
  ativo boolean DEFAULT true,
  paciente_contrato_dependente_id integer,
  CONSTRAINT tb_impressoes_contratro_dependente_pkey PRIMARY KEY (impressoes_contratro_dependente_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_impressoes_contratro_dependente
  OWNER TO postgres;



ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN ultimo_operador_impressao integer;


---07/06/2019


ALTER TABLE ponto.tb_entradas ADD COLUMN empresa_cadastro_id integer;
ALTER TABLE ponto.tb_entradas ADD COLUMN nome_empresa_cadastro character varying(222);
ALTER TABLE ponto.tb_saldo ADD COLUMN empresa_cadastro_id integer;
ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN empresa_cadastro_id integer;
 
