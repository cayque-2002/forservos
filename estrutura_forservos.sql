
/*                                      SCRIPT DE CRIAÇÃO ESTRUTURAL DO BANCO                                            */

CREATE TABLE role_usuarios (
    id SERIAL PRIMARY KEY,
    nome_role VARCHAR(20) NOT NULL, 
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);/*admin - user*/

CREATE UNIQUE INDEX idx_role_nome ON role_usuarios(nome_role);

INSERT INTO role_usuarios (nome_role) VALUES ('admin'), ('user');


CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    roleid bigint NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
alter table usuarios
ADD CONSTRAINT fk_usuario_role
FOREIGN KEY (roleid) REFERENCES role_usuarios(id);

/*************************************************************************************************************************/

CREATE TABLE estado (
    id SERIAL PRIMARY KEY,
    nome_estado VARCHAR(255) not null,
    uf varchar(2) not null,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*************************************************************************************************************************/

CREATE TABLE cidade (
    id SERIAL PRIMARY KEY,
    nome_cidade VARCHAR(255) not null,
    estadoid bigint not null,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
alter table cidade
ADD CONSTRAINT fk_cidade_estado
FOREIGN KEY (estadoid) REFERENCES estado(id);

/*************************************************************************************************************************/

CREATE TABLE enderecos (
    id SERIAL PRIMARY KEY,
    logradouro VARCHAR(200) not null,
    bairro VARCHAR(100)  not null,
    cep varchar(10) not null,
    cidadeid bigint not null,
    complemento_endereco varchar(100),/*complemento genérico do endereco(PARA O ENDEREÇO NÃO PARA O CLIENTE) caso precise*/
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
alter table enderecos
ADD CONSTRAINT fk_endereco_cidade
FOREIGN KEY (cidadeid) REFERENCES cidade(id);

/*************************************************************************************************************************/

CREATE TABLE situacaoclientes (
    id SERIAL PRIMARY KEY,
    descricao_situacao VARCHAR(255) not null,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);/*exemplo ativo - inativo - inadimplente*/

/*************************************************************************************************************************/

/*COLOCAR UMA ESTRUTURA DE CONTRATO POR CLIENTE VAI FUGIR DO QUE FOI SUGERIDO NO TESTE*/
CREATE TABLE clientes (
    id SERIAL PRIMARY KEY,
    nome_cliente VARCHAR(255) not null,
    cpf VARCHAR(11) unique not null,
    situacaoclienteid bigint not null,
    enderecoid bigint not null,
    numero_endereco integer not null,
    complemento_cliente varchar(300), /*aqui que vamos identificar se for casa dos fundos(ex 123-A) ou bloco e apartamento se for predio*/
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
alter table clientes
ADD CONSTRAINT fk_cliente_situacao
FOREIGN KEY (situacaoclienteid) REFERENCES situacaoclientes(id);

alter table clientes
ADD CONSTRAINT fk_cliente_endereco
FOREIGN KEY (enderecoid) REFERENCES enderecos(id);

CREATE INDEX idx_clientes_cpf ON clientes(cpf);

/*************************************************************************************************************************/

CREATE TABLE tipoprazogarantia (
    id SERIAL PRIMARY KEY,
    descricao_prazo VARCHAR(3) not null,/*ano,mês,dia*/
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*************************************************************************************************************************/

CREATE TABLE statusproduto (
    id SERIAL PRIMARY KEY,
    descricao_status varchar(50),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
/*exemplos: em estoque - sem estoque - bloqueado*/

/*************************************************************************************************************************/

CREATE TABLE produtos (
    id SERIAL PRIMARY key not null,
    codproduto bigint not null,
    descricao_produto varchar(255) not null,
    valor_produto decimal(10,2) not null,
    statusid bigint not null,
    tipoprazogarantiaid bigint not null,
    tempo_garantia integer not null,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
alter table produtos
ADD CONSTRAINT fk_produto_status
FOREIGN KEY (statusid) REFERENCES statusproduto(id);

alter table produtos
ADD CONSTRAINT fk_produto_garantia
FOREIGN KEY (tipoprazogarantiaid) REFERENCES tipoprazogarantia(id);

CREATE INDEX idx_produtos_status ON produtos(statusid);

/*************************************************************************************************************************/

CREATE TABLE situacaoos (
    id SERIAL PRIMARY KEY,
    descricao_situacao_os VARCHAR(50) not null,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);/*exemplo Pendente - Em atendimento - Finalizada - Cancelada*/

/*************************************************************************************************************************/

CREATE TABLE ordemservico (
    id SERIAL PRIMARY KEY,
    numos bigint not null,
    situacaoosid bigint  default 1 not null,
    clienteid bigint not null,
    produtoid bigint not null,
    cidadeid bigint not null,
    observacao varchar(500),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
alter table ordemservico
ADD CONSTRAINT fk_os_cliente
FOREIGN KEY (clienteid) REFERENCES clientes(id);

alter table ordemservico
ADD CONSTRAINT fk_os_produto
FOREIGN KEY (produtoid) REFERENCES produtos(id);

alter table ordemservico
ADD CONSTRAINT fk_os_cidade
FOREIGN KEY (cidadeid) REFERENCES cidade(id);

alter table ordemservico
ADD CONSTRAINT fk_os_situacao
FOREIGN KEY (situacaoosid) REFERENCES situacaoos(id);

CREATE INDEX idx_os_cliente ON ordemservico(clienteid);

/*************************************************************************************************************************/

CREATE TABLE ordemservico_logs (
    id SERIAL PRIMARY KEY,
    ordemservicoid bigint NOT NULL,
    acao VARCHAR(50) NOT NULL,
    dados JSONB,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

alter table ordemservico_logs
ADD CONSTRAINT fk_log_os
FOREIGN KEY (ordemservicoid) REFERENCES ordemservico(id);

/*************************************************************************************************************************/

/*
 * FLUXO ->  Cria os estados/cidades que forem usar com seus respectivos vinculos;
 * 			 Cria os status de produto e tipos de prazo garantia;
 * 			 Cria o produto que ira vender vinculando seu status e tipo de prazo garantia;	
 * 			 Quando for cadastrar um cliente, poderá buscar um endereço ja cadastrado, ou cadastrar um novo;
 * 			 O cliente ele terá situação, o vinculo do endereco, o numero da residencia e complemento do lugar;
 * 			 Cria as situações que usara na ordemservico;
 * 			 Quando criar a ordemservico basta vincular o cliente, produto, cidade e se precisar observação;
 * 			 Por padrão a ordemservico quando criada ficará como pendente;
 * 			 
 * 			 
 * 
 * */

/*VISUALIZAÇÃO GERAL UML ESTRUTURAL*/

/*ESTADO (1) ──── (N) CIDADE
CIDADE (1) ──── (N) ENDERECOS
ENDERECOS (1) ──── (N) CLIENTES
SITUACAOCLIENTES (1) ──── (N) CLIENTES

STATUSPRODUTO (1) ──── (N) PRODUTOS
TIPOPRAZOGARANTIA (1) ──── (N) PRODUTOS

CLIENTES (1) ──── (N) ORDEMSERVICO
PRODUTOS (1) ──── (N) ORDEMSERVICO
CIDADE (1) ──── (N) ORDEMSERVICO
SITUACAOOS (1) ──── (N) ORDEMSERVICO

ORDEMSERVICO (1) ──── (N) ORDEMSERVICO_LOGS*/


/*                                                   AUDITORIAS                                                          */



-- DROP FUNCTION public.func_criar_auditoria(text, text, text);

CREATE OR REPLACE FUNCTION public.func_criar_auditoria(pesquemaaud text, pesquema text, ptabela text)
 RETURNS void
 LANGUAGE plpgsql
AS $function$
declare
  vSql text;
  vSqlAux text;
  vTabela text := '';
  vReg record;
  vQtde integer := 0;
begin
  -- O Esquema para criação de tabelas de auditoria não pode ser vazio
  if pEsquemaAud = '' then
    raise exception '001:Não foi informado o esquema para as tabelas de auditoria!';
  end if;

  -- O Esquema para buscar as tabelas a serem auditadas não pode ser vazio
  if pEsquema = '' then
    raise exception '002:Não foi informado o esquema das tabelas a serem auditadas!';
  end if;

  -- Verifica se existe o esquema para serem criadas as tabelas de auditoria
  select into vQtde count(*) from information_schema.schemata sc
  where sc.schema_name = pEsquemaAud;
  if vQtde = 0 then
    raise exception '003:Esquema de auditoria não existe!';
  end if;

  -- Verifica se existe o esquema das tabelas a serem auditadas
  select into vQtde count(*) from information_schema.schemata sc
  where sc.schema_name = pEsquema;
  if vQtde = 0 then
    raise exception '004:Esquema de tabelas a serem auditadas não existe!';
  end if;

raise notice 'pTabela %',pTabela;
  -- Verifica se existe a tabela a ser auditada caso a mesma tenha sido passada por
  -- parâmetro
  if pTabela is not null and pTabela <> '' then
    select into vQtde count(*) from information_schema.tables tb
    where tb.table_schema = pEsquema and tb.table_type = 'BASE TABLE'
    and tb.table_name = replace(pTabela,'"','');
    if vQtde = 0 then
      raise exception '005:Não foi encontrada a tabela a ser auditada!';
    end if;
  end if;

  -- Verifica se existe a linguagem plpgsql
  select into vQtde count(*) from pg_catalog.pg_language ln
  where ln.lanname = 'plpgsql';
  if vQtde = 0 then
    raise exception '006:Linguagem PLPGSQL não existe para a base de dados!';
  end if;

  -- Monta a variável de controle para buscar as tabelas a serem auditadas
  if pTabela is not null and pTabela <> '' then
    vTabela := ' and tb.table_name = '''||pTabela||'''';
  end if;

  -- Lê as tabelas a serem auditadas e monta as tabelas no esquema de auditoria
  vSql := 'select tb.table_schema, tb.table_name from information_schema.tables tb '||
    'where tb.table_schema = '''||pEsquema||''' and tb.table_type = ''BASE TABLE'' '||
    'and tb.table_name <> ''auditoria_template'' and tb.table_name <> ''consultasql'' '||
    replace(vTabela,'"','')||' group by tb.table_schema, tb.table_name '||
    'order by tb.table_schema, tb.table_name';
   raise notice '%',vSql; -- Mostra o comando que traz as tabelas a serem auditadas
  for vReg in execute vSql
  loop
    /*
      Monta os comandos de inclusão das tabelas de auditoria caso a mesma
      ainda não exista
    */
    
    raise notice 'vReg';
    --vReg.table_name := replace(vReg.table_name,'"','');
    
    
    -- Verifica se a tabela a ser criada já existe
    select into vQtde count(*) from information_schema.tables tb
    where tb.table_schema = pEsquemaAud and tb.table_type = 'BASE TABLE'
    and tb.table_name = 'aud_'||vReg.table_name;
    if vQtde = 0 then
      -- Cria a tabela a ser auditada
      vSqlAux := 'CREATE TABLE '||pEsquemaAud||'.aud_'||vReg.table_name||' WITHOUT OIDS AS '||
        'SELECT * FROM public.auditoria_template CROSS JOIN '||vReg.table_schema||'.'||
        pTabela||';';
       raise notice '%',vSqlAux; --Mostra o comando que cria a tabela de auditoria
      execute vSqlAux;
      if not found then
        raise exception '102:Não foi possível criar a tabela: %.aud_%.',
          pEsquemaAud,vReg.table_name;
      end if;
      -- Cria a Sequence para a tabela de auditoria
      vSqlAux := 'CREATE SEQUENCE '||pEsquemaAud||'.aud_'||vReg.table_name||'_idaud_seq;';
      -- raise notice '%',vSqlAux; --Mostra comando que cria a sequence
      execute vSqlAux;
      if not found then
        raise exception '105:Não foi possível criar a sequence para a tabela: %.aud_%',
          pEsquemaAud,vReg.table_name;
      end if;
      -- Modifica o campo idaud da tabela para ser chave primária e usar a sequence
      vSqlAux := 'ALTER TABLE '||pEsquemaAud||'.aud_'||vReg.table_name||'  '||
        'ALTER COLUMN idaud SET DEFAULT nextval('''||pEsquemaAud||'.aud_'||vReg.table_name||
        '_idaud_seq''::text),  ALTER COLUMN idaud SET NOT NULL,  '||
        'ADD PRIMARY KEY (idaud);';
      -- raise notice '%',vSqlAux; --Mostra o comando que altera os campos da tabela
      execute vSqlAux;
      if not found then
        raise exception '106:Não foi possível alterar campos da tabela: %.aud_%',
          pEsquemaAud,vReg.table_name;
      end if;
      -- Cria índices auxiliares
      vSqlAux := 'CREATE INDEX aud_'||vReg.table_name||'_tipoaud '||
        'ON '||pEsquemaAud||'.aud_'||vReg.table_name||' (tipoaud);'||
        'CREATE INDEX aud_'||vReg.table_name||'_dataaud '||
        'ON '||pEsquemaAud||'.aud_'||vReg.table_name||' (dataaud);'||
        'CREATE INDEX aud_'||vReg.table_name||'_loginaud '||
        'ON '||pEsquemaAud||'.aud_'||vReg.table_name||' (loginaud);';

      -- Verifica se para a tabela tem o campo ID e inclui índice
      select into vQtde count(ic.column_name) from information_schema.columns ic
      where ic.table_schema = vReg.table_schema and ic.table_name = pTabela
      and ic.column_name = 'id';
      if vQtde <> 0 then
        vSqlAux := vSqlAux||'CREATE INDEX aud_'||vReg.table_name||'_id '||
          'ON '||pEsquemaAud||'.aud_'||vReg.table_name||' (id);';
      end if;
      -- raise notice '%',vSqlAux; --Mostra o comando de criação dos índices
      execute vSqlAux;
      if not found then
        raise exception '107:Não foi possível criar índices auxiliares da tabela: %.aud_%',
          pEsquemaAud,vReg.table_name;
      end if;
      -- Cria o comentário para a tabela
      vSqlAux := 'COMMENT ON TABLE '||pEsquemaAud||'.aud_'||vReg.table_name||' IS '||
        '''Auditoria da tabela: '||vReg.table_schema||'.'||pTabela||''';';
      -- raise notice '%',vSqlAux; -- Mostra o comando que cria o comentário para a tabela de auditoria
      execute vSqlAux;
      if not found then
        raise exception '103:Não foi possível incluir comentário para a tabela: %.aud_%.',
          pEsquemaAud,vReg.table_name;
      end if;
      -- Dá permissão para os usuários incluirem dados na tabela de auditoria
      vSqlAux := 'GRANT INSERT ON TABLE '||pEsquemaAud||'.aud_'||vReg.table_name||
        ' TO PUBLIC;';
      -- raise notice '%',vSqlAux; -- Mostra o comando de permissão para a tabela de auditoria
      execute vSqlAux;
      if not found then
        raise exception '104:Não foi possível dar permissão de inclusão para os usuários na tabela: %.aud_%.',
        pEsquemaAud,vReg.table_name;
      end if;
      

      -- Cria a função de auditoria para a tabela
      vSqlAux := 'create or replace function '||pEsquemaAud||'.func_aud_'||vReg.table_name||'() '||
        'returns trigger as '||
        '$corpofuncao$ '||
        'begin '||
        '  if TG_OP = ''UPDATE'' then '||
        '    insert into '||pEsquemaAud||'.aud_'||vReg.table_name||' '||
        '    select nextval('''||pEsquemaAud||'.aud_'||vReg.table_name||'_idaud_seq''::text), '||
        '    ''U'', now(), '||
        '    case when inet_client_addr() is null then ''localhost'' '||
        '    else inet_client_addr()::varchar ||'':''||inet_client_port() end, '||
        '    session_user, NEW.*; '||
        '    if not found then '||
        '      Raise Notice ''Ocorreu um erro durante a auditoria de dados!''; '||
        '      Raise Notice ''SQLSTATE: %'', SQLSTATE; '||
        '      Raise Notice ''ERROR: %'', SQLERRM; '||
        '      return null; '||
        '    end if; '||
        '  elsif TG_OP = ''INSERT'' then '||
        '    insert into '||pEsquemaAud||'.aud_'||vReg.table_name||' '||
        '    select nextval('''||pEsquemaAud||'.aud_'||vReg.table_name||'_idaud_seq''::text), '||
        '    ''I'', now(), '||
        '    case when inet_client_addr() is null then ''localhost'' '||
        '    else inet_client_addr()::varchar ||'':''||inet_client_port() end, '||
        '    session_user, NEW.*; '||
        '    if not found then '||
        '      Raise Notice ''Ocorreu um erro durante a auditoria de dados!''; '||
        '      Raise Notice ''SQLSTATE: %'', SQLSTATE; '||
        '      Raise Notice ''ERROR: %'', SQLERRM; '||
        '      return null; '||
        '    end if; '||
        '  else '||
        '    insert into '||pEsquemaAud||'.aud_'||vReg.table_name||' '||
        '    select nextval('''||pEsquemaAud||'.aud_'||vReg.table_name||'_idaud_seq''::text), '||
        '    ''D'', now(), '||
        '    case when inet_client_addr() is null then ''localhost'' '||
        '    else inet_client_addr()::varchar ||'':''||inet_client_port() end, '||
        '    session_user, OLD.*; '||
        '    if not found then '||
        '      Raise Notice ''Ocorreu um erro durante a auditoria de dados!''; '||
        '      Raise Notice ''SQLSTATE: %'', SQLSTATE; '||
        '      Raise Notice ''ERROR: %'', SQLERRM; '||
        '      return null; '||
        '    end if; '||
        '  end if; '||
        '  '||
        '  return null; '||
        'end; '||
        '$corpofuncao$ '||
        'language ''plpgsql'';';
      execute vSqlAux;
      if not found then
        raise exception '105:Não foi possível criar a função de auditoria para a tabela: %.aud_%.',
        pEsquemaAud,vReg.table_name;
      end if;

      -- Criar a Trigger de auditoria
      vSqlAux := 'create trigger auditoria after insert or update or delete on '||
        vReg.table_schema||'.'||pTabela||' for each row '||
        'execute procedure '||pEsquemaAud||'.func_aud_'||vReg.table_name||'();';
      execute vSqlAux;
      if not found then
        raise exception '106:Não foi possível criar a TRIGGER de auditoria para a tabela: %.aud_%.',
        pEsquemaAud,vReg.table_name;
      end if;
    else
       raise notice '101:==>A tabela %.aud_% já existe, tabela ignorada.',pEsquemaAud,vReg.table_name;
    end if;
  end loop;
end;
$function$
;

CREATE TABLE public.auditoria_template (
	idaud bigserial NOT NULL,
	tipoaud varchar(1) NOT NULL,
	dataaud timestamp DEFAULT now() NOT NULL,
	hostaud varchar(50) NOT NULL,
	loginaud varchar(50) NOT NULL,
	CONSTRAINT auditoria_template_pkey PRIMARY KEY (idaud),
	CONSTRAINT auditoria_template_tipoaud_check CHECK (((tipoaud)::text = ANY (ARRAY[('I'::character varying)::text, ('U'::character varying)::text, ('D'::character varying)::text])))
);

select * from public.func_criar_auditoria('auditoria','public','cidade');
select * from public.func_criar_auditoria('auditoria','public','clientes');
select * from public.func_criar_auditoria('auditoria','public','enderecos');
select * from public.func_criar_auditoria('auditoria','public','estado');
select * from public.func_criar_auditoria('auditoria','public','ordemservico');
select * from public.func_criar_auditoria('auditoria','public','produtos');
select * from public.func_criar_auditoria('auditoria','public','role_usuarios');
select * from public.func_criar_auditoria('auditoria','public','situacaoclientes');
select * from public.func_criar_auditoria('auditoria','public','situacaoos');
select * from public.func_criar_auditoria('auditoria','public','statusproduto');
select * from public.func_criar_auditoria('auditoria','public','tipoprazogarantia');
select * from public.func_criar_auditoria('auditoria','public','usuarios');


