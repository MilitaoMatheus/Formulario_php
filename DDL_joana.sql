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

create table tbl_tipo_lancamento(
	id_tipo_lancamento int primary key auto_increment,
    nome_tipo varchar(50) not null
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

insert into tbl_telefone_usuario(id_usuario, telefone, tipo_telefone)
values(1, '(11) 92323-2323', 'Celular'),
	  (1, '(11) 99999-9999', 'Empresarial'),
      (1, '(11) 91111-1111', 'Celular'),
      (2, '(11) 93333-3333', 'Fixo'),
      (2, '(11) 94444-4444', 'Celular');
select * from tbl_telefone_usuario where id_usuario=1;
select * from tbl_usuario;

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
      
select * from tbl_usuario;
select * from tbl_despesa;
select * from tbl_tipo_receita;
select * from tbl_receita;