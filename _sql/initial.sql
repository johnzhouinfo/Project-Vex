-- User table
CREATE TABLE public.vex_user
(
    "user_id" numeric(10,0)[] NOT NULL,
    "username" character(255) COLLATE pg_catalog."default" NOT NULL,
    "password" character(255) COLLATE pg_catalog."default",
    "name" character(255) COLLATE pg_catalog."default",
    "email" character(255) COLLATE pg_catalog."default",
    "type" character(255) COLLATE pg_catalog."default",
    "icon" character(255) COLLATE pg_catalog."default",
    "creat_time" date,
    "is_enable" character(255) COLLATE pg_catalog."default",
    CONSTRAINT vex_user_pkey PRIMARY KEY ("user_id")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

-- Component table
CREATE TABLE public.vex_component
(
    "component_id" numeric(10,0) NOT NULL,
    "component_name" character(255) COLLATE pg_catalog."default",
    "icon" character(255) COLLATE pg_catalog."default",
    "code" character(255) COLLATE pg_catalog."default",
    "is_enable" character(255) COLLATE pg_catalog."default",
    "is_delete" numeric(2,0),
    CONSTRAINT "component_pkey" PRIMARY KEY ("component_id")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

-- Product Table
CREATE TABLE public.vex_product
(
    "product_id" numeric(10,0) NOT NULL,
    "user_id" numeric(10,0)[] NOT NULL,
    "product_name" character(255) COLLATE pg_catalog."default",
    "code" character(255) COLLATE pg_catalog."default",
    "create_time" date,
    "is_live" numeric(2,0),
    "is_delete" numeric(2,0),
    CONSTRAINT "PKey" PRIMARY KEY ("product_id"),
    CONSTRAINT "Foreign Key" FOREIGN KEY ("user_id")
        REFERENCES public.vex_user ("user_id") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;