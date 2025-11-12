create database joana_db;
use joana_db;

create table tbl_usuario(
	id_usuario int primary key auto_increment,
    CPF varchar(14) unique,
    email_usuario varchar(100) not null unique,
    nome_usuario varchar(100) not null,
    data_nasc date not null,
    senha varchar(255) not null
);

create table tbl_tipo_receita(
	id_tipo_receita int primary key auto_increment,
    nome_receita varchar(50) not null
);

create table tbl_receita(
	id_receita int primary key auto_increment,
    id_usuario int not null,
    id_tipo_receita int not null,
    valor decimal(10,2) not null,
    data_recebimento date
);

create table tbl_tipo_despesa(
	id_tipo_despesa int primary key auto_increment,
    nome_despesa varchar(50) not null
);

create table tbl_despesa(
	id_despesa int primary key auto_increment,
    id_usuario int not null,
    id_tipo_despesa int not null,
    valor decimal(10,2) not null,
    data_pagamento date
);

create table tbl_tipo_pagamento(
	id_tipo_pagamento int primary key auto_increment,
    metodo_pagamento varchar(50) not null
);

create table tbl_pagamento(
	id_pagamento int primary key auto_increment,
    id_despesa int not null,
    id_tipo_pagamento int not null,
    valor decimal(10,2) not null,
    data_pagamento date not null
);

-- tbl_receita -> tbl_usuario
alter table tbl_receita
add constraint fk_receita_usuario
foreign key (id_usuario) references tbl_usuario(id_usuario);

-- tbl_receita -> tbl_tipo_receita
alter table tbl_receita
add constraint fk_receita_tipo
foreign key (id_tipo_receita) references tbl_tipo_receita(id_tipo_receita);

-- tbl_despesa -> tbl_usuario
alter table tbl_despesa
add constraint fk_despesa_usuario
foreign key (id_usuario) references tbl_usuario(id_usuario);

-- tbl_despesa -> tbl_tipo_despesa
alter table tbl_despesa
add constraint fk_despesa_tipo
foreign key (id_tipo_despesa) references tbl_tipo_despesa(id_tipo_despesa);

-- tbl_pagamento -> tbl_tipo_pagamento
alter table tbl_pagamento
add constraint fk_pagamento_despesa
foreign key (id_despesa) references tbl_despesa(id_despesa);

-- tbl_pagamento -> tbl_tipo_pagamento
alter table tbl_pagamento
add constraint fk_pagamento_tipo
foreign key (id_tipo_pagamento) references tbl_tipo_pagamento(id_tipo_pagamento);

/*
insert into tbl_tipo_receita (nome_receita)
values('Salário'),
	  ('Freelancer'),
	  ('Investimento'),
	  ('Venda produtos');
select * from tbl_tipo_receita;

insert into tbl_tipo_despesa(nome_despesa)
values('Alimentação/Refeição'),
	  ('Transporte'),
      ('Lazer'),
      ('Moradia'),
      ('Educaão');
select * from tbl_tipo_despesa;

insert into tbl_tipo_pagamento(metodo_pagamento)
values('Débito'),
	  ('Crédito'),
      ('Pix'),
      ('Dinheiro'),
      ('Boleto');
select * from tbl_tipo_pagamento;

insert into tbl_receita(id_usuario, id_tipo_receita, valor, data_recebimento)
values(1, 1, 3500.00, '2025-10-01'),
	  (1, 2, 800.00, '2025-10-10'),
      (2, 3, 1200.00, '2025-09-25');
      
insert into tbl_despesa(id_usuario, id_tipo_despesa, valor, data_pagamento)
values(1, 1, 150.00, '2025-10-02'),
	  (1, 2, 200.00, '2025-10-05'),
      (2, 3, 900.00, '2025-09-28');
      
insert into tbl_pagamento(id_despesa, id_tipo_pagamento, valor, data_pagamento)
values(1, 3, 150.00, '2025-10-02'),
	  (2, 2, 200.00, '2025-10-05'),
      (3, 4, 100.00, '2025-10-08');
      
*/

