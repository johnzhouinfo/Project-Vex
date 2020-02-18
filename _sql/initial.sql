-- Table: public."Component"

-- DROP TABLE public."Component";

CREATE TABLE public."Component"
(
    "CompoentID" numeric(10,0) NOT NULL,
    "Is_enable" character(255) COLLATE pg_catalog."default",
    "CName" character(255) COLLATE pg_catalog."default",
    "CIcon" character(255) COLLATE pg_catalog."default",
    "Code" character(255) COLLATE pg_catalog."default",
    "CIs_Delete" numeric(2,0),
    CONSTRAINT "Component_pkey" PRIMARY KEY ("CompoentID")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public."Component"
    OWNER to postgres;

-- Table: public.vex_product

-- DROP TABLE public.vex_product;

CREATE TABLE public.vex_product
(
    "ProductID" numeric(10,0) NOT NULL,
    "UserID" numeric(10,0)[] NOT NULL,
    "Product_Name" character(255) COLLATE pg_catalog."default",
    "Time" date,
    "HTML/CSS" character(255) COLLATE pg_catalog."default",
    "Is_Live" numeric(2,0),
    "Is_Delete" numeric(2,0),
    CONSTRAINT "PKey" PRIMARY KEY ("ProductID"),
    CONSTRAINT "Foreign Key" FOREIGN KEY ("UserID")
        REFERENCES public.vex_user ("UserID") MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.vex_product
    OWNER to postgres;

-- Table: public.vex_user

-- DROP TABLE public.vex_user;

CREATE TABLE public.vex_user
(
    "UserName" character(255) COLLATE pg_catalog."default" NOT NULL,
    "Password" character(255) COLLATE pg_catalog."default",
    "Name" character(255) COLLATE pg_catalog."default",
    "Email" character(255) COLLATE pg_catalog."default",
    "Type" character(255) COLLATE pg_catalog."default",
    "Creat_Time" date,
    "UserID" numeric(10,0)[] NOT NULL,
    "Is_Enable" character(255) COLLATE pg_catalog."default",
    CONSTRAINT vex_user_pkey PRIMARY KEY ("UserID")
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.vex_user
    OWNER to postgres;