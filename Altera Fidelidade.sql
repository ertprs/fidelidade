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


--23/07/2019

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor23 numeric(10,2);

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN valor24 numeric(10,2);


--26/07/2019
 