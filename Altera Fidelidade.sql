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
 
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN quantidade integer;
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN autorizar_manual boolean;
ALTER TABLE ponto.tb_procedimento_convenio ALTER COLUMN autorizar_manual SET DEFAULT false;
ALTER TABLE ponto.tb_empresa ADD COLUMN modificar_verificar boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN modificar_verificar SET DEFAULT false;
ALTER TABLE ponto.tb_financeiro_parceiro ADD COLUMN usuario text;
ALTER TABLE ponto.tb_financeiro_parceiro ADD COLUMN senha character varying(100);

--29/07/2019


CREATE TABLE ponto.tb_paciente_verificados
(
  paciente_verificados_id serial NOT NULL,
  procedimento_convenio_id integer,
  titular_id integer,
  dependente integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  excluido boolean DEFAULT false,
  paciente_contrato_id integer,
  data_autorizacao_manual timestamp without time zone,
  operador_autorizacao_manual integer,
  financeiro_parceiro_id integer,
  CONSTRAINT tb_paciente_verificados_pkey PRIMARY KEY (paciente_verificados_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_paciente_verificados
  OWNER TO postgres;

--30/07/2019


CREATE TABLE ponto.tb_procedimentos_plano
(
  procedimentos_plano_id serial NOT NULL,
  procedimento_convenio_id integer,
  quantidade integer,
  tempo character varying(222),
  operador_cadastro integer,
  data_cadastro timestamp without time zone,
  operador_atualizacao integer,
  data_atualizacao timestamp without time zone,
  formapagamento_id integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_procedimentos_plano_pkey PRIMARY KEY (procedimentos_plano_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_procedimentos_plano
  OWNER TO postgres;

--02/08/2019

CREATE TABLE ponto.tb_paciente_contrato_parcelas_gerencianet
(
  paciente_contrato_parcelas_gerencianet_id serial NOT NULL,
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
  carne boolean DEFAULT false,
  link_carne text,
  cover_carne text,
  pdf_carnet text,
  pdf_cover_carne text,
  carnet_id integer,
  num_carne integer,
  CONSTRAINT tb_paciente_contrato_parcelas_gerencianet_id_pkey PRIMARY KEY (paciente_contrato_parcelas_gerencianet_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet
  OWNER TO postgres;


ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ADD COLUMN carne boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ALTER COLUMN carne SET DEFAULT false;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ADD COLUMN link_carne text;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ADD COLUMN cover_carne text;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ADD COLUMN pdf_carnet text;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ADD COLUMN pdf_cover_carne text;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ADD COLUMN carnet_id integer;
ALTER TABLE ponto.tb_paciente_contrato_parcelas_gerencianet ADD COLUMN num_carne integer;


--19/08/2019

 
ALTER TABLE ponto.tb_procedimento_convenio ADD COLUMN financeiro_parceiro_id integer;

--06/09/2019

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN parcela_dependente boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN parcela_dependente SET DEFAULT false;

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN paciente_dependente_id integer;

--09/09/2019
 
CREATE TABLE ponto.tb_observacao_contrato
(
  observacao_contrato_id serial NOT NULL,
  observacao text,
  paciente_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_observacao_contrato_pkey PRIMARY KEY (observacao_contrato_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_observacao_contrato
  OWNER TO postgres;

--12/09/2019
 
ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN nao_renovar boolean;
ALTER TABLE ponto.tb_paciente_contrato ALTER COLUMN nao_renovar SET DEFAULT false;

--12/09/2019

ALTER TABLE ponto.tb_paciente ADD COLUMN reativar boolean;
ALTER TABLE ponto.tb_paciente ALTER COLUMN reativar SET DEFAULT false;


--16/09/2019
ALTER TABLE ponto.tb_financeiro_credor_devedor ADD COLUMN paciente_id integer;


ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN parcelas character varying(222);

--25/09/2019


CREATE TABLE ponto.tb_erros_gerencianet
(
  erros_gerencianet_id serial NOT NULL,
  paciente_id integer,
  paciente_contrato_id integer,
  code_erro character varying(200),
  data_cadastro timestamp without time zone,
  mensagem text,
  operador_cadastro integer,
  ativo boolean DEFAULT true,
  operador_atualizacao integer,
  data_atualizacao timestamp without time zone,
  CONSTRAINT tb_erros_gerencianet_pkey PRIMARY KEY (erros_gerencianet_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_erros_gerencianet
  OWNER TO postgres;


--10/10/2019

ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN data_envio_iugu date;


--23/11/2019

ALTER TABLE ponto.tb_entradas ADD COLUMN consultas_avulsas_id integer;
--13/11/2019

CREATE TABLE ponto.tb_envio_iugu_card
(
  envio_iugu_card_id serial NOT NULL,
  paciente_contrato_parcelas_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  CONSTRAINT tb_envio_iugu_card_pkey PRIMARY KEY (envio_iugu_card_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_envio_iugu_card
  OWNER TO postgres;

--02/12/2019

CREATE TABLE ponto.tb_precadastro
(
  precadastro_id serial NOT NULL,
  nome text,
  cpf character varying(200),
  telefone character varying(200),
  plano_id integer,
  vendedor integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_precadastro_pkey PRIMARY KEY (precadastro_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_precadastro
  OWNER TO postgres;

--03/01/2020


ALTER TABLE ponto.tb_empresa ADD COLUMN forma_dependente boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN forma_dependente SET DEFAULT false;
 
ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_1 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_1 SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_2 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_2 SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_3 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_3 SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_4 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_4 SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_5 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_5 SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN carteira_padao_6 boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN carteira_padao_6 SET DEFAULT false;
 
ALTER TABLE ponto.tb_empresa ADD COLUMN renovar_contrato_automatico boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN renovar_contrato_automatico SET DEFAULT true;

ALTER TABLE ponto.tb_empresa ADD COLUMN cadastroempresa boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN cadastroempresa SET DEFAULT false;


ALTER TABLE ponto.tb_empresa ADD COLUMN usuario_epharma text;
ALTER TABLE ponto.tb_empresa ADD COLUMN senha_epharma text;
ALTER TABLE ponto.tb_empresa ADD COLUMN url_epharma text;

ALTER TABLE ponto.tb_empresa ADD COLUMN botoes_app text;

ALTER TABLE ponto.tb_empresa ADD COLUMN codigo_plano text;



ALTER TABLE ponto.tb_entradas ADD COLUMN empresa_cadastro_id integer;

ALTER TABLE ponto.tb_empresa ADD COLUMN cadastro_empresa_flag boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN cadastro_empresa_flag SET DEFAULT false;



ALTER TABLE ponto.tb_empresa ADD COLUMN titular_flag boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN titular_flag SET DEFAULT false;


ALTER TABLE ponto.tb_empresa ADD COLUMN alterar_contrato boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN alterar_contrato SET DEFAULT false;



ALTER TABLE ponto.tb_empresa ADD COLUMN confirm_outra_data boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN confirm_outra_data SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN financeiro_maior_zero boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN financeiro_maior_zero SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN excluir_entrada_saida boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN excluir_entrada_saida SET DEFAULT false;

ALTER TABLE ponto.tb_empresa ADD COLUMN client_id character varying(222);

ALTER TABLE ponto.tb_empresa ADD COLUMN client_secret character varying(222);


ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN qtd_dias integer;
ALTER TABLE ponto.tb_forma_pagamento ALTER COLUMN qtd_dias SET DEFAULT 365;



ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN nome_impressao text;

ALTER TABLE ponto.tb_entradas ADD COLUMN paciente_contrato_parcelas_id integer;
ALTER TABLE ponto.tb_saldo ADD COLUMN paciente_contrato_parcelas_id integer;


ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN empresa_iugu boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN empresa_iugu SET DEFAULT false;


ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN parcela_verificadora boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN parcela_verificadora SET DEFAULT false;


ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN debito boolean;
ALTER TABLE ponto.tb_paciente_contrato_parcelas ALTER COLUMN debito SET DEFAULT false;

ALTER TABLE ponto.tb_paciente_contrato_parcelas_iugu ADD COLUMN empresa_id integer;

ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN vendedor_id integer;

ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN pago_todos_iugu boolean;
ALTER TABLE ponto.tb_paciente_contrato ALTER COLUMN pago_todos_iugu SET DEFAULT false;

ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN empresa_cadastro_id integer;
ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN nao_renovar boolean;
ALTER TABLE ponto.tb_paciente_contrato ALTER COLUMN nao_renovar SET DEFAULT false;

ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN forma_rendimento_id integer;

ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN contador_impressao integer;
ALTER TABLE ponto.tb_paciente_contrato_dependente ALTER COLUMN contador_impressao SET DEFAULT 0;

ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN data_ultima_impressao timestamp without time zone;

ALTER TABLE ponto.tb_paciente_contrato_dependente ADD COLUMN ultimo_operador_impressao integer;
 
ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN "link_GN" text;
  
ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN "charge_id_GN" text;

ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN "pdf_GN" text;
 
ALTER TABLE ponto.tb_paciente ADD COLUMN empresa_id integer;



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




--16/03/2020

CREATE TABLE ponto.tb_empresa_cadastro
(
  empresa_cadastro_id serial NOT NULL,
  razao_social character varying(200),
  nome character varying(200),
  cnpj character varying(20),
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
  tipo_carencia text,
  modelo_carteira integer,
  email text,
  cnes character varying(20),
  CONSTRAINT tb_empresa_cadastro_pkey PRIMARY KEY (empresa_cadastro_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_empresa_cadastro
  OWNER TO postgres;


INSERT INTO ponto.tb_perfil(perfil_id, nome, ativo) VALUES (7, 'INDICACAO', TRUE);
INSERT INTO ponto.tb_perfil(perfil_id, nome, ativo) VALUES (8, 'VENDEDOR EXTERNO', TRUE);
INSERT INTO ponto.tb_perfil(perfil_id, nome, ativo) VALUES (9, 'VENDEDOR EXTERNO PJ', TRUE);

CREATE TABLE ponto.tb_posts_blog
(
  posts_blog_id serial NOT NULL,
  titulo character varying(200),
  breve_descricao text,
  thumbnail text,
  corpo_html text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_posts_blog_pkey PRIMARY KEY (posts_blog_id)
);
  

CREATE TABLE ponto.tb_paciente_risco_cirurgico
(
  paciente_risco_cirurgico_id serial NOT NULL,
  paciente_id integer,
  questionario text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_paciente_risco_cirurgico_pkey PRIMARY KEY (paciente_risco_cirurgico_id)
);
  

CREATE TABLE ponto.tb_paciente_pesquisa_satisfacao
(
  paciente_pesquisa_satisfacao_id serial NOT NULL,
  paciente_id integer,
  questionario text,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_paciente_pesquisa_satisfacao_pkey PRIMARY KEY (paciente_pesquisa_satisfacao_id)
);



CREATE TABLE ponto.tb_paciente_solicitar_agendamento
(
  paciente_solicitar_agendamento_id serial,
  paciente_id integer,
  data text,
  hora text,
  convenio_id integer,
  procedimento_convenio_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_paciente_solicitar_agendamento_pkey PRIMARY KEY (paciente_solicitar_agendamento_id)
);

ALTER TABLE ponto.tb_paciente_solicitar_agendamento ADD COLUMN confirmado boolean DEFAULT false;

ALTER TABLE ponto.tb_paciente_solicitar_agendamento ADD COLUMN procedimento_text text;
ALTER TABLE ponto.tb_paciente_solicitar_agendamento ADD COLUMN convenio_text text;

ALTER TABLE ponto.tb_posts_blog ADD COLUMN plano_id integer;


CREATE TABLE ponto.tb_registro_dispositivo
(
  registro_dispositivo_id serial NOT NULL,
  hash text,
  medico_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  confirmado boolean DEFAULT true,
  CONSTRAINT tb_registro_dispositivo_pkey PRIMARY KEY (registro_dispositivo_id)
);

ALTER TABLE ponto.tb_registro_dispositivo ADD COLUMN paciente_id integer;

ALTER TABLE ponto.tb_paciente ADD COLUMN rendimentos numeric(10,2);

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_vendedor_externo_mensal numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_vendedor_externo numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_vendedor_pj numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_vendedor_pj_mensal numeric(10,2);

ALTER TABLE ponto.tb_paciente_solicitar_agendamento ADD COLUMN data_cadastro timestamp without time zone;
ALTER TABLE ponto.tb_paciente_solicitar_agendamento ADD COLUMN operador_cadastro integer;

ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_indicacao numeric(10,2);
ALTER TABLE ponto.tb_forma_pagamento ADD COLUMN comissao_indicacao_mensal numeric(10,2);

ALTER TABLE ponto.tb_empresa ADD COLUMN tipo_declaracao INTEGER;

CREATE TABLE ponto.tb_voucher_consulta
(
  voucher_consulta_id serial NOT NULL,
  data date,
  horario time without time zone,
  consulta_avulsa_id integer,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_voucher_consulta_pkey PRIMARY KEY (voucher_consulta_id)
);

ALTER TABLE ponto.tb_voucher_consulta ADD COLUMN parceiro_id integer;

ALTER TABLE ponto.tb_consultas_avulsas ADD COLUMN utilizada boolean DEFAULT false;


ALTER TABLE ponto.tb_paciente ADD COLUMN indicacao_id integer;

ALTER TABLE ponto.tb_paciente ADD COLUMN usuario_app text;
ALTER TABLE ponto.tb_paciente ADD COLUMN senha_app text;

ALTER TABLE ponto.tb_empresa ADD COLUMN cadastro boolean DEFAULT false;

ALTER TABLE ponto.tb_paciente ADD COLUMN whatsapp text;

ALTER TABLE ponto.tb_paciente_contrato ADD COLUMN data_declaracao timestamp without time zone;
--14/04/2020

ALTER TABLE ponto.tb_saldo ADD COLUMN empresa_cadastro_id integer;

CREATE TABLE ponto.tb_impressoes_contratro_dependente
(
  impressoes_contratro_dependente_id  serial NOT NULL,
  paciente_contrato_dependente_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  paciente_id integer,
  paciente_contrato_id integer,
  CONSTRAINT tb_impressoes_contratro_dependente_pkey PRIMARY KEY (impressoes_contratro_dependente_id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE ponto.tb_impressoes_contratro_dependente
  OWNER TO postgres;

ALTER TABLE ponto.tb_impressoes_contratro_dependente ADD COLUMN ativo boolean;
ALTER TABLE ponto.tb_impressoes_contratro_dependente ALTER COLUMN ativo SET DEFAULT true;

--16/04/2020

ALTER TABLE ponto.tb_empresa_cadastro ADD COLUMN financeiro_credor_devedor_id integer;
ALTER TABLE ponto.tb_financeiro_credor_devedor ADD COLUMN empresa_cadastro_id integer;

ALTER TABLE ponto.tb_voucher_consulta ADD COLUMN confirmado boolean DEFAULT false;

ALTER TABLE ponto.tb_voucher_consulta ADD COLUMN horario_uso timestamp without time zone;

ALTER TABLE ponto.tb_voucher_consulta ADD COLUMN parceiro_atualizacao integer;

-- 23/04/2020
ALTER TABLE ponto.tb_empresa ADD COLUMN relacao_carencia boolean;
ALTER TABLE ponto.tb_empresa ALTER COLUMN relacao_carencia SET DEFAULT false;


-- 02/05/2020
ALTER TABLE ponto.tb_voucher_consulta ADD COLUMN gratuito boolean;
ALTER TABLE ponto.tb_voucher_consulta ALTER COLUMN gratuito SET DEFAULT false;
--30/04/2020

ALTER TABLE ponto.tb_financeiro_parceiro ADD COLUMN enderecomed_ip character varying(200);
ALTER TABLE ponto.tb_financeiro_parceiro ADD COLUMN parceriamed_id integer;

--04/05/2020
ALTER TABLE ponto.tb_voucher_consulta ADD COLUMN rendimento_id INTEGER;


ALTER TABLE ponto.tb_precadastro ADD COLUMN email text;
ALTER TABLE ponto.tb_precadastro ADD COLUMN senha_app text;
ALTER TABLE ponto.tb_precadastro ADD COLUMN whatsapp text;
ALTER TABLE ponto.tb_precadastro ADD COLUMN nascimento date;
--07/05/2020
ALTER TABLE ponto.tb_paciente_contrato_parcelas ADD COLUMN plano_id integer;


--08/05/2020
ALTER TABLE ponto.tb_financeiro_parceiro ADD COLUMN parceriapadrao boolean;
ALTER TABLE ponto.tb_financeiro_parceiro ALTER COLUMN parceriapadrao SET DEFAULT false;

--01/06/2020
ALTER TABLE ponto.tb_empresa ADD COLUMN agenciaSicoob character varying(100);
ALTER TABLE ponto.tb_empresa ADD COLUMN contacorrenteSicoob character varying(100);
ALTER TABLE ponto.tb_empresa ADD COLUMN codigobeneficiarioSicoob character varying(100);