insert into tbl_usuario (CPF, email_usuario, nome_usuario, data_nasc, senha)
values('123.456.789-00', 'matheus.militao@email.com', 'Matheus Militão', '2006-05-12', 'senha123'),
	  ('987.654.321-00', 'ana.souza@email.com', 'Ana Souza', '1999-09-22', '123senha'),
	  ('456.123.789-00', 'joao.pereira@email.com', 'João Pereira', '2001-02-15', 'abc123'),
	  ('321.654.987-00', 'maria.santos@email.com', 'Maria Santos', '1995-07-03', 'senha@2024'),
	  ('159.753.486-00', 'lucas.almeida@email.com', 'Lucas Almeida', '2003-11-10', 'lucas321');
select * from tbl_usuario;

insert into tbl_tipo_receita (nome_receita)
valueS('Salário'),
	  ('Freelancer'),
	  ('Investimento'),
	  ('Venda de Produtos'),
	  ('Aluguel de Imóvel');
select * from tbl_tipo_receita;

insert into tbl_receita (id_usuario, id_tipo_receita, valor, data_recebimento)
values(1, 1, 3500.00, '2025-10-01'),
	  (1, 2, 800.00, '2025-10-10'),
	  (2, 3, 1200.00, '2025-09-25'),
	  (3, 4, 600.00, '2025-10-05'),
	  (4, 1, 4200.00, '2025-09-30'),
	  (5, 5, 1500.00, '2025-10-02');
select * from tbl_receita;


insert into tbl_tipo_despesa (nome_despesa)
values('Alimentação/Refeição'),
	  ('Transporte'),
	  ('Lazer'),
	  ('Moradia'),
	  ('Educação'),
	  ('Saúde');
select * from tbl_tipo_despesa;

insert into tbl_despesa (id_usuario, id_tipo_despesa, valor, data_pagamento)
values(1, 1, 150.00, '2025-10-02'),
	  (1, 2, 200.00, '2025-10-05'),
	  (2, 3, 900.00, '2025-09-28'),
	  (3, 4, 1200.00, '2025-10-07'),
	  (4, 5, 600.00, '2025-09-29'),
	  (5, 6, 300.00, '2025-10-03');
select * from tbl_despesa;

insert into tbl_tipo_pagamento (metodo_pagamento)
values('Débito'),
	  ('Crédito'),
	  ('Pix'),
	  ('Dinheiro'),
	  ('Boleto');
select * from tbl_tipo_pagamento;

insert into tbl_pagamento (id_despesa, id_tipo_pagamento, valor, data_pagamento)
values(1, 3, 150.00, '2025-10-02'),
	  (2, 2, 200.00, '2025-10-05'),
	  (3, 4, 900.00, '2025-09-28'),
	  (4, 1, 1200.00, '2025-10-07'),
	  (5, 5, 600.00, '2025-09-29'),
	  (6, 3, 300.00, '2025-10-03');
select * from tbl_pagamento;

select 
    r.id_receita,
    u.nome_usuario,
    tr.nome_receita as tipo_receita,
    r.valor,
    r.data_recebimento
from tbl_receita r
inner join tbl_usuario u on r.id_usuario = u.id_usuario
inner join tbl_tipo_receita tr on r.id_tipo_receita = tr.id_tipo_receita
order by u.nome_usuario, r.data_recebimento;

select 
    d.id_despesa,
    u.nome_usuario,
    td.nome_despesa as tipo_despesa,
    d.valor,
    d.data_pagamento
from tbl_despesa d
inner join tbl_usuario u on d.id_usuario = u.id_usuario
inner join tbl_tipo_despesa td on d.id_tipo_despesa = td.id_tipo_despesa
order by u.nome_usuario, d.data_pagamento;