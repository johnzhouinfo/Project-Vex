-- user table
-- user type: 0 for Admin user, 1 for Normal user
CREATE TABLE public.vex_user
(
    user_id serial NOT NULL PRIMARY KEY,
    username character(255) NOT NULL UNIQUE,
    password character(255) NOT NULL,
    name character(255),
    email character(255),
    type integer DEFAULT 1,
    icon text,
    create_time timestamp,
    is_enable boolean DEFAULT true
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

-- Admin user
-- Password(SHA256): 123456
INSERT INTO public.vex_user(
    user_id, username, password, name, email, type, create_time)
    VALUES ( '1' ,'admin', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'admin', 'admin@vex.com', 0, '2020-02-20 20:20:20');

-- Component table
CREATE TABLE public.vex_component
(
    component_id serial NOT NULL PRIMARY KEY,
    component_name character(255),
    icon text,
    code text,
    is_enable boolean DEFAULT true,
    is_delete boolean DEFAULT false
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

-- Product Table
CREATE TABLE public.vex_product
(
    product_id serial NOT NULL PRIMARY KEY,
    user_id integer NOT NULL,
    product_name character(255),
    code text,
    create_time timestamp,
    is_live boolean DEFAULT false,
    is_delete boolean DEFAULT false
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

CREATE TABLE public.vex_ticket
(
    ticket_id serial NOT NULL PRIMARY KEY,
    user_id integer,
	name character(255),
	email character(255),
    title character(255),
    msg text,
	reply text,
	reply_by integer,
    create_time timestamp,
	update_time timestamp,
    is_solve boolean DEFAULT false,
    is_delete boolean DEFAULT false
)
WITH (
    OIDS = FALSE
)