--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.5
-- Dumped by pg_dump version 9.6.5

-- Started on 2018-03-06 14:13:51

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12387)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2536 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 185 (class 1259 OID 80196)
-- Name: acceso; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE acceso (
    id bigint DEFAULT nextval(('"acceso_id_seq"'::text)::regclass) NOT NULL,
    menu_id bigint,
    usuario_id bigint
);


ALTER TABLE acceso OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 80200)
-- Name: acceso_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE acceso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE acceso_id_seq OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 80202)
-- Name: almacen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE almacen (
    id bigint DEFAULT nextval(('"almacen_id_seq"'::text)::regclass) NOT NULL,
    descripcion text,
    estado smallint,
    tipo_almacen smallint
);


ALTER TABLE almacen OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 80209)
-- Name: almacen_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE almacen_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE almacen_id_seq OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 80211)
-- Name: caja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE caja (
    id integer DEFAULT nextval(('"caja_id_seq"'::text)::regclass) NOT NULL,
    descripcion text,
    estado smallint,
    sucursal_id bigint
);


ALTER TABLE caja OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 80218)
-- Name: caja_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE caja_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE caja_id_seq OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 80220)
-- Name: cargo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE cargo (
    id integer DEFAULT nextval(('"cargo_id_seq"'::text)::regclass) NOT NULL,
    descripcion text
);


ALTER TABLE cargo OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 80227)
-- Name: cargo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cargo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cargo_id_seq OWNER TO postgres;

--
-- TOC entry 268 (class 1259 OID 80550)
-- Name: categoria_interna; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE categoria_interna (
    id bigint DEFAULT nextval(('"categoria_interna_id_seq"'::text)::regclass) NOT NULL,
    descripcion text
);


ALTER TABLE categoria_interna OWNER TO postgres;

--
-- TOC entry 267 (class 1259 OID 80548)
-- Name: categoria_interna_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE categoria_interna_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE categoria_interna_id_seq OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 80229)
-- Name: cierre_sesion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE cierre_sesion (
    id bigint DEFAULT nextval(('"cierre_sesion_id_seq"'::text)::regclass) NOT NULL,
    fecha date,
    sesion_id bigint
);


ALTER TABLE cierre_sesion OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 80233)
-- Name: cierre_sesion_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cierre_sesion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cierre_sesion_id_seq OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 80235)
-- Name: cliente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE cliente (
    id bigint DEFAULT nextval(('"cliente_id_seq"'::text)::regclass) NOT NULL,
    ci_nit text,
    nombre_cliente text,
    telefono text,
    trabajo text,
    estado smallint,
    correo text,
    fecha_registro timestamp without time zone,
    fecha_modificacion timestamp without time zone,
    numero_contacto text,
    nombre_contacto text,
    direccion text,
    usuario_id bigint
);


ALTER TABLE cliente OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 80242)
-- Name: cliente_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cliente_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE cliente_id_seq OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 80244)
-- Name: color; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE color (
    id bigint DEFAULT nextval(('"color_id_seq"'::text)::regclass) NOT NULL,
    descripcion text
);


ALTER TABLE color OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 80251)
-- Name: color_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE color_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE color_id_seq OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 80253)
-- Name: compra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE compra (
    id bigint DEFAULT nextval(('"compra_id_seq"'::text)::regclass) NOT NULL,
    fecha_compra date,
    observacion text,
    subtotal numeric(20,0),
    descuento numeric(20,0),
    monto_total numeric(20,0),
    estado smallint,
    proveedor_id bigint,
    usuario_id bigint,
    sucursal_id bigint,
    fecha_registro date,
    nro_fiscal text
);


ALTER TABLE compra OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 80260)
-- Name: compra_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE compra_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE compra_id_seq OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 80262)
-- Name: detalle_caja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE detalle_caja (
    id integer DEFAULT nextval(('"detalle_caja_id_seq"'::text)::regclass) NOT NULL,
    caja_id bigint,
    sucursal_id bigint,
    usuario_id bigint,
    fecha_apertura date,
    monto_apertura numeric(20,2),
    fecha_cierre date,
    monto_cierre numeric(20,2),
    estado text
);


ALTER TABLE detalle_caja OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 80269)
-- Name: detalle_caja_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE detalle_caja_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE detalle_caja_id_seq OWNER TO postgres;

--
-- TOC entry 203 (class 1259 OID 80271)
-- Name: detalle_compra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE detalle_compra (
    id bigint DEFAULT nextval(('"detalle_compra_id_seq"'::text)::regclass) NOT NULL,
    producto_id bigint,
    compra_id bigint,
    cantidad bigint,
    precio_compra numeric(20,2),
    unidad_id bigint
);


ALTER TABLE detalle_compra OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 80275)
-- Name: detalle_compra_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE detalle_compra_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE detalle_compra_id_seq OWNER TO postgres;

--
-- TOC entry 205 (class 1259 OID 80277)
-- Name: detalle_producto_ingreso; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE detalle_producto_ingreso (
    id bigint,
    ingreso_inventario_id bigint,
    producto_inventario_id bigint,
    cantidad bigint,
    estado smallint
);


ALTER TABLE detalle_producto_ingreso OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 80280)
-- Name: detalle_proforma; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE detalle_proforma (
    id bigint DEFAULT nextval(('"detalle_proforma_id_seq"'::text)::regclass) NOT NULL,
    proforma_id bigint,
    producto_id bigint,
    talla_id bigint,
    color_id bigint,
    cantidad bigint,
    precio_venta numeric(20,2),
    inventario_id bigint
);


ALTER TABLE detalle_proforma OWNER TO postgres;

--
-- TOC entry 207 (class 1259 OID 80284)
-- Name: detalle_proforma_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE detalle_proforma_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE detalle_proforma_id_seq OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 80286)
-- Name: detalle_salida_inventario_sec; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE detalle_salida_inventario_sec
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE detalle_salida_inventario_sec OWNER TO postgres;

--
-- TOC entry 209 (class 1259 OID 80288)
-- Name: detalle_salida_inventario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE detalle_salida_inventario (
    id bigint DEFAULT nextval('detalle_salida_inventario_sec'::regclass) NOT NULL,
    salida_inventario_id bigint,
    producto_inventario_id bigint,
    cantidad bigint,
    estado smallint
);


ALTER TABLE detalle_salida_inventario OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 80292)
-- Name: detalle_venta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE detalle_venta (
    id bigint DEFAULT nextval(('"detalle_venta_id_seq"'::text)::regclass) NOT NULL,
    venta_id bigint,
    producto_id bigint,
    cantidad bigint,
    precio_venta numeric(20,2),
    talla_id bigint,
    color_id bigint,
    inventario_id bigint
);


ALTER TABLE detalle_venta OWNER TO postgres;

--
-- TOC entry 211 (class 1259 OID 80296)
-- Name: detalle_venta_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE detalle_venta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE detalle_venta_id_seq OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 80298)
-- Name: egreso_caja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE egreso_caja (
    id bigint DEFAULT nextval(('"egreso_caja_id_seq"'::text)::regclass) NOT NULL,
    fecha_registro date,
    fecha_egreso date,
    detalle text,
    monto numeric(20,2),
    estado smallint,
    tipo_egreso_id bigint,
    sucursal_id bigint,
    usuario_id bigint
);


ALTER TABLE egreso_caja OWNER TO postgres;

--
-- TOC entry 213 (class 1259 OID 80305)
-- Name: egreso_caja_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE egreso_caja_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE egreso_caja_id_seq OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 80307)
-- Name: egreso_compra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE egreso_compra (
    compra_id bigint NOT NULL,
    egreso_id bigint NOT NULL
);


ALTER TABLE egreso_compra OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 80310)
-- Name: forma_pago; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE forma_pago (
    id bigint DEFAULT nextval(('"forma_pago_id_seq"'::text)::regclass) NOT NULL,
    descripcion text,
    estado smallint
);


ALTER TABLE forma_pago OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 80317)
-- Name: forma_pago_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE forma_pago_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE forma_pago_id_seq OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 80319)
-- Name: ingreso_caja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE ingreso_caja (
    id bigint DEFAULT nextval(('"ingreso_caja_id_seq"'::text)::regclass) NOT NULL,
    fecha_ingreso date,
    detalle text,
    monto numeric(20,2),
    estado smallint,
    tipo_ingreso_id bigint,
    sucursal_id bigint,
    usuario_id bigint,
    fecha_registro date
);


ALTER TABLE ingreso_caja OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 80326)
-- Name: ingreso_caja_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ingreso_caja_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ingreso_caja_id_seq OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 80328)
-- Name: ingreso_inventario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE ingreso_inventario (
    id bigint DEFAULT nextval(('"ingreso_inventario_id_seq"'::text)::regclass) NOT NULL,
    fecha_ingreso date,
    observacion text,
    estado smallint,
    forma_ingreso text,
    almacen_id bigint,
    usuario_id bigint,
    fecha_registro date,
    sucursal_id bigint
);


ALTER TABLE ingreso_inventario OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 80335)
-- Name: ingreso_inventario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ingreso_inventario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE ingreso_inventario_id_seq OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 80337)
-- Name: ingreso_venta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE ingreso_venta (
    venta_id bigint NOT NULL,
    ingreso_id bigint NOT NULL
);


ALTER TABLE ingreso_venta OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 80340)
-- Name: inicio_sesion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE inicio_sesion (
    id bigint DEFAULT nextval(('"inicio_sesion_id_seq"'::text)::regclass) NOT NULL,
    fecha date,
    usuario_id bigint,
    impresora_id bigint
);


ALTER TABLE inicio_sesion OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 80344)
-- Name: inicio_sesion_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE inicio_sesion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE inicio_sesion_id_seq OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 80346)
-- Name: producto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE producto (
    id bigint DEFAULT nextval(('"producto_id_seq"'::text)::regclass) NOT NULL,
    codigo_barra text,
    codigo_alterno text,
    nombre_item text,
    precio_venta numeric(20,2),
    precio_compra numeric(20,2),
    stock_minimo bigint,
    estado smallint,
    tipo_item_id bigint,
    talla_id bigint,
    color_id bigint,
    descripcion text,
    dimension text,
    marca_id bigint,
    categoria_interna_id bigint,
    unidad_medida bigint,
    fecha_registro timestamp without time zone,
    unidad_compra bigint,
    fecha_modificacion timestamp without time zone
);


ALTER TABLE producto OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 80353)
-- Name: producto_inventario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE producto_inventario (
    id bigint DEFAULT nextval(('"producto_inventario_id_seq"'::text)::regclass) NOT NULL,
    cantidad_ingresada bigint,
    ingreso_id bigint,
    producto_id bigint,
    precio_venta numeric(20,2),
    cantidad bigint,
    unidad_id bigint
);


ALTER TABLE producto_inventario OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 80357)
-- Name: sucursal; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE sucursal (
    id bigint DEFAULT nextval(('"sucursal_id_seq"'::text)::regclass) NOT NULL,
    nit text,
    nombre_empresa text,
    sucursal text,
    estado smallint,
    direccion text,
    telefono text,
    email text,
    nombre_impuesto text
);


ALTER TABLE sucursal OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 80364)
-- Name: talla; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE talla (
    id bigint DEFAULT nextval(('"talla_id_seq"'::text)::regclass) NOT NULL,
    descripcion text
);


ALTER TABLE talla OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 80371)
-- Name: tipo_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE tipo_item (
    id bigint DEFAULT nextval(('"tipo_item_id_seq"'::text)::regclass) NOT NULL,
    descripcion text,
    estado smallint
);


ALTER TABLE tipo_item OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 80378)
-- Name: unidad_medida; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE unidad_medida (
    id bigint DEFAULT nextval(('"unidad_medida_id_seq"'::text)::regclass) NOT NULL,
    descripcion text,
    abreviatura text
);


ALTER TABLE unidad_medida OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 80385)
-- Name: inventario; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW inventario WITH (security_barrier='false') AS
 SELECT p.id AS producto_id,
    t.id AS id_talla,
    c.id AS id_color,
    a.id AS id_almacen,
    p.codigo_barra,
    p.codigo_alterno,
    p.nombre_item,
    ti.descripcion AS tipo_producto,
    a.descripcion AS almacen,
    t.descripcion AS talla,
    c.descripcion AS color,
    p.stock_minimo,
    p.precio_venta,
    s.id AS id_sucursal,
    s.sucursal,
    u.descripcion AS unidad,
    sum(pi.cantidad) AS cantidad
   FROM ((((((((tipo_item ti
     JOIN producto p ON ((ti.id = p.tipo_item_id)))
     JOIN producto_inventario pi ON ((p.id = pi.producto_id)))
     JOIN talla t ON ((p.talla_id = t.id)))
     JOIN color c ON ((p.color_id = c.id)))
     JOIN ingreso_inventario i ON ((pi.ingreso_id = i.id)))
     JOIN almacen a ON ((i.almacen_id = a.id)))
     JOIN sucursal s ON ((i.sucursal_id = s.id)))
     JOIN unidad_medida u ON ((pi.unidad_id = u.id)))
  WHERE (p.estado = 1)
  GROUP BY p.id, t.id, c.id, a.id, p.codigo_barra, p.codigo_alterno, p.nombre_item, ti.descripcion, a.descripcion, t.descripcion, c.descripcion, p.stock_minimo, p.precio_venta, s.id, s.sucursal, u.descripcion;


ALTER TABLE inventario OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 80390)
-- Name: inventario_compra; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE inventario_compra (
    compra_id bigint NOT NULL,
    ingreso_id bigint NOT NULL
);


ALTER TABLE inventario_compra OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 80393)
-- Name: inventario_venta; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW inventario_venta AS
 SELECT a.id AS id_almacen,
    p.nombre_item,
    s.id AS id_sucursal,
    s.sucursal
   FROM ((((((((tipo_item ti
     JOIN producto p ON ((ti.id = p.tipo_item_id)))
     JOIN producto_inventario pi ON ((p.id = pi.producto_id)))
     JOIN talla t ON ((p.talla_id = t.id)))
     JOIN color c ON ((p.color_id = c.id)))
     JOIN ingreso_inventario i ON ((pi.ingreso_id = i.id)))
     JOIN almacen a ON ((i.almacen_id = a.id)))
     JOIN sucursal s ON ((i.sucursal_id = s.id)))
     JOIN unidad_medida u ON ((pi.unidad_id = u.id)))
  WHERE (p.estado = 1)
  GROUP BY a.id, p.nombre_item, s.id, s.sucursal;


ALTER TABLE inventario_venta OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 80539)
-- Name: marca; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE marca (
    id bigint DEFAULT nextval(('"marca_id_seq"'::text)::regclass) NOT NULL,
    descripcion text
);


ALTER TABLE marca OWNER TO postgres;

--
-- TOC entry 266 (class 1259 OID 80546)
-- Name: marca_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE marca_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE marca_id_seq OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 80398)
-- Name: menu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE menu (
    id bigint DEFAULT nextval(('"menu_id_seq"'::text)::regclass) NOT NULL,
    parent bigint,
    name text,
    icon text,
    slug text,
    number integer
);


ALTER TABLE menu OWNER TO postgres;

--
-- TOC entry 234 (class 1259 OID 80405)
-- Name: menu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE menu_id_seq OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 80407)
-- Name: movimiento_caja; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE movimiento_caja (
    id bigint DEFAULT nextval(('"movimiento_caja_id_seq"'::text)::regclass) NOT NULL,
    detalle_caja_id bigint,
    fecha date,
    hora time without time zone,
    monto numeric(20,2),
    evento text
);


ALTER TABLE movimiento_caja OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 80414)
-- Name: movimiento_caja_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE movimiento_caja_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE movimiento_caja_id_seq OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 80416)
-- Name: nota_venta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE nota_venta (
    id bigint DEFAULT nextval(('"nota_venta_id_seq"'::text)::regclass) NOT NULL,
    venta_id bigint,
    nro_nota bigint
);


ALTER TABLE nota_venta OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 80420)
-- Name: nota_venta_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nota_venta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE nota_venta_id_seq OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 80422)
-- Name: venta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE venta (
    id bigint DEFAULT nextval(('"venta_id_seq"'::text)::regclass) NOT NULL,
    fecha date,
    subtotal numeric(20,2),
    descuento numeric(20,2),
    total numeric(20,2),
    cliente_id bigint,
    nro_venta bigint,
    estado smallint,
    sucursal_id bigint,
    usuario_id bigint,
    tipo_venta text,
    hora time without time zone
);


ALTER TABLE venta OWNER TO postgres;

--
-- TOC entry 240 (class 1259 OID 80429)
-- Name: venta_pago; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE venta_pago (
    id bigint DEFAULT nextval(('"venta_pago_id_seq"'::text)::regclass) NOT NULL,
    venta_id bigint,
    forma_pago text,
    banco text,
    nro_cuenta text,
    nro_cheque text,
    fecha_pago date,
    vencimiento text,
    monto numeric(20,2),
    saldo numeric(20,2),
    estado text,
    fecha_registro date
);


ALTER TABLE venta_pago OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 80436)
-- Name: pagos; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW pagos AS
 SELECT v.id,
    v.fecha,
    c.id AS cliente_id,
    c.nombre_cliente,
    v.total,
    sum(p.monto) AS total_pagado,
    (v.total - sum(p.monto)) AS saldo,
    p.estado,
    v.sucursal_id
   FROM cliente c,
    venta v,
    venta_pago p
  WHERE ((c.id = v.cliente_id) AND (v.id = p.venta_id) AND (p.forma_pago = 'Credito'::text))
  GROUP BY v.id, c.id, c.ci_nit, c.nombre_cliente, p.estado, v.fecha, v.total, v.sucursal_id;


ALTER TABLE pagos OWNER TO postgres;

--
-- TOC entry 242 (class 1259 OID 80441)
-- Name: producto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE producto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE producto_id_seq OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 80443)
-- Name: producto_inventario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE producto_inventario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE producto_inventario_id_seq OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 80445)
-- Name: proforma; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE proforma (
    id bigint DEFAULT nextval(('"proforma_id_seq"'::text)::regclass) NOT NULL,
    fecha date,
    hora text,
    subtotal numeric(20,2),
    descuento numeric(20,2),
    total numeric(20,2),
    cliente_id bigint,
    nro_proforma bigint,
    estado smallint,
    tipo_venta text,
    sucursal_id bigint,
    usuario_id bigint
);


ALTER TABLE proforma OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 80452)
-- Name: proforma_emitida; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW proforma_emitida AS
 SELECT prof.id,
    prof.fecha,
    prof.subtotal,
    prof.descuento,
    prof.total,
    prof.cliente_id,
    prof.estado,
    prof.sucursal_id,
    prof.usuario_id,
    prof.tipo_venta,
    prof.hora,
    cln.nombre_cliente,
    cln.ci_nit,
    prof.nro_proforma
   FROM proforma prof,
    cliente cln
  WHERE (prof.cliente_id = cln.id);


ALTER TABLE proforma_emitida OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 80456)
-- Name: proforma_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE proforma_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE proforma_id_seq OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 80458)
-- Name: proveedor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE proveedor (
    id bigint DEFAULT nextval(('"proveedor_id_seq"'::text)::regclass) NOT NULL,
    nombre text,
    telefono text,
    direccion text,
    estado smallint
);


ALTER TABLE proveedor OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 80465)
-- Name: proveedor_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE proveedor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE proveedor_id_seq OWNER TO postgres;

--
-- TOC entry 249 (class 1259 OID 80467)
-- Name: salida_inventario_sec; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE salida_inventario_sec
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE salida_inventario_sec OWNER TO postgres;

--
-- TOC entry 250 (class 1259 OID 80469)
-- Name: salida_inventario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE salida_inventario (
    id bigint DEFAULT nextval('salida_inventario_sec'::regclass) NOT NULL,
    observacion text,
    fecha_modificacion timestamp without time zone,
    fecha_registro timestamp without time zone,
    estado smallint,
    tipo_salida_inventario_id bigint,
    almacen_origen_id bigint,
    almacen_destino_id bigint,
    sucursal_id bigint,
    fecha_salida timestamp without time zone,
    usuario_id bigint
);


ALTER TABLE salida_inventario OWNER TO postgres;

--
-- TOC entry 251 (class 1259 OID 80476)
-- Name: sucursal_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sucursal_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE sucursal_id_seq OWNER TO postgres;

--
-- TOC entry 252 (class 1259 OID 80478)
-- Name: talla_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE talla_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE talla_id_seq OWNER TO postgres;

--
-- TOC entry 253 (class 1259 OID 80480)
-- Name: tipo_ingreso_egreso; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE tipo_ingreso_egreso (
    id bigint DEFAULT nextval(('"tipo_ingreso_egreso_id_seq"'::text)::regclass) NOT NULL,
    descripcion text,
    estado smallint,
    tipo_dato smallint
);


ALTER TABLE tipo_ingreso_egreso OWNER TO postgres;

--
-- TOC entry 254 (class 1259 OID 80487)
-- Name: tipo_ingreso_egreso_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_ingreso_egreso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tipo_ingreso_egreso_id_seq OWNER TO postgres;

--
-- TOC entry 255 (class 1259 OID 80489)
-- Name: tipo_item_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tipo_item_id_seq OWNER TO postgres;

--
-- TOC entry 256 (class 1259 OID 80491)
-- Name: tipo_salida_inventario_sec; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_salida_inventario_sec
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tipo_salida_inventario_sec OWNER TO postgres;

--
-- TOC entry 257 (class 1259 OID 80493)
-- Name: tipo_salida_inventario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE tipo_salida_inventario (
    id bigint DEFAULT nextval('tipo_salida_inventario_sec'::regclass) NOT NULL,
    nombre text,
    descripcion text,
    fecha_registro timestamp without time zone,
    estado smallint
);


ALTER TABLE tipo_salida_inventario OWNER TO postgres;

--
-- TOC entry 258 (class 1259 OID 80500)
-- Name: unidad_medida_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE unidad_medida_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE unidad_medida_id_seq OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 80502)
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE usuario (
    id bigint DEFAULT nextval(('"usuario_id_seq"'::text)::regclass) NOT NULL,
    ci text,
    nombre_usuario text,
    telefono text,
    cargo bigint,
    usuario text,
    clave text,
    activo smallint,
    estado smallint
);


ALTER TABLE usuario OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 80509)
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE usuario_id_seq OWNER TO postgres;

--
-- TOC entry 261 (class 1259 OID 80511)
-- Name: usuario_sucursal; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE usuario_sucursal (
    usuario_id bigint,
    sucursal_id bigint
);


ALTER TABLE usuario_sucursal OWNER TO postgres;

--
-- TOC entry 262 (class 1259 OID 80514)
-- Name: venta_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE venta_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE venta_id_seq OWNER TO postgres;

--
-- TOC entry 263 (class 1259 OID 80516)
-- Name: venta_pago_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE venta_pago_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE venta_pago_id_seq OWNER TO postgres;

--
-- TOC entry 264 (class 1259 OID 80518)
-- Name: ventas_emitidas; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW ventas_emitidas AS
 SELECT v.id,
    v.fecha,
    v.subtotal,
    v.descuento,
    v.total,
    v.cliente_id,
    v.nro_venta,
    v.estado,
    v.sucursal_id,
    v.usuario_id,
    v.tipo_venta,
    v.hora,
    c.nombre_cliente,
    c.ci_nit,
    n.nro_nota
   FROM nota_venta n,
    venta v,
    cliente c
  WHERE ((n.venta_id = v.id) AND (v.cliente_id = c.id));


ALTER TABLE ventas_emitidas OWNER TO postgres;

--
-- TOC entry 2451 (class 0 OID 80196)
-- Dependencies: 185
-- Data for Name: acceso; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO acceso VALUES (1, 1, 1);
INSERT INTO acceso VALUES (2, 2, 1);
INSERT INTO acceso VALUES (3, 3, 1);
INSERT INTO acceso VALUES (4, 4, 1);
INSERT INTO acceso VALUES (5, 5, 1);
INSERT INTO acceso VALUES (6, 6, 1);
INSERT INTO acceso VALUES (7, 7, 1);
INSERT INTO acceso VALUES (8, 8, 1);
INSERT INTO acceso VALUES (9, 9, 1);
INSERT INTO acceso VALUES (10, 10, 1);
INSERT INTO acceso VALUES (11, 11, 1);
INSERT INTO acceso VALUES (12, 12, 1);
INSERT INTO acceso VALUES (13, 13, 1);
INSERT INTO acceso VALUES (14, 14, 1);
INSERT INTO acceso VALUES (15, 15, 1);
INSERT INTO acceso VALUES (16, 16, 1);
INSERT INTO acceso VALUES (17, 17, 1);
INSERT INTO acceso VALUES (18, 18, 1);
INSERT INTO acceso VALUES (19, 19, 1);
INSERT INTO acceso VALUES (20, 20, 1);
INSERT INTO acceso VALUES (21, 21, 1);
INSERT INTO acceso VALUES (22, 22, 1);
INSERT INTO acceso VALUES (23, 23, 1);
INSERT INTO acceso VALUES (24, 24, 1);
INSERT INTO acceso VALUES (25, 25, 1);
INSERT INTO acceso VALUES (26, 26, 1);
INSERT INTO acceso VALUES (63, 27, 1);
INSERT INTO acceso VALUES (98, 28, 1);
INSERT INTO acceso VALUES (156, 1, 7);
INSERT INTO acceso VALUES (157, 7, 7);
INSERT INTO acceso VALUES (158, 2, 7);
INSERT INTO acceso VALUES (159, 8, 7);
INSERT INTO acceso VALUES (160, 1, 8);
INSERT INTO acceso VALUES (161, 7, 8);


--
-- TOC entry 2537 (class 0 OID 0)
-- Dependencies: 186
-- Name: acceso_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('acceso_id_seq', 161, true);


--
-- TOC entry 2453 (class 0 OID 80202)
-- Dependencies: 187
-- Data for Name: almacen; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO almacen VALUES (2, 'Almacen fabrica', 1, 0);


--
-- TOC entry 2538 (class 0 OID 0)
-- Dependencies: 188
-- Name: almacen_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('almacen_id_seq', 3, true);


--
-- TOC entry 2455 (class 0 OID 80211)
-- Dependencies: 189
-- Data for Name: caja; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO caja VALUES (1, 'VENTA TIENDA', 1, NULL);


--
-- TOC entry 2539 (class 0 OID 0)
-- Dependencies: 190
-- Name: caja_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('caja_id_seq', 1, true);


--
-- TOC entry 2457 (class 0 OID 80220)
-- Dependencies: 191
-- Data for Name: cargo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO cargo VALUES (1, 'ADMINISTRADOR');
INSERT INTO cargo VALUES (2, 'VENDEDOR');
INSERT INTO cargo VALUES (3, 'OTRO');


--
-- TOC entry 2540 (class 0 OID 0)
-- Dependencies: 192
-- Name: cargo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cargo_id_seq', 3, true);


--
-- TOC entry 2529 (class 0 OID 80550)
-- Dependencies: 268
-- Data for Name: categoria_interna; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO categoria_interna VALUES (11, 'ALMOHADA');
INSERT INTO categoria_interna VALUES (12, 'RESPALDO SENCILLO');
INSERT INTO categoria_interna VALUES (13, 'RESPALDO CON COSTURA');
INSERT INTO categoria_interna VALUES (14, 'RESPALDO CAPITONNE 70CM');
INSERT INTO categoria_interna VALUES (15, 'RESPALDO CAPITONNE 90CM');
INSERT INTO categoria_interna VALUES (16, 'RESPALDO CAPITONNE CON BASE 90CM');
INSERT INTO categoria_interna VALUES (17, 'RESPALDO ALTO 1,20MTR');


--
-- TOC entry 2541 (class 0 OID 0)
-- Dependencies: 267
-- Name: categoria_interna_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('categoria_interna_id_seq', 21, true);


--
-- TOC entry 2459 (class 0 OID 80229)
-- Dependencies: 193
-- Data for Name: cierre_sesion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO cierre_sesion VALUES (1, '2017-11-27', 84);
INSERT INTO cierre_sesion VALUES (2, '2017-11-27', 2);
INSERT INTO cierre_sesion VALUES (3, '2017-11-27', 3);
INSERT INTO cierre_sesion VALUES (4, '2017-11-27', 86);
INSERT INTO cierre_sesion VALUES (5, '2017-11-27', 5);
INSERT INTO cierre_sesion VALUES (6, '2017-11-27', 6);
INSERT INTO cierre_sesion VALUES (7, '2017-11-27', 8);
INSERT INTO cierre_sesion VALUES (8, '2017-11-27', 9);
INSERT INTO cierre_sesion VALUES (9, '2017-11-27', 88);
INSERT INTO cierre_sesion VALUES (10, '2017-11-27', 12);
INSERT INTO cierre_sesion VALUES (11, '2017-11-27', 11);
INSERT INTO cierre_sesion VALUES (12, '2017-11-28', 10);
INSERT INTO cierre_sesion VALUES (13, '2017-11-29', 15);
INSERT INTO cierre_sesion VALUES (14, '2017-12-01', 14);
INSERT INTO cierre_sesion VALUES (15, '2017-12-06', 17);
INSERT INTO cierre_sesion VALUES (16, '2017-12-06', 18);
INSERT INTO cierre_sesion VALUES (17, '2017-12-06', 18);
INSERT INTO cierre_sesion VALUES (18, '2017-12-06', 20);
INSERT INTO cierre_sesion VALUES (19, '2017-12-06', 21);
INSERT INTO cierre_sesion VALUES (20, '2017-12-06', 94);
INSERT INTO cierre_sesion VALUES (21, '2017-12-06', 23);
INSERT INTO cierre_sesion VALUES (22, '2017-12-07', 24);
INSERT INTO cierre_sesion VALUES (23, '2017-12-07', 25);
INSERT INTO cierre_sesion VALUES (24, '2017-12-07', 26);
INSERT INTO cierre_sesion VALUES (25, '2017-12-07', 27);
INSERT INTO cierre_sesion VALUES (26, '2017-12-07', 28);
INSERT INTO cierre_sesion VALUES (27, '2017-12-08', 29);
INSERT INTO cierre_sesion VALUES (28, '2017-12-08', 30);
INSERT INTO cierre_sesion VALUES (29, '2017-12-08', 99);
INSERT INTO cierre_sesion VALUES (30, '2017-12-09', 32);
INSERT INTO cierre_sesion VALUES (31, '2017-12-13', 7);
INSERT INTO cierre_sesion VALUES (32, '2017-12-14', 33);
INSERT INTO cierre_sesion VALUES (33, '2017-12-14', 34);
INSERT INTO cierre_sesion VALUES (34, '2017-12-14', 13);
INSERT INTO cierre_sesion VALUES (35, '2017-12-18', 36);
INSERT INTO cierre_sesion VALUES (36, '2017-12-18', 37);
INSERT INTO cierre_sesion VALUES (37, '2017-12-18', 38);
INSERT INTO cierre_sesion VALUES (38, '2017-12-18', 39);
INSERT INTO cierre_sesion VALUES (39, '2017-12-18', 40);
INSERT INTO cierre_sesion VALUES (40, '2017-12-19', 41);
INSERT INTO cierre_sesion VALUES (41, '2017-12-21', 42);
INSERT INTO cierre_sesion VALUES (42, '2017-12-21', 35);
INSERT INTO cierre_sesion VALUES (43, '2017-12-21', 43);
INSERT INTO cierre_sesion VALUES (44, '2017-12-21', 45);
INSERT INTO cierre_sesion VALUES (45, '2017-12-21', 44);
INSERT INTO cierre_sesion VALUES (46, '2017-12-22', 46);
INSERT INTO cierre_sesion VALUES (47, '2017-12-22', 47);
INSERT INTO cierre_sesion VALUES (48, '2017-12-22', 16);
INSERT INTO cierre_sesion VALUES (49, '2017-12-22', 48);
INSERT INTO cierre_sesion VALUES (50, '2017-12-22', 51);
INSERT INTO cierre_sesion VALUES (51, '2017-12-22', 49);
INSERT INTO cierre_sesion VALUES (52, '2017-12-23', 52);
INSERT INTO cierre_sesion VALUES (53, '2017-12-26', 53);
INSERT INTO cierre_sesion VALUES (54, '2017-12-26', 54);
INSERT INTO cierre_sesion VALUES (55, '2017-12-26', 55);
INSERT INTO cierre_sesion VALUES (56, '2017-12-26', 56);
INSERT INTO cierre_sesion VALUES (57, '2017-12-26', 57);
INSERT INTO cierre_sesion VALUES (58, '2017-12-26', 50);
INSERT INTO cierre_sesion VALUES (59, '2017-12-26', 58);
INSERT INTO cierre_sesion VALUES (60, '2017-12-27', 61);
INSERT INTO cierre_sesion VALUES (61, '2017-12-27', 62);
INSERT INTO cierre_sesion VALUES (62, '2017-12-27', 60);
INSERT INTO cierre_sesion VALUES (63, '2017-12-27', 64);
INSERT INTO cierre_sesion VALUES (64, '2017-12-27', 65);
INSERT INTO cierre_sesion VALUES (65, '2017-12-27', 66);
INSERT INTO cierre_sesion VALUES (66, '2017-12-27', 67);
INSERT INTO cierre_sesion VALUES (67, '2017-12-27', 63);
INSERT INTO cierre_sesion VALUES (68, '2017-12-27', 68);
INSERT INTO cierre_sesion VALUES (69, '2017-12-27', 69);
INSERT INTO cierre_sesion VALUES (70, '2017-12-27', 70);
INSERT INTO cierre_sesion VALUES (71, '2017-12-27', 70);
INSERT INTO cierre_sesion VALUES (72, '2017-12-27', 73);
INSERT INTO cierre_sesion VALUES (73, '2017-12-27', 72);
INSERT INTO cierre_sesion VALUES (74, '2017-12-27', 59);
INSERT INTO cierre_sesion VALUES (75, '2017-12-27', 74);
INSERT INTO cierre_sesion VALUES (76, '2017-12-28', 76);
INSERT INTO cierre_sesion VALUES (77, '2017-12-28', 78);
INSERT INTO cierre_sesion VALUES (78, '2017-12-28', 79);
INSERT INTO cierre_sesion VALUES (79, '2017-12-28', 80);
INSERT INTO cierre_sesion VALUES (80, '2017-12-28', 81);
INSERT INTO cierre_sesion VALUES (81, '2017-12-29', 82);
INSERT INTO cierre_sesion VALUES (82, '2017-12-29', 82);
INSERT INTO cierre_sesion VALUES (83, '2017-12-29', 75);
INSERT INTO cierre_sesion VALUES (84, '2017-12-29', 83);
INSERT INTO cierre_sesion VALUES (85, '2017-12-29', 84);
INSERT INTO cierre_sesion VALUES (86, '2017-12-29', 85);
INSERT INTO cierre_sesion VALUES (87, '2017-12-29', 87);
INSERT INTO cierre_sesion VALUES (88, '2017-12-29', 88);
INSERT INTO cierre_sesion VALUES (89, '2017-12-29', 89);
INSERT INTO cierre_sesion VALUES (90, '2017-12-29', 90);
INSERT INTO cierre_sesion VALUES (91, '2017-12-29', 91);
INSERT INTO cierre_sesion VALUES (92, '2017-12-29', 92);
INSERT INTO cierre_sesion VALUES (93, '2017-12-29', 77);
INSERT INTO cierre_sesion VALUES (94, '2017-12-29', 94);
INSERT INTO cierre_sesion VALUES (95, '2017-12-30', 93);
INSERT INTO cierre_sesion VALUES (96, '2018-01-02', 95);
INSERT INTO cierre_sesion VALUES (97, '2018-01-03', 96);
INSERT INTO cierre_sesion VALUES (98, '2018-01-03', 98);
INSERT INTO cierre_sesion VALUES (99, '2018-01-03', 99);
INSERT INTO cierre_sesion VALUES (100, '2018-01-05', 86);
INSERT INTO cierre_sesion VALUES (101, '2018-01-05', 86);
INSERT INTO cierre_sesion VALUES (102, '2018-01-05', 101);
INSERT INTO cierre_sesion VALUES (103, '2018-01-05', 102);
INSERT INTO cierre_sesion VALUES (104, '2018-01-05', 104);
INSERT INTO cierre_sesion VALUES (105, '2018-01-05', 105);
INSERT INTO cierre_sesion VALUES (106, '2018-01-05', 106);
INSERT INTO cierre_sesion VALUES (107, '2018-01-07', 97);
INSERT INTO cierre_sesion VALUES (108, '2018-01-08', 108);
INSERT INTO cierre_sesion VALUES (109, '2018-01-08', 109);
INSERT INTO cierre_sesion VALUES (110, '2018-01-08', 100);
INSERT INTO cierre_sesion VALUES (111, '2018-01-10', 111);
INSERT INTO cierre_sesion VALUES (112, '2018-01-11', 112);
INSERT INTO cierre_sesion VALUES (113, '2018-01-16', 113);
INSERT INTO cierre_sesion VALUES (114, '2018-01-17', 114);
INSERT INTO cierre_sesion VALUES (115, '2018-01-18', NULL);
INSERT INTO cierre_sesion VALUES (116, '2018-01-18', 115);
INSERT INTO cierre_sesion VALUES (117, '2018-01-18', 116);
INSERT INTO cierre_sesion VALUES (118, '2018-01-20', 107);
INSERT INTO cierre_sesion VALUES (119, '2018-01-23', 118);
INSERT INTO cierre_sesion VALUES (120, '2018-01-24', 119);
INSERT INTO cierre_sesion VALUES (121, '2018-01-26', 117);
INSERT INTO cierre_sesion VALUES (122, '2018-01-26', 121);
INSERT INTO cierre_sesion VALUES (123, '2018-01-27', 122);
INSERT INTO cierre_sesion VALUES (124, '2018-01-27', 123);
INSERT INTO cierre_sesion VALUES (125, '2018-01-29', 110);
INSERT INTO cierre_sesion VALUES (126, '2018-01-29', 124);
INSERT INTO cierre_sesion VALUES (127, '2018-01-29', 125);
INSERT INTO cierre_sesion VALUES (128, '2018-02-02', 126);
INSERT INTO cierre_sesion VALUES (129, '2018-02-02', 127);
INSERT INTO cierre_sesion VALUES (130, '2018-02-02', 128);
INSERT INTO cierre_sesion VALUES (131, '2018-02-03', 129);
INSERT INTO cierre_sesion VALUES (132, '2018-02-05', 130);
INSERT INTO cierre_sesion VALUES (133, '2018-02-06', 132);
INSERT INTO cierre_sesion VALUES (134, '2018-02-26', 134);
INSERT INTO cierre_sesion VALUES (135, '2018-02-26', 134);
INSERT INTO cierre_sesion VALUES (136, '2018-02-26', 135);
INSERT INTO cierre_sesion VALUES (137, '2018-02-26', NULL);
INSERT INTO cierre_sesion VALUES (138, '2018-02-26', 136);
INSERT INTO cierre_sesion VALUES (139, '2018-02-26', 137);
INSERT INTO cierre_sesion VALUES (140, '2018-02-26', 136);
INSERT INTO cierre_sesion VALUES (141, '2018-02-26', 139);
INSERT INTO cierre_sesion VALUES (142, '2018-02-26', 140);
INSERT INTO cierre_sesion VALUES (143, '2018-02-26', 141);
INSERT INTO cierre_sesion VALUES (144, '2018-02-26', 142);
INSERT INTO cierre_sesion VALUES (145, '2018-02-26', 143);
INSERT INTO cierre_sesion VALUES (146, '2018-02-26', 144);
INSERT INTO cierre_sesion VALUES (147, '2018-02-26', 145);
INSERT INTO cierre_sesion VALUES (148, '2018-02-27', 146);
INSERT INTO cierre_sesion VALUES (149, '2018-02-27', 147);
INSERT INTO cierre_sesion VALUES (150, '2018-02-27', 148);
INSERT INTO cierre_sesion VALUES (151, '2018-02-27', 149);
INSERT INTO cierre_sesion VALUES (152, '2018-02-28', 137);
INSERT INTO cierre_sesion VALUES (153, '2018-02-28', 151);
INSERT INTO cierre_sesion VALUES (154, '2018-02-28', 152);
INSERT INTO cierre_sesion VALUES (155, '2018-02-28', 153);
INSERT INTO cierre_sesion VALUES (156, '2018-02-28', 154);
INSERT INTO cierre_sesion VALUES (157, '2018-03-01', 155);
INSERT INTO cierre_sesion VALUES (158, '2018-03-01', 156);
INSERT INTO cierre_sesion VALUES (159, '2018-03-01', 157);
INSERT INTO cierre_sesion VALUES (160, '2018-03-01', 158);
INSERT INTO cierre_sesion VALUES (161, '2018-03-01', 159);
INSERT INTO cierre_sesion VALUES (162, '2018-03-01', 160);
INSERT INTO cierre_sesion VALUES (163, '2018-03-02', 161);
INSERT INTO cierre_sesion VALUES (164, '2018-03-02', 162);
INSERT INTO cierre_sesion VALUES (165, '2018-03-02', 163);
INSERT INTO cierre_sesion VALUES (166, '2018-03-02', 164);
INSERT INTO cierre_sesion VALUES (167, '2018-03-02', 165);
INSERT INTO cierre_sesion VALUES (168, '2018-03-03', 166);
INSERT INTO cierre_sesion VALUES (169, '2018-03-05', 167);
INSERT INTO cierre_sesion VALUES (170, '2018-03-05', 168);
INSERT INTO cierre_sesion VALUES (171, '2018-03-06', 169);
INSERT INTO cierre_sesion VALUES (172, '2018-03-06', 170);


--
-- TOC entry 2542 (class 0 OID 0)
-- Dependencies: 194
-- Name: cierre_sesion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cierre_sesion_id_seq', 172, true);


--
-- TOC entry 2461 (class 0 OID 80235)
-- Dependencies: 195
-- Data for Name: cliente; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO cliente VALUES (351, '115030253', 'GUSTAVO ORELLANO CAMACHO', '2', '', 1, '', '2018-03-01 00:28:13', '2018-03-01 00:28:13', '', '', '', 1);
INSERT INTO cliente VALUES (350, '115030251', 'RODRIGO MOSCOSO', '1', '', 1, '', '2018-03-01 00:27:51', '2018-03-01 00:27:51', '', '', '', 1);


--
-- TOC entry 2543 (class 0 OID 0)
-- Dependencies: 196
-- Name: cliente_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cliente_id_seq', 354, true);


--
-- TOC entry 2463 (class 0 OID 80244)
-- Dependencies: 197
-- Data for Name: color; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO color VALUES (1, 'DICARP');


--
-- TOC entry 2544 (class 0 OID 0)
-- Dependencies: 198
-- Name: color_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('color_id_seq', 117, true);


--
-- TOC entry 2465 (class 0 OID 80253)
-- Dependencies: 199
-- Data for Name: compra; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2545 (class 0 OID 0)
-- Dependencies: 200
-- Name: compra_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('compra_id_seq', 1, false);


--
-- TOC entry 2467 (class 0 OID 80262)
-- Dependencies: 201
-- Data for Name: detalle_caja; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO detalle_caja VALUES (1, 1, 1, 1, '2017-11-27', 200.00, NULL, NULL, 'APERTURA');
INSERT INTO detalle_caja VALUES (2, 1, 2, 1, '2017-11-30', 1.00, '2017-12-26', 42087.00, 'CERRADO');
INSERT INTO detalle_caja VALUES (3, 1, 2, 6, '2017-12-26', 1.00, '2017-12-26', 3493.00, 'CERRADO');
INSERT INTO detalle_caja VALUES (4, 1, 2, 6, '2017-12-27', 1.00, NULL, NULL, 'APERTURA');
INSERT INTO detalle_caja VALUES (5, 1, 3, 6, '2017-12-28', 1.00, NULL, NULL, 'APERTURA');


--
-- TOC entry 2546 (class 0 OID 0)
-- Dependencies: 202
-- Name: detalle_caja_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('detalle_caja_id_seq', 5, true);


--
-- TOC entry 2469 (class 0 OID 80271)
-- Dependencies: 203
-- Data for Name: detalle_compra; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2547 (class 0 OID 0)
-- Dependencies: 204
-- Name: detalle_compra_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('detalle_compra_id_seq', 1, false);


--
-- TOC entry 2471 (class 0 OID 80277)
-- Dependencies: 205
-- Data for Name: detalle_producto_ingreso; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO detalle_producto_ingreso VALUES (NULL, NULL, 33, 1, 1);
INSERT INTO detalle_producto_ingreso VALUES (NULL, NULL, 33, 1, 1);


--
-- TOC entry 2472 (class 0 OID 80280)
-- Dependencies: 206
-- Data for Name: detalle_proforma; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2548 (class 0 OID 0)
-- Dependencies: 207
-- Name: detalle_proforma_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('detalle_proforma_id_seq', 3, true);


--
-- TOC entry 2475 (class 0 OID 80288)
-- Dependencies: 209
-- Data for Name: detalle_salida_inventario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO detalle_salida_inventario VALUES (1, 2, 33, 1, 1);


--
-- TOC entry 2549 (class 0 OID 0)
-- Dependencies: 208
-- Name: detalle_salida_inventario_sec; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('detalle_salida_inventario_sec', 1, true);


--
-- TOC entry 2476 (class 0 OID 80292)
-- Dependencies: 210
-- Data for Name: detalle_venta; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO detalle_venta VALUES (549, 256, 495, 1, 250.00, 26, 1, 606);
INSERT INTO detalle_venta VALUES (550, 257, 495, 0, 250.00, 26, 1, 606);
INSERT INTO detalle_venta VALUES (551, 257, 495, 0, 250.00, 26, 1, 606);
INSERT INTO detalle_venta VALUES (552, 257, 495, 5, 250.00, 26, 1, 607);
INSERT INTO detalle_venta VALUES (553, 258, 495, 2, 250.00, 26, 1, 608);
INSERT INTO detalle_venta VALUES (554, 258, 495, 3, 250.00, 26, 1, 609);
INSERT INTO detalle_venta VALUES (555, 259, 495, 1, 250.00, 26, 1, 610);
INSERT INTO detalle_venta VALUES (556, 260, 495, 1, 250.00, 26, 1, 611);
INSERT INTO detalle_venta VALUES (557, 261, 499, 1, 90.00, 26, 1, 616);
INSERT INTO detalle_venta VALUES (558, 262, 502, 1, 250.00, 26, 1, 620);


--
-- TOC entry 2550 (class 0 OID 0)
-- Dependencies: 211
-- Name: detalle_venta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('detalle_venta_id_seq', 558, true);


--
-- TOC entry 2478 (class 0 OID 80298)
-- Dependencies: 212
-- Data for Name: egreso_caja; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2551 (class 0 OID 0)
-- Dependencies: 213
-- Name: egreso_caja_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('egreso_caja_id_seq', 1, false);


--
-- TOC entry 2480 (class 0 OID 80307)
-- Dependencies: 214
-- Data for Name: egreso_compra; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2481 (class 0 OID 80310)
-- Dependencies: 215
-- Data for Name: forma_pago; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2552 (class 0 OID 0)
-- Dependencies: 216
-- Name: forma_pago_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('forma_pago_id_seq', 1, false);


--
-- TOC entry 2483 (class 0 OID 80319)
-- Dependencies: 217
-- Data for Name: ingreso_caja; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO ingreso_caja VALUES (3, '2017-12-15', 'Ingreso por venta generado automaticamente', 245.00, 1, 3, 1, 2, '2017-12-15');
INSERT INTO ingreso_caja VALUES (4, '2017-12-15', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-15');
INSERT INTO ingreso_caja VALUES (5, '2017-12-19', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (6, '2017-12-19', 'Ingreso por venta generado automaticamente', 475.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (7, '2017-12-19', 'Ingreso por venta generado automaticamente', 516.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (8, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (9, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (10, '2017-12-19', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (11, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (12, '2017-12-19', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (13, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (14, '2017-12-19', 'Ingreso por venta generado automaticamente', 971.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (15, '2017-12-19', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (16, '2017-12-19', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (17, '2017-12-19', 'Ingreso por venta generado automaticamente', 324.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (18, '2017-12-19', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (19, '2017-12-19', 'Ingreso por venta generado automaticamente', 3000.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (20, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (21, '2017-12-19', 'Ingreso por venta generado automaticamente', 1469.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (22, '2017-12-19', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (23, '2017-12-19', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (24, '2017-12-19', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (25, '2017-12-19', 'Ingreso por venta generado automaticamente', 589.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (26, '2017-12-19', 'Ingreso por venta generado automaticamente', 175.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (27, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (28, '2017-12-19', 'Ingreso por venta generado automaticamente', 864.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (29, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (30, '2017-12-19', 'Ingreso por venta generado automaticamente', 325.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (31, '2017-12-19', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (32, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (33, '2017-12-19', 'Ingreso por venta generado automaticamente', 199.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (34, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (35, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (36, '2017-12-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-19');
INSERT INTO ingreso_caja VALUES (37, '2017-12-20', 'Ingreso por venta generado automaticamente', 950.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (38, '2017-12-20', 'Ingreso por venta generado automaticamente', 1289.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (39, '2017-12-20', 'Ingreso por venta generado automaticamente', 890.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (40, '2017-12-20', 'Ingreso por venta generado automaticamente', 295.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (41, '2017-12-20', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (42, '2017-12-20', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (43, '2017-12-20', 'Ingreso por venta generado automaticamente', 1289.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (44, '2017-12-20', 'Ingreso por venta generado automaticamente', 971.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (45, '2017-12-20', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (46, '2017-12-20', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (47, '2017-12-20', 'Ingreso por venta generado automaticamente', 538.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (48, '2017-12-20', 'Ingreso por venta generado automaticamente', 470.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (49, '2017-12-20', 'Ingreso por venta generado automaticamente', 950.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (50, '2017-12-20', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (51, '2017-12-20', 'Ingreso por venta generado automaticamente', 3136.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (52, '2017-12-20', 'Ingreso por venta generado automaticamente', 1445.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (53, '2017-12-20', 'Ingreso por venta generado automaticamente', 990.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (54, '2017-12-20', 'Ingreso por venta generado automaticamente', 790.00, 1, 3, 2, 6, '2017-12-20');
INSERT INTO ingreso_caja VALUES (55, '2017-12-21', 'Ingreso por venta generado automaticamente', 1304.00, 1, 3, 2, 6, '2017-12-21');
INSERT INTO ingreso_caja VALUES (56, '2017-12-22', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 6, '2017-12-22');
INSERT INTO ingreso_caja VALUES (57, '2017-12-22', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-22');
INSERT INTO ingreso_caja VALUES (58, '2017-12-22', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-22');
INSERT INTO ingreso_caja VALUES (59, '2017-12-22', 'Ingreso por venta generado automaticamente', 544.00, 1, 3, 1, 2, '2017-12-22');
INSERT INTO ingreso_caja VALUES (60, '2017-12-22', 'Ingreso por venta generado automaticamente', 415.00, 1, 3, 1, 2, '2017-12-22');
INSERT INTO ingreso_caja VALUES (61, '2017-12-22', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-22');
INSERT INTO ingreso_caja VALUES (62, '2017-12-22', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-22');
INSERT INTO ingreso_caja VALUES (63, '2017-12-22', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-22');
INSERT INTO ingreso_caja VALUES (65, '2017-12-23', 'Ingreso por venta generado automaticamente', 245.00, 1, 3, 2, 6, '2017-12-23');
INSERT INTO ingreso_caja VALUES (2, '2017-12-06', 'Ingreso por venta generado automaticamente', 1146.00, 2, 3, 2, 4, '2017-12-06');
INSERT INTO ingreso_caja VALUES (64, '2017-12-22', 'Ingreso por venta generado automaticamente', 350.00, 2, 3, 1, 2, '2017-12-22');
INSERT INTO ingreso_caja VALUES (66, '2017-12-23', 'Ingreso por venta generado automaticamente', 796.00, 1, 3, 1, 2, '2017-12-23');
INSERT INTO ingreso_caja VALUES (67, '2017-12-23', 'Ingreso por venta generado automaticamente', 565.00, 1, 3, 1, 2, '2017-12-23');
INSERT INTO ingreso_caja VALUES (68, '2017-12-23', 'Ingreso por venta generado automaticamente', 1910.00, 1, 3, 1, 2, '2017-12-23');
INSERT INTO ingreso_caja VALUES (69, '2017-12-26', 'Ingreso por venta generado automaticamente', 715.00, 1, 3, 2, 6, '2017-12-26');
INSERT INTO ingreso_caja VALUES (70, '2017-12-26', 'Ingreso por venta generado automaticamente', 1269.00, 1, 3, 2, 6, '2017-12-26');
INSERT INTO ingreso_caja VALUES (71, '2017-12-26', 'Ingreso por venta generado automaticamente', 715.00, 1, 3, 2, 6, '2017-12-26');
INSERT INTO ingreso_caja VALUES (72, '2017-12-26', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-26');
INSERT INTO ingreso_caja VALUES (73, '2017-12-26', 'Ingreso por venta generado automaticamente', 475.00, 1, 3, 1, 2, '2017-12-26');
INSERT INTO ingreso_caja VALUES (74, '2017-12-26', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-26');
INSERT INTO ingreso_caja VALUES (75, '2017-12-26', 'Ingreso por venta generado automaticamente', 760.00, 1, 3, 1, 2, '2017-12-26');
INSERT INTO ingreso_caja VALUES (76, '2017-12-26', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-26');
INSERT INTO ingreso_caja VALUES (77, '2017-12-26', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 6, '2017-12-26');
INSERT INTO ingreso_caja VALUES (1, '2017-12-06', 'Ingreso por venta generado automaticamente', 548.00, 2, 3, 2, 4, '2017-12-06');
INSERT INTO ingreso_caja VALUES (78, '2017-12-27', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2017-12-27');
INSERT INTO ingreso_caja VALUES (79, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (80, '2017-12-28', 'Ingreso por venta generado automaticamente', 694.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (81, '2017-12-28', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (82, '2017-12-28', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (83, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (84, '2017-12-28', 'Ingreso por venta generado automaticamente', 1975.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (85, '2017-12-28', 'Ingreso por venta generado automaticamente', 475.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (86, '2017-12-28', 'Ingreso por venta generado automaticamente', 1470.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (87, '2017-12-28', 'Ingreso por venta generado automaticamente', 900.00, 1, 3, 2, 6, '2017-12-28');
INSERT INTO ingreso_caja VALUES (88, '2017-12-28', 'Ingreso por venta generado automaticamente', 0.00, 1, 3, 2, 6, '2017-12-28');
INSERT INTO ingreso_caja VALUES (89, '2017-12-28', 'Ingreso por venta generado automaticamente', 594.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (90, '2017-12-28', 'Ingreso por venta generado automaticamente', 219.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (91, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (92, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (93, '2017-12-28', 'Ingreso por venta generado automaticamente', 350.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (94, '2017-12-28', 'Ingreso por venta generado automaticamente', 245.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (95, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (96, '2017-12-28', 'Ingreso por venta generado automaticamente', 225.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (97, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (98, '2017-12-28', 'Ingreso por venta generado automaticamente', 1000.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (99, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (100, '2017-12-28', 'Ingreso por venta generado automaticamente', 485.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (101, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (102, '2017-12-28', 'Ingreso por venta generado automaticamente', 518.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (103, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (104, '2017-12-28', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (105, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (106, '2017-12-28', 'Ingreso por venta generado automaticamente', 475.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (107, '2017-12-28', 'Ingreso por venta generado automaticamente', 990.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (108, '2017-12-28', 'Ingreso por venta generado automaticamente', 590.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (109, '2017-12-28', 'Ingreso por venta generado automaticamente', 450.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (110, '2017-12-28', 'Ingreso por venta generado automaticamente', 1495.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (111, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (112, '2017-12-28', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (113, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (114, '2017-12-28', 'Ingreso por venta generado automaticamente', 280.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (115, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (117, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (118, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (119, '2017-12-28', 'Ingreso por venta generado automaticamente', 1514.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (120, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (121, '2017-12-28', 'Ingreso por venta generado automaticamente', 1196.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (122, '2017-12-28', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (123, '2017-12-28', 'Ingreso por venta generado automaticamente', 1290.00, 1, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (124, '2017-12-28', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 6, '2017-12-28');
INSERT INTO ingreso_caja VALUES (125, '2017-12-29', 'Ingreso por venta generado automaticamente', 245.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (126, '2017-12-29', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (127, '2017-12-29', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 6, '2017-12-29');
INSERT INTO ingreso_caja VALUES (128, '2017-12-29', 'Ingreso por venta generado automaticamente', 740.00, 2, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (116, '2017-12-28', 'Ingreso por venta generado automaticamente', 269.00, 2, 3, 1, 2, '2017-12-28');
INSERT INTO ingreso_caja VALUES (129, '2017-12-29', 'Ingreso por venta generado automaticamente', 740.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (130, '2017-12-29', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (131, '2017-12-29', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (132, '2017-12-29', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (133, '2017-12-29', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (134, '2017-12-29', 'Ingreso por venta generado automaticamente', 475.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (135, '2017-12-29', 'Ingreso por venta generado automaticamente', 350.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (136, '2017-12-29', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (137, '2017-12-29', 'Ingreso por venta generado automaticamente', 0.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (138, '2017-12-29', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (139, '2017-12-29', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2017-12-29');
INSERT INTO ingreso_caja VALUES (140, '2017-12-30', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 2, 6, '2017-12-30');
INSERT INTO ingreso_caja VALUES (141, '2017-12-30', 'Ingreso por venta generado automaticamente', 1285.00, 1, 3, 2, 6, '2017-12-30');
INSERT INTO ingreso_caja VALUES (142, '2017-12-30', 'Ingreso por venta generado automaticamente', 320.00, 1, 3, 2, 6, '2017-12-30');
INSERT INTO ingreso_caja VALUES (143, '2017-12-30', 'Ingreso por venta generado automaticamente', 1074.00, 1, 3, 2, 6, '2017-12-30');
INSERT INTO ingreso_caja VALUES (144, '2017-12-30', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 1, 2, '2017-12-30');
INSERT INTO ingreso_caja VALUES (145, '2018-01-02', 'Ingreso por venta generado automaticamente', 175.00, 1, 3, 1, 6, '2018-01-02');
INSERT INTO ingreso_caja VALUES (146, '2018-01-03', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 2, 6, '2018-01-03');
INSERT INTO ingreso_caja VALUES (147, '2018-01-03', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2018-01-03');
INSERT INTO ingreso_caja VALUES (148, '2018-01-04', 'Ingreso por venta generado automaticamente', 1940.00, 1, 3, 1, 2, '2018-01-04');
INSERT INTO ingreso_caja VALUES (149, '2018-01-04', 'Ingreso por venta generado automaticamente', 970.00, 1, 3, 1, 2, '2018-01-04');
INSERT INTO ingreso_caja VALUES (150, '2018-01-04', 'Ingreso por venta generado automaticamente', 269.00, 1, 3, 1, 2, '2018-01-04');
INSERT INTO ingreso_caja VALUES (151, '2018-01-04', 'Ingreso por venta generado automaticamente', 1400.00, 1, 3, 1, 6, '2018-01-04');
INSERT INTO ingreso_caja VALUES (152, '2018-01-04', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 6, '2018-01-04');
INSERT INTO ingreso_caja VALUES (153, '2018-01-04', 'Ingreso por venta generado automaticamente', 275.00, 1, 3, 1, 6, '2018-01-04');
INSERT INTO ingreso_caja VALUES (154, '2018-01-05', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (155, '2018-01-05', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 2, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (156, '2018-01-05', 'Ingreso por venta generado automaticamente', 838.00, 1, 3, 2, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (157, '2018-01-05', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (158, '2018-01-05', 'Ingreso por venta generado automaticamente', 878.00, 1, 3, 1, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (159, '2018-01-05', 'Ingreso por venta generado automaticamente', 520.00, 1, 3, 2, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (160, '2018-01-05', 'Ingreso por venta generado automaticamente', 598.00, 2, 3, 2, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (161, '2018-01-05', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (162, '2018-01-05', 'Ingreso por venta generado automaticamente', 850.00, 1, 3, 2, 6, '2018-01-05');
INSERT INTO ingreso_caja VALUES (163, '2018-01-06', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 1, 6, '2018-01-06');
INSERT INTO ingreso_caja VALUES (164, '2018-01-06', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2018-01-06');
INSERT INTO ingreso_caja VALUES (165, '2018-01-06', 'Ingreso por venta generado automaticamente', 600.00, 1, 3, 1, 6, '2018-01-06');
INSERT INTO ingreso_caja VALUES (166, '2018-01-08', 'Ingreso por venta generado automaticamente', 578.00, 1, 3, 1, 2, '2018-01-08');
INSERT INTO ingreso_caja VALUES (167, '2018-01-08', 'Ingreso por venta generado automaticamente', 578.00, 1, 3, 1, 2, '2018-01-08');
INSERT INTO ingreso_caja VALUES (168, '2018-01-08', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-08');
INSERT INTO ingreso_caja VALUES (169, '2018-01-08', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-08');
INSERT INTO ingreso_caja VALUES (170, '2018-01-08', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-08');
INSERT INTO ingreso_caja VALUES (171, '2018-01-09', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2018-01-09');
INSERT INTO ingreso_caja VALUES (172, '2018-01-09', 'Ingreso por venta generado automaticamente', 269.00, 1, 3, 1, 2, '2018-01-09');
INSERT INTO ingreso_caja VALUES (173, '2018-01-10', 'Ingreso por venta generado automaticamente', 1289.00, 1, 3, 1, 2, '2018-01-10');
INSERT INTO ingreso_caja VALUES (174, '2018-01-11', 'Ingreso por venta generado automaticamente', 225.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (175, '2018-01-11', 'Ingreso por venta generado automaticamente', 450.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (176, '2018-01-11', 'Ingreso por venta generado automaticamente', 500.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (177, '2018-01-11', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (178, '2018-01-11', 'Ingreso por venta generado automaticamente', 796.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (179, '2018-01-11', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (180, '2018-01-11', 'Ingreso por venta generado automaticamente', 225.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (181, '2018-01-11', 'Ingreso por venta generado automaticamente', 878.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (182, '2018-01-11', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (183, '2018-01-11', 'Ingreso por venta generado automaticamente', 225.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (184, '2018-01-11', 'Ingreso por venta generado automaticamente', 449.00, 1, 3, 1, 2, '2018-01-11');
INSERT INTO ingreso_caja VALUES (185, '2018-01-13', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-13');
INSERT INTO ingreso_caja VALUES (186, '2018-01-13', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-13');
INSERT INTO ingreso_caja VALUES (187, '2018-01-17', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 1, 2, '2018-01-17');
INSERT INTO ingreso_caja VALUES (188, '2018-01-17', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 1, 2, '2018-01-17');
INSERT INTO ingreso_caja VALUES (189, '2018-01-17', 'Ingreso por venta generado automaticamente', 820.00, 1, 3, 1, 2, '2018-01-17');
INSERT INTO ingreso_caja VALUES (190, '2018-01-17', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 1, 2, '2018-01-17');
INSERT INTO ingreso_caja VALUES (191, '2018-01-17', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 1, 2, '2018-01-17');
INSERT INTO ingreso_caja VALUES (192, '2018-01-17', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 1, 2, '2018-01-17');
INSERT INTO ingreso_caja VALUES (193, '2018-01-17', 'Ingreso por venta generado automaticamente', 1199.00, 1, 3, 1, 2, '2018-01-17');
INSERT INTO ingreso_caja VALUES (194, '2018-01-18', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 1, 2, '2018-01-18');
INSERT INTO ingreso_caja VALUES (195, '2018-01-18', 'Ingreso por venta generado automaticamente', 820.00, 1, 3, 1, 2, '2018-01-18');
INSERT INTO ingreso_caja VALUES (196, '2018-01-18', 'Ingreso por venta generado automaticamente', 219.00, 1, 3, 1, 2, '2018-01-18');
INSERT INTO ingreso_caja VALUES (197, '2018-01-18', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 1, 2, '2018-01-18');
INSERT INTO ingreso_caja VALUES (198, '2018-01-19', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-01-19');
INSERT INTO ingreso_caja VALUES (199, '2018-01-20', 'Ingreso por venta generado automaticamente', 1098.00, 1, 3, 2, 6, '2018-01-20');
INSERT INTO ingreso_caja VALUES (200, '2018-01-23', 'Ingreso por venta generado automaticamente', 518.00, 1, 3, 2, 6, '2018-01-23');
INSERT INTO ingreso_caja VALUES (201, '2018-01-23', 'Ingreso por venta generado automaticamente', 844.00, 1, 3, 2, 6, '2018-01-23');
INSERT INTO ingreso_caja VALUES (202, '2018-01-24', 'Ingreso por venta generado automaticamente', 898.00, 1, 3, 2, 6, '2018-01-24');
INSERT INTO ingreso_caja VALUES (203, '2018-01-24', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 2, 6, '2018-01-24');
INSERT INTO ingreso_caja VALUES (204, '2018-01-25', 'Ingreso por venta generado automaticamente', 570.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (205, '2018-01-25', 'Ingreso por venta generado automaticamente', 799.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (206, '2018-01-25', 'Ingreso por venta generado automaticamente', 598.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (207, '2018-01-25', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (208, '2018-01-25', 'Ingreso por venta generado automaticamente', 761.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (209, '2018-01-25', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (210, '2018-01-25', 'Ingreso por venta generado automaticamente', 2993.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (211, '2018-01-25', 'Ingreso por venta generado automaticamente', 794.00, 1, 3, 2, 6, '2018-01-25');
INSERT INTO ingreso_caja VALUES (212, '2018-01-26', 'Ingreso por venta generado automaticamente', 320.00, 1, 3, 1, 2, '2018-01-26');
INSERT INTO ingreso_caja VALUES (213, '2018-01-26', 'Ingreso por venta generado automaticamente', 320.00, 1, 3, 1, 2, '2018-01-26');
INSERT INTO ingreso_caja VALUES (214, '2018-01-27', 'Ingreso por venta generado automaticamente', 824.00, 1, 3, 1, 2, '2018-01-27');
INSERT INTO ingreso_caja VALUES (215, '2018-01-27', 'Ingreso por venta generado automaticamente', 275.00, 1, 3, 1, 2, '2018-01-27');
INSERT INTO ingreso_caja VALUES (216, '2018-01-27', 'Ingreso por venta generado automaticamente', 255.00, 1, 3, 1, 2, '2018-01-27');
INSERT INTO ingreso_caja VALUES (217, '2018-01-27', 'Ingreso por venta generado automaticamente', 199.00, 1, 3, 1, 2, '2018-01-27');
INSERT INTO ingreso_caja VALUES (218, '2018-01-29', 'Ingreso por venta generado automaticamente', 762.00, 1, 3, 1, 2, '2018-01-29');
INSERT INTO ingreso_caja VALUES (219, '2018-01-29', 'Ingreso por venta generado automaticamente', 353.00, 1, 3, 1, 2, '2018-01-29');
INSERT INTO ingreso_caja VALUES (220, '2018-01-29', 'Ingreso por venta generado automaticamente', 510.00, 1, 3, 1, 2, '2018-01-29');
INSERT INTO ingreso_caja VALUES (221, '2018-01-30', 'Ingreso por venta generado automaticamente', 353.00, 1, 3, 1, 2, '2018-01-30');
INSERT INTO ingreso_caja VALUES (222, '2018-01-30', 'Ingreso por venta generado automaticamente', 255.00, 1, 3, 1, 2, '2018-01-30');
INSERT INTO ingreso_caja VALUES (223, '2018-02-02', 'Ingreso por venta generado automaticamente', 199.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (224, '2018-02-02', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (225, '2018-02-02', 'Ingreso por venta generado automaticamente', 421.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (226, '2018-02-02', 'Ingreso por venta generado automaticamente', 699.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (227, '2018-02-02', 'Ingreso por venta generado automaticamente', 990.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (228, '2018-02-02', 'Ingreso por venta generado automaticamente', 299.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (229, '2018-02-02', 'Ingreso por venta generado automaticamente', 295.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (230, '2018-02-02', 'Ingreso por venta generado automaticamente', 582.00, 1, 3, 1, 2, '2018-02-02');
INSERT INTO ingreso_caja VALUES (231, '2018-02-03', 'Ingreso por venta generado automaticamente', 594.00, 1, 3, 1, 2, '2018-02-03');
INSERT INTO ingreso_caja VALUES (232, '2018-02-06', 'Ingreso por venta generado automaticamente', 634.00, 1, 3, 1, 2, '2018-02-06');
INSERT INTO ingreso_caja VALUES (233, '2018-02-06', 'Ingreso por venta generado automaticamente', 0.00, 1, NULL, 2, 1, '2018-02-06');
INSERT INTO ingreso_caja VALUES (234, '2018-02-06', 'Ingreso por venta generado automaticamente', 0.00, 1, NULL, 2, 1, '2018-02-06');
INSERT INTO ingreso_caja VALUES (235, '2018-02-06', 'Ingreso por venta generado automaticamente', 0.00, 1, NULL, 2, 1, '2018-02-06');
INSERT INTO ingreso_caja VALUES (236, '2018-02-26', 'Ingreso por venta generado automaticamente', 485.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (237, '2018-02-26', 'Ingreso por venta generado automaticamente', 490.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (238, '2018-02-26', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (239, '2018-02-26', 'Ingreso por venta generado automaticamente', 490.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (240, '2018-02-26', 'Ingreso por venta generado automaticamente', 490.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (241, '2018-02-26', 'Ingreso por venta generado automaticamente', 485.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (242, '2018-02-26', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (243, '2018-02-26', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (244, '2018-02-26', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (245, '2018-02-26', 'Ingreso por venta generado automaticamente', 95.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (246, '2018-02-26', 'Ingreso por venta generado automaticamente', 485.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (247, '2018-02-26', 'Ingreso por venta generado automaticamente', 490.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (248, '2018-02-26', 'Ingreso por venta generado automaticamente', 485.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (249, '2018-02-26', 'Ingreso por venta generado automaticamente', 985.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (250, '2018-02-26', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (251, '2018-02-26', 'Ingreso por venta generado automaticamente', 485.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (252, '2018-02-26', 'Ingreso por venta generado automaticamente', 990.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (253, '2018-02-26', 'Ingreso por venta generado automaticamente', 492.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (254, '2018-02-26', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-26');
INSERT INTO ingreso_caja VALUES (255, '2018-02-27', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-27');
INSERT INTO ingreso_caja VALUES (256, '2018-02-28', 'Ingreso por venta generado automaticamente', 495.00, 1, 3, 2, 1, '2018-02-28');
INSERT INTO ingreso_caja VALUES (257, '2018-02-28', 'Ingreso por venta generado automaticamente', 290.00, 1, 3, 2, 1, '2018-02-28');
INSERT INTO ingreso_caja VALUES (259, '2018-03-02', 'Ingreso por venta generado automaticamente', 1050.00, 1, 3, 2, 1, '2018-03-02');
INSERT INTO ingreso_caja VALUES (260, '2018-03-02', 'Ingreso por venta generado automaticamente', 1250.00, 1, 3, 2, 1, '2018-03-02');
INSERT INTO ingreso_caja VALUES (261, '2018-03-02', 'Ingreso por venta generado automaticamente', 250.00, 1, 3, 2, 1, '2018-03-02');
INSERT INTO ingreso_caja VALUES (262, '2018-03-05', 'Ingreso por pago de deuda', 100.00, 1, 5, 2, 1, '2018-03-05');
INSERT INTO ingreso_caja VALUES (263, '2018-03-05', 'Ingreso por pago de deuda', 100.00, 1, 5, 2, 1, '2018-03-05');
INSERT INTO ingreso_caja VALUES (258, '2018-03-01', 'Ingreso por venta generado automaticamente', 250.00, 2, 3, 2, 1, '2018-03-01');
INSERT INTO ingreso_caja VALUES (264, '2018-03-06', 'Ingreso por venta generado automaticamente', 90.00, 1, 3, 2, 1, '2018-03-06');
INSERT INTO ingreso_caja VALUES (265, '2018-03-06', 'Ingreso por venta generado automaticamente', 245.00, 1, 3, 2, 1, '2018-03-06');


--
-- TOC entry 2553 (class 0 OID 0)
-- Dependencies: 218
-- Name: ingreso_caja_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('ingreso_caja_id_seq', 265, true);


--
-- TOC entry 2485 (class 0 OID 80328)
-- Dependencies: 219
-- Data for Name: ingreso_inventario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO ingreso_inventario VALUES (146, '2018-03-06', '', 1, 'Ingreso de producto', 2, 1, '2018-03-06', 2);
INSERT INTO ingreso_inventario VALUES (147, '2018-03-06', '', 1, 'Ingreso de producto', 2, 1, '2018-03-06', 2);


--
-- TOC entry 2554 (class 0 OID 0)
-- Dependencies: 220
-- Name: ingreso_inventario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('ingreso_inventario_id_seq', 147, true);


--
-- TOC entry 2487 (class 0 OID 80337)
-- Dependencies: 221
-- Data for Name: ingreso_venta; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO ingreso_venta VALUES (1, 1);
INSERT INTO ingreso_venta VALUES (2, 2);
INSERT INTO ingreso_venta VALUES (3, 3);
INSERT INTO ingreso_venta VALUES (4, 4);
INSERT INTO ingreso_venta VALUES (5, 5);
INSERT INTO ingreso_venta VALUES (6, 6);
INSERT INTO ingreso_venta VALUES (7, 7);
INSERT INTO ingreso_venta VALUES (8, 8);
INSERT INTO ingreso_venta VALUES (9, 9);
INSERT INTO ingreso_venta VALUES (10, 10);
INSERT INTO ingreso_venta VALUES (11, 11);
INSERT INTO ingreso_venta VALUES (12, 12);
INSERT INTO ingreso_venta VALUES (13, 13);
INSERT INTO ingreso_venta VALUES (14, 14);
INSERT INTO ingreso_venta VALUES (15, 15);
INSERT INTO ingreso_venta VALUES (16, 16);
INSERT INTO ingreso_venta VALUES (17, 17);
INSERT INTO ingreso_venta VALUES (18, 18);
INSERT INTO ingreso_venta VALUES (19, 19);
INSERT INTO ingreso_venta VALUES (20, 20);
INSERT INTO ingreso_venta VALUES (21, 21);
INSERT INTO ingreso_venta VALUES (22, 22);
INSERT INTO ingreso_venta VALUES (23, 23);
INSERT INTO ingreso_venta VALUES (24, 24);
INSERT INTO ingreso_venta VALUES (25, 25);
INSERT INTO ingreso_venta VALUES (26, 26);
INSERT INTO ingreso_venta VALUES (27, 27);
INSERT INTO ingreso_venta VALUES (28, 28);
INSERT INTO ingreso_venta VALUES (29, 29);
INSERT INTO ingreso_venta VALUES (30, 30);
INSERT INTO ingreso_venta VALUES (31, 31);
INSERT INTO ingreso_venta VALUES (32, 32);
INSERT INTO ingreso_venta VALUES (33, 33);
INSERT INTO ingreso_venta VALUES (34, 34);
INSERT INTO ingreso_venta VALUES (35, 35);
INSERT INTO ingreso_venta VALUES (36, 36);
INSERT INTO ingreso_venta VALUES (37, 37);
INSERT INTO ingreso_venta VALUES (38, 38);
INSERT INTO ingreso_venta VALUES (39, 39);
INSERT INTO ingreso_venta VALUES (40, 40);
INSERT INTO ingreso_venta VALUES (41, 41);
INSERT INTO ingreso_venta VALUES (42, 42);
INSERT INTO ingreso_venta VALUES (43, 43);
INSERT INTO ingreso_venta VALUES (44, 44);
INSERT INTO ingreso_venta VALUES (45, 45);
INSERT INTO ingreso_venta VALUES (46, 46);
INSERT INTO ingreso_venta VALUES (47, 47);
INSERT INTO ingreso_venta VALUES (48, 48);
INSERT INTO ingreso_venta VALUES (49, 49);
INSERT INTO ingreso_venta VALUES (50, 50);
INSERT INTO ingreso_venta VALUES (51, 51);
INSERT INTO ingreso_venta VALUES (52, 52);
INSERT INTO ingreso_venta VALUES (53, 53);
INSERT INTO ingreso_venta VALUES (54, 54);
INSERT INTO ingreso_venta VALUES (55, 55);
INSERT INTO ingreso_venta VALUES (56, 56);
INSERT INTO ingreso_venta VALUES (57, 57);
INSERT INTO ingreso_venta VALUES (58, 58);
INSERT INTO ingreso_venta VALUES (59, 59);
INSERT INTO ingreso_venta VALUES (60, 60);
INSERT INTO ingreso_venta VALUES (61, 61);
INSERT INTO ingreso_venta VALUES (62, 62);
INSERT INTO ingreso_venta VALUES (63, 63);
INSERT INTO ingreso_venta VALUES (64, 64);
INSERT INTO ingreso_venta VALUES (65, 65);
INSERT INTO ingreso_venta VALUES (66, 66);
INSERT INTO ingreso_venta VALUES (67, 67);
INSERT INTO ingreso_venta VALUES (68, 68);
INSERT INTO ingreso_venta VALUES (69, 69);
INSERT INTO ingreso_venta VALUES (70, 70);
INSERT INTO ingreso_venta VALUES (71, 71);
INSERT INTO ingreso_venta VALUES (72, 72);
INSERT INTO ingreso_venta VALUES (73, 73);
INSERT INTO ingreso_venta VALUES (74, 74);
INSERT INTO ingreso_venta VALUES (75, 75);
INSERT INTO ingreso_venta VALUES (76, 76);
INSERT INTO ingreso_venta VALUES (77, 77);
INSERT INTO ingreso_venta VALUES (78, 78);
INSERT INTO ingreso_venta VALUES (79, 79);
INSERT INTO ingreso_venta VALUES (80, 80);
INSERT INTO ingreso_venta VALUES (81, 81);
INSERT INTO ingreso_venta VALUES (82, 82);
INSERT INTO ingreso_venta VALUES (83, 83);
INSERT INTO ingreso_venta VALUES (84, 84);
INSERT INTO ingreso_venta VALUES (85, 85);
INSERT INTO ingreso_venta VALUES (86, 86);
INSERT INTO ingreso_venta VALUES (87, 87);
INSERT INTO ingreso_venta VALUES (88, 88);
INSERT INTO ingreso_venta VALUES (89, 89);
INSERT INTO ingreso_venta VALUES (90, 90);
INSERT INTO ingreso_venta VALUES (91, 91);
INSERT INTO ingreso_venta VALUES (92, 92);
INSERT INTO ingreso_venta VALUES (93, 93);
INSERT INTO ingreso_venta VALUES (94, 94);
INSERT INTO ingreso_venta VALUES (95, 95);
INSERT INTO ingreso_venta VALUES (96, 96);
INSERT INTO ingreso_venta VALUES (97, 97);
INSERT INTO ingreso_venta VALUES (98, 98);
INSERT INTO ingreso_venta VALUES (99, 99);
INSERT INTO ingreso_venta VALUES (100, 100);
INSERT INTO ingreso_venta VALUES (101, 101);
INSERT INTO ingreso_venta VALUES (102, 102);
INSERT INTO ingreso_venta VALUES (103, 103);
INSERT INTO ingreso_venta VALUES (104, 104);
INSERT INTO ingreso_venta VALUES (105, 105);
INSERT INTO ingreso_venta VALUES (106, 106);
INSERT INTO ingreso_venta VALUES (107, 107);
INSERT INTO ingreso_venta VALUES (108, 108);
INSERT INTO ingreso_venta VALUES (109, 109);
INSERT INTO ingreso_venta VALUES (110, 110);
INSERT INTO ingreso_venta VALUES (111, 111);
INSERT INTO ingreso_venta VALUES (112, 112);
INSERT INTO ingreso_venta VALUES (113, 113);
INSERT INTO ingreso_venta VALUES (114, 114);
INSERT INTO ingreso_venta VALUES (115, 115);
INSERT INTO ingreso_venta VALUES (116, 116);
INSERT INTO ingreso_venta VALUES (117, 117);
INSERT INTO ingreso_venta VALUES (118, 118);
INSERT INTO ingreso_venta VALUES (119, 119);
INSERT INTO ingreso_venta VALUES (120, 120);
INSERT INTO ingreso_venta VALUES (121, 121);
INSERT INTO ingreso_venta VALUES (122, 122);
INSERT INTO ingreso_venta VALUES (123, 123);
INSERT INTO ingreso_venta VALUES (124, 124);
INSERT INTO ingreso_venta VALUES (125, 125);
INSERT INTO ingreso_venta VALUES (126, 126);
INSERT INTO ingreso_venta VALUES (127, 127);
INSERT INTO ingreso_venta VALUES (128, 128);
INSERT INTO ingreso_venta VALUES (129, 129);
INSERT INTO ingreso_venta VALUES (130, 130);
INSERT INTO ingreso_venta VALUES (131, 131);
INSERT INTO ingreso_venta VALUES (132, 132);
INSERT INTO ingreso_venta VALUES (133, 133);
INSERT INTO ingreso_venta VALUES (134, 134);
INSERT INTO ingreso_venta VALUES (135, 135);
INSERT INTO ingreso_venta VALUES (136, 136);
INSERT INTO ingreso_venta VALUES (137, 137);
INSERT INTO ingreso_venta VALUES (138, 138);
INSERT INTO ingreso_venta VALUES (139, 139);
INSERT INTO ingreso_venta VALUES (140, 140);
INSERT INTO ingreso_venta VALUES (141, 141);
INSERT INTO ingreso_venta VALUES (142, 142);
INSERT INTO ingreso_venta VALUES (143, 143);
INSERT INTO ingreso_venta VALUES (144, 144);
INSERT INTO ingreso_venta VALUES (145, 145);
INSERT INTO ingreso_venta VALUES (146, 146);
INSERT INTO ingreso_venta VALUES (147, 147);
INSERT INTO ingreso_venta VALUES (148, 148);
INSERT INTO ingreso_venta VALUES (149, 149);
INSERT INTO ingreso_venta VALUES (150, 150);
INSERT INTO ingreso_venta VALUES (151, 151);
INSERT INTO ingreso_venta VALUES (152, 152);
INSERT INTO ingreso_venta VALUES (153, 153);
INSERT INTO ingreso_venta VALUES (154, 154);
INSERT INTO ingreso_venta VALUES (155, 155);
INSERT INTO ingreso_venta VALUES (156, 156);
INSERT INTO ingreso_venta VALUES (157, 157);
INSERT INTO ingreso_venta VALUES (158, 158);
INSERT INTO ingreso_venta VALUES (159, 159);
INSERT INTO ingreso_venta VALUES (160, 160);
INSERT INTO ingreso_venta VALUES (161, 161);
INSERT INTO ingreso_venta VALUES (162, 162);
INSERT INTO ingreso_venta VALUES (163, 163);
INSERT INTO ingreso_venta VALUES (164, 164);
INSERT INTO ingreso_venta VALUES (165, 165);
INSERT INTO ingreso_venta VALUES (166, 166);
INSERT INTO ingreso_venta VALUES (167, 167);
INSERT INTO ingreso_venta VALUES (168, 168);
INSERT INTO ingreso_venta VALUES (169, 169);
INSERT INTO ingreso_venta VALUES (170, 170);
INSERT INTO ingreso_venta VALUES (171, 171);
INSERT INTO ingreso_venta VALUES (172, 172);
INSERT INTO ingreso_venta VALUES (173, 173);
INSERT INTO ingreso_venta VALUES (174, 174);
INSERT INTO ingreso_venta VALUES (175, 175);
INSERT INTO ingreso_venta VALUES (176, 176);
INSERT INTO ingreso_venta VALUES (177, 177);
INSERT INTO ingreso_venta VALUES (178, 178);
INSERT INTO ingreso_venta VALUES (179, 179);
INSERT INTO ingreso_venta VALUES (180, 180);
INSERT INTO ingreso_venta VALUES (181, 181);
INSERT INTO ingreso_venta VALUES (182, 182);
INSERT INTO ingreso_venta VALUES (183, 183);
INSERT INTO ingreso_venta VALUES (184, 184);
INSERT INTO ingreso_venta VALUES (185, 185);
INSERT INTO ingreso_venta VALUES (186, 186);
INSERT INTO ingreso_venta VALUES (187, 187);
INSERT INTO ingreso_venta VALUES (188, 188);
INSERT INTO ingreso_venta VALUES (189, 189);
INSERT INTO ingreso_venta VALUES (190, 190);
INSERT INTO ingreso_venta VALUES (191, 191);
INSERT INTO ingreso_venta VALUES (192, 192);
INSERT INTO ingreso_venta VALUES (193, 193);
INSERT INTO ingreso_venta VALUES (194, 194);
INSERT INTO ingreso_venta VALUES (195, 195);
INSERT INTO ingreso_venta VALUES (196, 196);
INSERT INTO ingreso_venta VALUES (197, 197);
INSERT INTO ingreso_venta VALUES (198, 198);
INSERT INTO ingreso_venta VALUES (199, 199);
INSERT INTO ingreso_venta VALUES (200, 200);
INSERT INTO ingreso_venta VALUES (201, 201);
INSERT INTO ingreso_venta VALUES (202, 202);
INSERT INTO ingreso_venta VALUES (203, 203);
INSERT INTO ingreso_venta VALUES (204, 204);
INSERT INTO ingreso_venta VALUES (205, 205);
INSERT INTO ingreso_venta VALUES (206, 206);
INSERT INTO ingreso_venta VALUES (207, 207);
INSERT INTO ingreso_venta VALUES (208, 208);
INSERT INTO ingreso_venta VALUES (209, 209);
INSERT INTO ingreso_venta VALUES (210, 210);
INSERT INTO ingreso_venta VALUES (211, 211);
INSERT INTO ingreso_venta VALUES (212, 212);
INSERT INTO ingreso_venta VALUES (213, 213);
INSERT INTO ingreso_venta VALUES (214, 214);
INSERT INTO ingreso_venta VALUES (215, 215);
INSERT INTO ingreso_venta VALUES (216, 216);
INSERT INTO ingreso_venta VALUES (217, 217);
INSERT INTO ingreso_venta VALUES (218, 218);
INSERT INTO ingreso_venta VALUES (219, 219);
INSERT INTO ingreso_venta VALUES (220, 220);
INSERT INTO ingreso_venta VALUES (221, 221);
INSERT INTO ingreso_venta VALUES (222, 222);
INSERT INTO ingreso_venta VALUES (223, 223);
INSERT INTO ingreso_venta VALUES (224, 224);
INSERT INTO ingreso_venta VALUES (225, 225);
INSERT INTO ingreso_venta VALUES (226, 226);
INSERT INTO ingreso_venta VALUES (227, 227);
INSERT INTO ingreso_venta VALUES (228, 228);
INSERT INTO ingreso_venta VALUES (229, 229);
INSERT INTO ingreso_venta VALUES (230, 230);
INSERT INTO ingreso_venta VALUES (231, 231);
INSERT INTO ingreso_venta VALUES (232, 232);
INSERT INTO ingreso_venta VALUES (1, 233);
INSERT INTO ingreso_venta VALUES (128, 234);
INSERT INTO ingreso_venta VALUES (129, 235);
INSERT INTO ingreso_venta VALUES (233, 236);
INSERT INTO ingreso_venta VALUES (234, 237);
INSERT INTO ingreso_venta VALUES (235, 238);
INSERT INTO ingreso_venta VALUES (236, 239);
INSERT INTO ingreso_venta VALUES (237, 240);
INSERT INTO ingreso_venta VALUES (238, 241);
INSERT INTO ingreso_venta VALUES (239, 242);
INSERT INTO ingreso_venta VALUES (240, 243);
INSERT INTO ingreso_venta VALUES (241, 244);
INSERT INTO ingreso_venta VALUES (242, 245);
INSERT INTO ingreso_venta VALUES (243, 246);
INSERT INTO ingreso_venta VALUES (244, 247);
INSERT INTO ingreso_venta VALUES (245, 248);
INSERT INTO ingreso_venta VALUES (246, 249);
INSERT INTO ingreso_venta VALUES (247, 250);
INSERT INTO ingreso_venta VALUES (248, 251);
INSERT INTO ingreso_venta VALUES (249, 252);
INSERT INTO ingreso_venta VALUES (250, 253);
INSERT INTO ingreso_venta VALUES (251, 254);
INSERT INTO ingreso_venta VALUES (253, 255);
INSERT INTO ingreso_venta VALUES (254, 256);
INSERT INTO ingreso_venta VALUES (255, 257);
INSERT INTO ingreso_venta VALUES (256, 258);
INSERT INTO ingreso_venta VALUES (257, 259);
INSERT INTO ingreso_venta VALUES (258, 260);
INSERT INTO ingreso_venta VALUES (259, 261);
INSERT INTO ingreso_venta VALUES (261, 264);
INSERT INTO ingreso_venta VALUES (262, 265);


--
-- TOC entry 2488 (class 0 OID 80340)
-- Dependencies: 222
-- Data for Name: inicio_sesion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO inicio_sesion VALUES (1, '2017-11-24', 1, NULL);
INSERT INTO inicio_sesion VALUES (2, '2017-11-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (3, '2017-11-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (4, '2017-11-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (5, '2017-11-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (6, '2017-11-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (7, '2017-11-27', 4, NULL);
INSERT INTO inicio_sesion VALUES (8, '2017-11-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (9, '2017-11-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (10, '2017-11-27', 6, NULL);
INSERT INTO inicio_sesion VALUES (11, '2017-11-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (12, '2017-11-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (13, '2017-11-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (14, '2017-11-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (15, '2017-11-28', 6, NULL);
INSERT INTO inicio_sesion VALUES (16, '2017-11-29', 6, NULL);
INSERT INTO inicio_sesion VALUES (17, '2017-12-04', 1, NULL);
INSERT INTO inicio_sesion VALUES (18, '2017-12-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (19, '2017-12-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (20, '2017-12-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (21, '2017-12-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (22, '2017-12-06', 3, NULL);
INSERT INTO inicio_sesion VALUES (23, '2017-12-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (24, '2017-12-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (25, '2017-12-07', 1, NULL);
INSERT INTO inicio_sesion VALUES (26, '2017-12-07', 1, NULL);
INSERT INTO inicio_sesion VALUES (27, '2017-12-07', 1, NULL);
INSERT INTO inicio_sesion VALUES (28, '2017-12-07', 1, NULL);
INSERT INTO inicio_sesion VALUES (29, '2017-12-07', 1, NULL);
INSERT INTO inicio_sesion VALUES (30, '2017-12-08', 1, NULL);
INSERT INTO inicio_sesion VALUES (31, '2017-12-08', 1, NULL);
INSERT INTO inicio_sesion VALUES (32, '2017-12-08', 1, NULL);
INSERT INTO inicio_sesion VALUES (33, '2017-12-11', 1, NULL);
INSERT INTO inicio_sesion VALUES (34, '2017-12-14', 1, NULL);
INSERT INTO inicio_sesion VALUES (35, '2017-12-14', 1, NULL);
INSERT INTO inicio_sesion VALUES (36, '2017-12-15', 2, NULL);
INSERT INTO inicio_sesion VALUES (37, '2017-12-18', 2, NULL);
INSERT INTO inicio_sesion VALUES (38, '2017-12-18', 2, NULL);
INSERT INTO inicio_sesion VALUES (39, '2017-12-18', 2, NULL);
INSERT INTO inicio_sesion VALUES (40, '2017-12-18', 2, NULL);
INSERT INTO inicio_sesion VALUES (41, '2017-12-19', 2, NULL);
INSERT INTO inicio_sesion VALUES (42, '2017-12-20', 2, NULL);
INSERT INTO inicio_sesion VALUES (43, '2017-12-21', 2, NULL);
INSERT INTO inicio_sesion VALUES (44, '2017-12-21', 1, NULL);
INSERT INTO inicio_sesion VALUES (45, '2017-12-21', 2, NULL);
INSERT INTO inicio_sesion VALUES (46, '2017-12-21', 2, NULL);
INSERT INTO inicio_sesion VALUES (47, '2017-12-22', 1, NULL);
INSERT INTO inicio_sesion VALUES (48, '2017-12-22', 1, NULL);
INSERT INTO inicio_sesion VALUES (49, '2017-12-22', 2, NULL);
INSERT INTO inicio_sesion VALUES (50, '2017-12-22', 6, NULL);
INSERT INTO inicio_sesion VALUES (51, '2017-12-22', 1, NULL);
INSERT INTO inicio_sesion VALUES (52, '2017-12-23', 2, NULL);
INSERT INTO inicio_sesion VALUES (53, '2017-12-26', 2, NULL);
INSERT INTO inicio_sesion VALUES (54, '2017-12-26', 2, NULL);
INSERT INTO inicio_sesion VALUES (55, '2017-12-26', 2, NULL);
INSERT INTO inicio_sesion VALUES (56, '2017-12-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (57, '2017-12-26', 2, NULL);
INSERT INTO inicio_sesion VALUES (58, '2017-12-26', 2, NULL);
INSERT INTO inicio_sesion VALUES (59, '2017-12-26', 6, NULL);
INSERT INTO inicio_sesion VALUES (60, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (61, '2017-12-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (62, '2017-12-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (63, '2017-12-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (64, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (65, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (66, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (67, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (68, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (69, '2017-12-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (70, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (71, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (72, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (73, '2017-12-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (74, '2017-12-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (75, '2017-12-27', 6, NULL);
INSERT INTO inicio_sesion VALUES (76, '2017-12-28', 2, NULL);
INSERT INTO inicio_sesion VALUES (77, '2017-12-28', 1, NULL);
INSERT INTO inicio_sesion VALUES (78, '2017-12-28', 2, NULL);
INSERT INTO inicio_sesion VALUES (79, '2017-12-28', 2, NULL);
INSERT INTO inicio_sesion VALUES (80, '2017-12-28', 2, NULL);
INSERT INTO inicio_sesion VALUES (81, '2017-12-28', 2, NULL);
INSERT INTO inicio_sesion VALUES (82, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (83, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (84, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (85, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (86, '2017-12-29', 6, NULL);
INSERT INTO inicio_sesion VALUES (87, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (88, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (89, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (90, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (91, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (92, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (93, '2017-12-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (94, '2017-12-29', 1, NULL);
INSERT INTO inicio_sesion VALUES (95, '2017-12-29', 1, NULL);
INSERT INTO inicio_sesion VALUES (96, '2018-01-03', 2, NULL);
INSERT INTO inicio_sesion VALUES (97, '2018-01-03', 1, NULL);
INSERT INTO inicio_sesion VALUES (98, '2018-01-03', 2, NULL);
INSERT INTO inicio_sesion VALUES (99, '2018-01-03', 2, NULL);
INSERT INTO inicio_sesion VALUES (100, '2018-01-04', 2, NULL);
INSERT INTO inicio_sesion VALUES (101, '2018-01-05', 6, NULL);
INSERT INTO inicio_sesion VALUES (102, '2018-01-05', 6, NULL);
INSERT INTO inicio_sesion VALUES (103, '2018-01-05', 6, NULL);
INSERT INTO inicio_sesion VALUES (104, '2018-01-05', 6, NULL);
INSERT INTO inicio_sesion VALUES (105, '2018-01-05', 6, NULL);
INSERT INTO inicio_sesion VALUES (106, '2018-01-05', 6, NULL);
INSERT INTO inicio_sesion VALUES (107, '2018-01-06', 6, NULL);
INSERT INTO inicio_sesion VALUES (108, '2018-01-08', 1, NULL);
INSERT INTO inicio_sesion VALUES (109, '2018-01-08', 1, NULL);
INSERT INTO inicio_sesion VALUES (110, '2018-01-08', 1, NULL);
INSERT INTO inicio_sesion VALUES (111, '2018-01-09', 2, NULL);
INSERT INTO inicio_sesion VALUES (112, '2018-01-11', 2, NULL);
INSERT INTO inicio_sesion VALUES (113, '2018-01-13', 2, NULL);
INSERT INTO inicio_sesion VALUES (114, '2018-01-17', 2, NULL);
INSERT INTO inicio_sesion VALUES (115, '2018-01-17', 2, NULL);
INSERT INTO inicio_sesion VALUES (116, '2018-01-18', 2, NULL);
INSERT INTO inicio_sesion VALUES (117, '2018-01-19', 2, NULL);
INSERT INTO inicio_sesion VALUES (118, '2018-01-23', 6, NULL);
INSERT INTO inicio_sesion VALUES (119, '2018-01-23', 6, NULL);
INSERT INTO inicio_sesion VALUES (120, '2018-01-24', 6, NULL);
INSERT INTO inicio_sesion VALUES (121, '2018-01-26', 2, NULL);
INSERT INTO inicio_sesion VALUES (122, '2018-01-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (123, '2018-01-27', 2, NULL);
INSERT INTO inicio_sesion VALUES (124, '2018-01-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (125, '2018-01-29', 2, NULL);
INSERT INTO inicio_sesion VALUES (126, '2018-01-30', 2, NULL);
INSERT INTO inicio_sesion VALUES (127, '2018-02-02', 2, NULL);
INSERT INTO inicio_sesion VALUES (128, '2018-02-02', 2, NULL);
INSERT INTO inicio_sesion VALUES (129, '2018-02-03', 2, NULL);
INSERT INTO inicio_sesion VALUES (130, '2018-02-05', 2, NULL);
INSERT INTO inicio_sesion VALUES (131, '2018-02-05', 2, NULL);
INSERT INTO inicio_sesion VALUES (132, '2018-02-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (133, '2018-02-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (134, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (135, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (136, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (137, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (138, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (139, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (140, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (141, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (142, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (143, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (144, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (145, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (146, '2018-02-26', 1, NULL);
INSERT INTO inicio_sesion VALUES (147, '2018-02-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (148, '2018-02-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (149, '2018-02-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (150, '2018-02-27', 1, NULL);
INSERT INTO inicio_sesion VALUES (151, '2018-02-28', 1, NULL);
INSERT INTO inicio_sesion VALUES (152, '2018-02-28', 1, NULL);
INSERT INTO inicio_sesion VALUES (153, '2018-02-28', 1, NULL);
INSERT INTO inicio_sesion VALUES (154, '2018-02-28', 1, NULL);
INSERT INTO inicio_sesion VALUES (155, '2018-03-01', 1, NULL);
INSERT INTO inicio_sesion VALUES (156, '2018-03-01', 7, NULL);
INSERT INTO inicio_sesion VALUES (157, '2018-03-01', 1, NULL);
INSERT INTO inicio_sesion VALUES (158, '2018-03-01', 1, NULL);
INSERT INTO inicio_sesion VALUES (159, '2018-03-01', 1, NULL);
INSERT INTO inicio_sesion VALUES (160, '2018-03-01', 1, NULL);
INSERT INTO inicio_sesion VALUES (161, '2018-03-02', 1, NULL);
INSERT INTO inicio_sesion VALUES (162, '2018-03-02', 7, NULL);
INSERT INTO inicio_sesion VALUES (163, '2018-03-02', 7, NULL);
INSERT INTO inicio_sesion VALUES (164, '2018-03-02', 1, NULL);
INSERT INTO inicio_sesion VALUES (165, '2018-03-02', 1, NULL);
INSERT INTO inicio_sesion VALUES (166, '2018-03-03', 1, NULL);
INSERT INTO inicio_sesion VALUES (167, '2018-03-05', 1, NULL);
INSERT INTO inicio_sesion VALUES (168, '2018-03-05', 1, NULL);
INSERT INTO inicio_sesion VALUES (169, '2018-03-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (170, '2018-03-06', 1, NULL);
INSERT INTO inicio_sesion VALUES (171, '2018-03-06', 1, NULL);


--
-- TOC entry 2555 (class 0 OID 0)
-- Dependencies: 223
-- Name: inicio_sesion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('inicio_sesion_id_seq', 171, true);


--
-- TOC entry 2496 (class 0 OID 80390)
-- Dependencies: 231
-- Data for Name: inventario_compra; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2526 (class 0 OID 80539)
-- Dependencies: 265
-- Data for Name: marca; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO marca VALUES (6, 'DICARP');
INSERT INTO marca VALUES (7, 'DUOFLEX');


--
-- TOC entry 2556 (class 0 OID 0)
-- Dependencies: 266
-- Name: marca_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('marca_id_seq', 8, true);


--
-- TOC entry 2497 (class 0 OID 80398)
-- Dependencies: 233
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO menu VALUES (1, NULL, 'REGISTROS', 'fa fa-address-book', 'Item-1', 1);
INSERT INTO menu VALUES (7, 1, 'Nuevo cliente', 'fa fa-circle-o', 'cliente', 1);
INSERT INTO menu VALUES (11, 4, 'Nuevo producto', 'fa fa-circle-o', 'producto', 1);
INSERT INTO menu VALUES (16, 5, 'Usuario', 'fa fa-circle-o', 'usuario', 2);
INSERT INTO menu VALUES (5, NULL, 'CONFIGURACION', 'fa fa-building-o', 'Item-1', 6);
INSERT INTO menu VALUES (6, NULL, 'REPORTES', 'fa fa-area-chart', 'Item-1', 7);
INSERT INTO menu VALUES (4, NULL, 'INVENTARIO', 'fa fa-line-chart', 'Item-1', 5);
INSERT INTO menu VALUES (28, 6, 'Rep. clientes', 'fa fa-circle-o', 'reporte/reporte_clientes', 1);
INSERT INTO menu VALUES (2, NULL, 'VENTAS', 'fa fa-list', 'Item-1', 2);
INSERT INTO menu VALUES (8, 2, 'Nueva venta', 'fa fa-circle-o', 'venta', 1);
INSERT INTO menu VALUES (17, 6, 'Rep. Ventas', 'fa fa-circle-o', 'reporte/reporte_venta', 1);
INSERT INTO menu VALUES (12, 4, 'Gestionar Ingreso', 'fa fa-circle-o', 'inventario', 2);
INSERT INTO menu VALUES (26, 2, 'Pago Deudas', 'fa fa-circle-o', 'pago/listar', 3);
INSERT INTO menu VALUES (9, 2, 'Consulta venta', 'fa fa-circle-o', 'consultar_venta', 2);


--
-- TOC entry 2557 (class 0 OID 0)
-- Dependencies: 234
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('menu_id_seq', 28, true);


--
-- TOC entry 2499 (class 0 OID 80407)
-- Dependencies: 235
-- Data for Name: movimiento_caja; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2558 (class 0 OID 0)
-- Dependencies: 236
-- Name: movimiento_caja_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('movimiento_caja_id_seq', 1, false);


--
-- TOC entry 2501 (class 0 OID 80416)
-- Dependencies: 237
-- Data for Name: nota_venta; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO nota_venta VALUES (1, 1, 1);
INSERT INTO nota_venta VALUES (2, 2, 2);
INSERT INTO nota_venta VALUES (3, 3, 3);
INSERT INTO nota_venta VALUES (4, 4, 4);
INSERT INTO nota_venta VALUES (5, 5, 5);
INSERT INTO nota_venta VALUES (6, 6, 6);
INSERT INTO nota_venta VALUES (7, 7, 7);
INSERT INTO nota_venta VALUES (8, 8, 8);
INSERT INTO nota_venta VALUES (9, 9, 9);
INSERT INTO nota_venta VALUES (10, 10, 10);
INSERT INTO nota_venta VALUES (11, 11, 11);
INSERT INTO nota_venta VALUES (12, 12, 12);
INSERT INTO nota_venta VALUES (13, 13, 13);
INSERT INTO nota_venta VALUES (14, 14, 14);
INSERT INTO nota_venta VALUES (15, 15, 15);
INSERT INTO nota_venta VALUES (16, 16, 16);
INSERT INTO nota_venta VALUES (17, 17, 17);
INSERT INTO nota_venta VALUES (18, 18, 18);
INSERT INTO nota_venta VALUES (19, 19, 19);
INSERT INTO nota_venta VALUES (20, 20, 20);
INSERT INTO nota_venta VALUES (21, 21, 21);
INSERT INTO nota_venta VALUES (22, 22, 22);
INSERT INTO nota_venta VALUES (23, 23, 23);
INSERT INTO nota_venta VALUES (24, 24, 24);
INSERT INTO nota_venta VALUES (25, 25, 25);
INSERT INTO nota_venta VALUES (26, 26, 26);
INSERT INTO nota_venta VALUES (27, 27, 27);
INSERT INTO nota_venta VALUES (28, 28, 28);
INSERT INTO nota_venta VALUES (29, 29, 29);
INSERT INTO nota_venta VALUES (30, 30, 30);
INSERT INTO nota_venta VALUES (31, 31, 31);
INSERT INTO nota_venta VALUES (32, 32, 32);
INSERT INTO nota_venta VALUES (33, 33, 33);
INSERT INTO nota_venta VALUES (34, 34, 34);
INSERT INTO nota_venta VALUES (35, 35, 35);
INSERT INTO nota_venta VALUES (36, 36, 36);
INSERT INTO nota_venta VALUES (37, 37, 37);
INSERT INTO nota_venta VALUES (38, 38, 38);
INSERT INTO nota_venta VALUES (39, 39, 39);
INSERT INTO nota_venta VALUES (40, 40, 40);
INSERT INTO nota_venta VALUES (41, 41, 41);
INSERT INTO nota_venta VALUES (42, 42, 42);
INSERT INTO nota_venta VALUES (43, 43, 43);
INSERT INTO nota_venta VALUES (44, 44, 44);
INSERT INTO nota_venta VALUES (45, 45, 45);
INSERT INTO nota_venta VALUES (46, 46, 46);
INSERT INTO nota_venta VALUES (47, 47, 47);
INSERT INTO nota_venta VALUES (48, 48, 48);
INSERT INTO nota_venta VALUES (49, 49, 49);
INSERT INTO nota_venta VALUES (50, 50, 50);
INSERT INTO nota_venta VALUES (51, 51, 51);
INSERT INTO nota_venta VALUES (52, 52, 52);
INSERT INTO nota_venta VALUES (53, 53, 53);
INSERT INTO nota_venta VALUES (54, 54, 54);
INSERT INTO nota_venta VALUES (55, 55, 55);
INSERT INTO nota_venta VALUES (56, 56, 56);
INSERT INTO nota_venta VALUES (57, 57, 57);
INSERT INTO nota_venta VALUES (58, 58, 58);
INSERT INTO nota_venta VALUES (59, 59, 59);
INSERT INTO nota_venta VALUES (60, 60, 60);
INSERT INTO nota_venta VALUES (61, 61, 61);
INSERT INTO nota_venta VALUES (62, 62, 62);
INSERT INTO nota_venta VALUES (63, 63, 63);
INSERT INTO nota_venta VALUES (64, 64, 64);
INSERT INTO nota_venta VALUES (65, 65, 65);
INSERT INTO nota_venta VALUES (66, 66, 66);
INSERT INTO nota_venta VALUES (67, 67, 67);
INSERT INTO nota_venta VALUES (68, 68, 68);
INSERT INTO nota_venta VALUES (69, 69, 69);
INSERT INTO nota_venta VALUES (70, 70, 70);
INSERT INTO nota_venta VALUES (71, 71, 71);
INSERT INTO nota_venta VALUES (72, 72, 72);
INSERT INTO nota_venta VALUES (73, 73, 73);
INSERT INTO nota_venta VALUES (74, 74, 74);
INSERT INTO nota_venta VALUES (75, 75, 75);
INSERT INTO nota_venta VALUES (76, 76, 76);
INSERT INTO nota_venta VALUES (77, 77, 77);
INSERT INTO nota_venta VALUES (78, 78, 78);
INSERT INTO nota_venta VALUES (79, 79, 79);
INSERT INTO nota_venta VALUES (80, 80, 80);
INSERT INTO nota_venta VALUES (81, 81, 81);
INSERT INTO nota_venta VALUES (82, 82, 82);
INSERT INTO nota_venta VALUES (83, 83, 83);
INSERT INTO nota_venta VALUES (84, 84, 84);
INSERT INTO nota_venta VALUES (85, 85, 85);
INSERT INTO nota_venta VALUES (86, 86, 86);
INSERT INTO nota_venta VALUES (87, 87, 87);
INSERT INTO nota_venta VALUES (88, 88, 88);
INSERT INTO nota_venta VALUES (89, 89, 89);
INSERT INTO nota_venta VALUES (90, 90, 90);
INSERT INTO nota_venta VALUES (91, 91, 91);
INSERT INTO nota_venta VALUES (92, 92, 92);
INSERT INTO nota_venta VALUES (93, 93, 93);
INSERT INTO nota_venta VALUES (94, 94, 94);
INSERT INTO nota_venta VALUES (95, 95, 95);
INSERT INTO nota_venta VALUES (96, 96, 96);
INSERT INTO nota_venta VALUES (97, 97, 97);
INSERT INTO nota_venta VALUES (98, 98, 98);
INSERT INTO nota_venta VALUES (99, 99, 99);
INSERT INTO nota_venta VALUES (100, 100, 100);
INSERT INTO nota_venta VALUES (101, 101, 101);
INSERT INTO nota_venta VALUES (102, 102, 102);
INSERT INTO nota_venta VALUES (103, 103, 103);
INSERT INTO nota_venta VALUES (104, 104, 104);
INSERT INTO nota_venta VALUES (105, 105, 105);
INSERT INTO nota_venta VALUES (106, 106, 106);
INSERT INTO nota_venta VALUES (107, 107, 107);
INSERT INTO nota_venta VALUES (108, 108, 108);
INSERT INTO nota_venta VALUES (109, 109, 109);
INSERT INTO nota_venta VALUES (110, 110, 110);
INSERT INTO nota_venta VALUES (111, 111, 111);
INSERT INTO nota_venta VALUES (112, 112, 112);
INSERT INTO nota_venta VALUES (113, 113, 113);
INSERT INTO nota_venta VALUES (114, 114, 114);
INSERT INTO nota_venta VALUES (115, 115, 115);
INSERT INTO nota_venta VALUES (116, 116, 116);
INSERT INTO nota_venta VALUES (117, 117, 117);
INSERT INTO nota_venta VALUES (118, 118, 118);
INSERT INTO nota_venta VALUES (119, 119, 119);
INSERT INTO nota_venta VALUES (120, 120, 120);
INSERT INTO nota_venta VALUES (121, 121, 121);
INSERT INTO nota_venta VALUES (122, 122, 122);
INSERT INTO nota_venta VALUES (123, 123, 123);
INSERT INTO nota_venta VALUES (124, 124, 124);
INSERT INTO nota_venta VALUES (125, 125, 125);
INSERT INTO nota_venta VALUES (126, 126, 126);
INSERT INTO nota_venta VALUES (127, 127, 127);
INSERT INTO nota_venta VALUES (128, 128, 128);
INSERT INTO nota_venta VALUES (129, 129, 129);
INSERT INTO nota_venta VALUES (130, 130, 130);
INSERT INTO nota_venta VALUES (131, 131, 131);
INSERT INTO nota_venta VALUES (132, 132, 132);
INSERT INTO nota_venta VALUES (133, 133, 133);
INSERT INTO nota_venta VALUES (134, 134, 134);
INSERT INTO nota_venta VALUES (135, 135, 135);
INSERT INTO nota_venta VALUES (136, 136, 136);
INSERT INTO nota_venta VALUES (137, 137, 137);
INSERT INTO nota_venta VALUES (138, 138, 138);
INSERT INTO nota_venta VALUES (139, 139, 139);
INSERT INTO nota_venta VALUES (140, 140, 140);
INSERT INTO nota_venta VALUES (141, 141, 141);
INSERT INTO nota_venta VALUES (142, 142, 142);
INSERT INTO nota_venta VALUES (143, 143, 143);
INSERT INTO nota_venta VALUES (144, 144, 144);
INSERT INTO nota_venta VALUES (145, 145, 145);
INSERT INTO nota_venta VALUES (146, 146, 146);
INSERT INTO nota_venta VALUES (147, 147, 147);
INSERT INTO nota_venta VALUES (148, 148, 148);
INSERT INTO nota_venta VALUES (149, 149, 149);
INSERT INTO nota_venta VALUES (150, 150, 150);
INSERT INTO nota_venta VALUES (151, 151, 151);
INSERT INTO nota_venta VALUES (152, 152, 152);
INSERT INTO nota_venta VALUES (153, 153, 153);
INSERT INTO nota_venta VALUES (154, 154, 154);
INSERT INTO nota_venta VALUES (155, 155, 155);
INSERT INTO nota_venta VALUES (156, 156, 156);
INSERT INTO nota_venta VALUES (157, 157, 157);
INSERT INTO nota_venta VALUES (158, 158, 158);
INSERT INTO nota_venta VALUES (159, 159, 159);
INSERT INTO nota_venta VALUES (160, 160, 160);
INSERT INTO nota_venta VALUES (161, 161, 161);
INSERT INTO nota_venta VALUES (162, 162, 162);
INSERT INTO nota_venta VALUES (163, 163, 163);
INSERT INTO nota_venta VALUES (164, 164, 164);
INSERT INTO nota_venta VALUES (165, 165, 165);
INSERT INTO nota_venta VALUES (166, 166, 166);
INSERT INTO nota_venta VALUES (167, 167, 167);
INSERT INTO nota_venta VALUES (168, 168, 168);
INSERT INTO nota_venta VALUES (169, 169, 169);
INSERT INTO nota_venta VALUES (170, 170, 170);
INSERT INTO nota_venta VALUES (171, 171, 171);
INSERT INTO nota_venta VALUES (172, 172, 172);
INSERT INTO nota_venta VALUES (173, 173, 173);
INSERT INTO nota_venta VALUES (174, 174, 174);
INSERT INTO nota_venta VALUES (175, 175, 175);
INSERT INTO nota_venta VALUES (176, 176, 176);
INSERT INTO nota_venta VALUES (177, 177, 177);
INSERT INTO nota_venta VALUES (178, 178, 178);
INSERT INTO nota_venta VALUES (179, 179, 179);
INSERT INTO nota_venta VALUES (180, 180, 180);
INSERT INTO nota_venta VALUES (181, 181, 181);
INSERT INTO nota_venta VALUES (182, 182, 182);
INSERT INTO nota_venta VALUES (183, 183, 183);
INSERT INTO nota_venta VALUES (184, 184, 184);
INSERT INTO nota_venta VALUES (185, 185, 185);
INSERT INTO nota_venta VALUES (186, 186, 186);
INSERT INTO nota_venta VALUES (187, 187, 187);
INSERT INTO nota_venta VALUES (188, 188, 188);
INSERT INTO nota_venta VALUES (189, 189, 189);
INSERT INTO nota_venta VALUES (190, 190, 190);
INSERT INTO nota_venta VALUES (191, 191, 191);
INSERT INTO nota_venta VALUES (192, 192, 192);
INSERT INTO nota_venta VALUES (193, 193, 193);
INSERT INTO nota_venta VALUES (194, 194, 194);
INSERT INTO nota_venta VALUES (195, 195, 195);
INSERT INTO nota_venta VALUES (196, 196, 196);
INSERT INTO nota_venta VALUES (197, 197, 197);
INSERT INTO nota_venta VALUES (198, 198, 198);
INSERT INTO nota_venta VALUES (199, 199, 199);
INSERT INTO nota_venta VALUES (200, 200, 200);
INSERT INTO nota_venta VALUES (201, 201, 201);
INSERT INTO nota_venta VALUES (202, 202, 202);
INSERT INTO nota_venta VALUES (203, 203, 203);
INSERT INTO nota_venta VALUES (204, 204, 204);
INSERT INTO nota_venta VALUES (205, 205, 205);
INSERT INTO nota_venta VALUES (206, 206, 206);
INSERT INTO nota_venta VALUES (207, 207, 207);
INSERT INTO nota_venta VALUES (208, 208, 208);
INSERT INTO nota_venta VALUES (209, 209, 209);
INSERT INTO nota_venta VALUES (210, 210, 210);
INSERT INTO nota_venta VALUES (211, 211, 211);
INSERT INTO nota_venta VALUES (212, 212, 212);
INSERT INTO nota_venta VALUES (213, 213, 213);
INSERT INTO nota_venta VALUES (214, 214, 214);
INSERT INTO nota_venta VALUES (215, 215, 215);
INSERT INTO nota_venta VALUES (216, 216, 216);
INSERT INTO nota_venta VALUES (217, 217, 217);
INSERT INTO nota_venta VALUES (218, 218, 218);
INSERT INTO nota_venta VALUES (219, 219, 219);
INSERT INTO nota_venta VALUES (220, 220, 220);
INSERT INTO nota_venta VALUES (221, 221, 221);
INSERT INTO nota_venta VALUES (222, 222, 222);
INSERT INTO nota_venta VALUES (223, 223, 223);
INSERT INTO nota_venta VALUES (224, 224, 224);
INSERT INTO nota_venta VALUES (225, 225, 225);
INSERT INTO nota_venta VALUES (226, 226, 226);
INSERT INTO nota_venta VALUES (227, 227, 227);
INSERT INTO nota_venta VALUES (228, 228, 228);
INSERT INTO nota_venta VALUES (229, 229, 229);
INSERT INTO nota_venta VALUES (230, 230, 230);
INSERT INTO nota_venta VALUES (231, 231, 231);
INSERT INTO nota_venta VALUES (232, 232, 232);
INSERT INTO nota_venta VALUES (233, 1, 233);
INSERT INTO nota_venta VALUES (234, 128, 234);
INSERT INTO nota_venta VALUES (235, 129, 235);
INSERT INTO nota_venta VALUES (236, 233, 236);
INSERT INTO nota_venta VALUES (237, 234, 237);
INSERT INTO nota_venta VALUES (238, 235, 238);
INSERT INTO nota_venta VALUES (239, 236, 239);
INSERT INTO nota_venta VALUES (240, 237, 240);
INSERT INTO nota_venta VALUES (241, 238, 241);
INSERT INTO nota_venta VALUES (242, 239, 242);
INSERT INTO nota_venta VALUES (243, 240, 243);
INSERT INTO nota_venta VALUES (244, 241, 244);
INSERT INTO nota_venta VALUES (245, 242, 245);
INSERT INTO nota_venta VALUES (246, 243, 246);
INSERT INTO nota_venta VALUES (247, 244, 247);
INSERT INTO nota_venta VALUES (248, 245, 248);
INSERT INTO nota_venta VALUES (249, 246, 249);
INSERT INTO nota_venta VALUES (250, 247, 250);
INSERT INTO nota_venta VALUES (251, 248, 251);
INSERT INTO nota_venta VALUES (252, 249, 252);
INSERT INTO nota_venta VALUES (253, 250, 253);
INSERT INTO nota_venta VALUES (254, 251, 254);
INSERT INTO nota_venta VALUES (255, 252, 255);
INSERT INTO nota_venta VALUES (256, 253, 256);
INSERT INTO nota_venta VALUES (257, 254, 257);
INSERT INTO nota_venta VALUES (258, 255, 258);
INSERT INTO nota_venta VALUES (259, 256, 259);
INSERT INTO nota_venta VALUES (260, 257, 260);
INSERT INTO nota_venta VALUES (261, 258, 261);
INSERT INTO nota_venta VALUES (262, 259, 262);
INSERT INTO nota_venta VALUES (263, 260, 263);
INSERT INTO nota_venta VALUES (264, 261, 264);
INSERT INTO nota_venta VALUES (265, 262, 265);


--
-- TOC entry 2559 (class 0 OID 0)
-- Dependencies: 238
-- Name: nota_venta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('nota_venta_id_seq', 265, true);


--
-- TOC entry 2490 (class 0 OID 80346)
-- Dependencies: 224
-- Data for Name: producto; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO producto VALUES (502, 'AX-1001', NULL, 'ALMOHADA NASA CERVICAL', 250.00, 110.00, 5, 1, 2, 26, 1, 'ALMOHADA NASA CERVICAL DUOFLEX 12,5X7,5X11CM', '12,5X7,5X11CM', 7, 11, 1, '2018-03-06 11:29:52', 1, NULL);
INSERT INTO producto VALUES (503, 'AX-1002', NULL, 'ALMOHADA NASA', 200.00, 92.00, 5, 1, 1, 26, 1, 'ALMOHADA NASA DUOFLEX 14 CM', '14 CM', 7, 11, 1, '2018-03-06 14:09:14', 1, NULL);


--
-- TOC entry 2560 (class 0 OID 0)
-- Dependencies: 242
-- Name: producto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('producto_id_seq', 503, true);


--
-- TOC entry 2491 (class 0 OID 80353)
-- Dependencies: 225
-- Data for Name: producto_inventario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO producto_inventario VALUES (620, 5, 146, 502, 250.00, 4, 1);
INSERT INTO producto_inventario VALUES (621, 5, 147, 503, 200.00, 5, 1);


--
-- TOC entry 2561 (class 0 OID 0)
-- Dependencies: 243
-- Name: producto_inventario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('producto_inventario_id_seq', 621, true);


--
-- TOC entry 2507 (class 0 OID 80445)
-- Dependencies: 244
-- Data for Name: proforma; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2562 (class 0 OID 0)
-- Dependencies: 246
-- Name: proforma_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('proforma_id_seq', 1, true);


--
-- TOC entry 2509 (class 0 OID 80458)
-- Dependencies: 247
-- Data for Name: proveedor; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO proveedor VALUES (1, 'MyK', '3321260', 'Santa Cruz', 1);


--
-- TOC entry 2563 (class 0 OID 0)
-- Dependencies: 248
-- Name: proveedor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('proveedor_id_seq', 1, false);


--
-- TOC entry 2512 (class 0 OID 80469)
-- Dependencies: 250
-- Data for Name: salida_inventario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO salida_inventario VALUES (1, 'inicio', '2018-02-06 16:16:05', '2018-02-06 16:16:05', 1, 1, 2, 1, 2, '2018-02-06 16:16:05', 1);


--
-- TOC entry 2564 (class 0 OID 0)
-- Dependencies: 249
-- Name: salida_inventario_sec; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('salida_inventario_sec', 1, true);


--
-- TOC entry 2492 (class 0 OID 80357)
-- Dependencies: 226
-- Data for Name: sucursal; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO sucursal VALUES (2, ' 4577400010', 'DICARP', 'CASA MATRIZ', 1, 'AV 2 DE FEBRERO 2DO ANILLO Y CENTENARIO', ' 70838701', 'dicarp@gmail.com', 'casa matriz');


--
-- TOC entry 2565 (class 0 OID 0)
-- Dependencies: 251
-- Name: sucursal_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('sucursal_id_seq', 2, true);


--
-- TOC entry 2493 (class 0 OID 80364)
-- Dependencies: 227
-- Data for Name: talla; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO talla VALUES (26, 'DICARP');


--
-- TOC entry 2566 (class 0 OID 0)
-- Dependencies: 252
-- Name: talla_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('talla_id_seq', 33, true);


--
-- TOC entry 2515 (class 0 OID 80480)
-- Dependencies: 253
-- Data for Name: tipo_ingreso_egreso; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 2567 (class 0 OID 0)
-- Dependencies: 254
-- Name: tipo_ingreso_egreso_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_ingreso_egreso_id_seq', 1, false);


--
-- TOC entry 2494 (class 0 OID 80371)
-- Dependencies: 228
-- Data for Name: tipo_item; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_item VALUES (1, 'Producto', 1);
INSERT INTO tipo_item VALUES (2, 'Materia Prima', 1);


--
-- TOC entry 2568 (class 0 OID 0)
-- Dependencies: 255
-- Name: tipo_item_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_item_id_seq', 2, true);


--
-- TOC entry 2519 (class 0 OID 80493)
-- Dependencies: 257
-- Data for Name: tipo_salida_inventario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_salida_inventario VALUES (2, 'otros', 'otros', '2017-01-30 00:00:00', 1);
INSERT INTO tipo_salida_inventario VALUES (1, 'salida inventario1', 'salida inventario1', '2017-01-30 00:00:00', 1);


--
-- TOC entry 2569 (class 0 OID 0)
-- Dependencies: 256
-- Name: tipo_salida_inventario_sec; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_salida_inventario_sec', 1, false);


--
-- TOC entry 2495 (class 0 OID 80378)
-- Dependencies: 229
-- Data for Name: unidad_medida; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO unidad_medida VALUES (1, 'PIEZAS', 'PZA');


--
-- TOC entry 2570 (class 0 OID 0)
-- Dependencies: 258
-- Name: unidad_medida_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('unidad_medida_id_seq', 9, true);


--
-- TOC entry 2521 (class 0 OID 80502)
-- Dependencies: 259
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO usuario VALUES (8, '2', 'LISETT RAMIREZ RAMIREZ', '77314668', 3, 'Lisett', '$2y$10$eZBlTXr3WTxehkd55ztiz.oZ.HZUsUcrpz81XDyJM0pYJH.qn8OJ6', NULL, 1);
INSERT INTO usuario VALUES (7, '1', 'MARIA DEISY JUSTINIANO', '9302099', 2, 'maria', '$2y$10$oLI7W1TTJnDtOwoRYE8otO/5wXjMAM7/pphLXeWJkjYfXZYFzVv8K', 0, 1);
INSERT INTO usuario VALUES (1, '0', 'LISSY', '0', 1, 'admin', '$2y$10$9kbE0OVkWXln4OqOIi7I2eiPUlatlS0n6J9c36Vs3/ntQ3gTe/UXi', 1, 1);


--
-- TOC entry 2571 (class 0 OID 0)
-- Dependencies: 260
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuario_id_seq', 8, true);


--
-- TOC entry 2523 (class 0 OID 80511)
-- Dependencies: 261
-- Data for Name: usuario_sucursal; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO usuario_sucursal VALUES (1, 1);
INSERT INTO usuario_sucursal VALUES (1, 2);
INSERT INTO usuario_sucursal VALUES (5, 1);
INSERT INTO usuario_sucursal VALUES (5, 2);
INSERT INTO usuario_sucursal VALUES (1, 3);
INSERT INTO usuario_sucursal VALUES (5, 3);
INSERT INTO usuario_sucursal VALUES (4, 1);
INSERT INTO usuario_sucursal VALUES (4, 2);
INSERT INTO usuario_sucursal VALUES (4, 3);
INSERT INTO usuario_sucursal VALUES (3, 1);
INSERT INTO usuario_sucursal VALUES (3, 2);
INSERT INTO usuario_sucursal VALUES (3, 3);
INSERT INTO usuario_sucursal VALUES (2, 1);
INSERT INTO usuario_sucursal VALUES (2, 2);
INSERT INTO usuario_sucursal VALUES (2, 3);
INSERT INTO usuario_sucursal VALUES (6, 2);
INSERT INTO usuario_sucursal VALUES (6, 3);
INSERT INTO usuario_sucursal VALUES (6, 1);
INSERT INTO usuario_sucursal VALUES (7, 2);
INSERT INTO usuario_sucursal VALUES (8, 2);


--
-- TOC entry 2503 (class 0 OID 80422)
-- Dependencies: 239
-- Data for Name: venta; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO venta VALUES (262, '2018-03-06', 250.00, 5.00, 245.00, 351, 1, 1, 2, 1, 'nota', '11:30:52');


--
-- TOC entry 2572 (class 0 OID 0)
-- Dependencies: 262
-- Name: venta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('venta_id_seq', 262, true);


--
-- TOC entry 2504 (class 0 OID 80429)
-- Dependencies: 240
-- Data for Name: venta_pago; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO venta_pago VALUES (258, 256, 'Efectivo', NULL, NULL, NULL, NULL, NULL, 250.00, 0.00, 'Cancelado', '2018-03-01');
INSERT INTO venta_pago VALUES (259, 257, 'Efectivo', NULL, NULL, NULL, NULL, NULL, 1050.00, 0.00, 'Cancelado', '2018-03-02');
INSERT INTO venta_pago VALUES (260, 258, 'Efectivo', NULL, NULL, NULL, NULL, NULL, 1250.00, 0.00, 'Cancelado', '2018-03-02');
INSERT INTO venta_pago VALUES (261, 259, 'Tarjeta', 'banco sol', NULL, '111', NULL, NULL, 250.00, 0.00, 'Debe', '2018-03-02');
INSERT INTO venta_pago VALUES (262, 260, 'Credito', NULL, NULL, NULL, '2018-03-05', NULL, 50.00, 200.00, 'Debe', '2018-03-05');
INSERT INTO venta_pago VALUES (263, 260, 'Credito', NULL, NULL, NULL, '2018-03-05', NULL, 100.00, 100.00, 'Debe', '2018-03-05');
INSERT INTO venta_pago VALUES (264, 260, 'Credito', NULL, NULL, NULL, '2018-03-05', NULL, 100.00, 100.00, 'Debe', '2018-03-05');
INSERT INTO venta_pago VALUES (265, 261, 'Efectivo', NULL, NULL, NULL, NULL, NULL, 90.00, 0.00, 'Cancelado', '2018-03-06');
INSERT INTO venta_pago VALUES (266, 262, 'Efectivo', NULL, NULL, NULL, NULL, NULL, 245.00, 0.00, 'Cancelado', '2018-03-06');


--
-- TOC entry 2573 (class 0 OID 0)
-- Dependencies: 263
-- Name: venta_pago_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('venta_pago_id_seq', 266, true);


--
-- TOC entry 2323 (class 2606 OID 80523)
-- Name: detalle_proforma PK_detalle_proforma; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY detalle_proforma
    ADD CONSTRAINT "PK_detalle_proforma" PRIMARY KEY (id);


--
-- TOC entry 2327 (class 2606 OID 80525)
-- Name: proforma PK_proforma; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY proforma
    ADD CONSTRAINT "PK_proforma" PRIMARY KEY (id);


--
-- TOC entry 2325 (class 2606 OID 80527)
-- Name: menu menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (id);


--
-- TOC entry 2328 (class 2606 OID 80528)
-- Name: detalle_proforma FK_detalle_proforma_proforma; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY detalle_proforma
    ADD CONSTRAINT "FK_detalle_proforma_proforma" FOREIGN KEY (proforma_id) REFERENCES proforma(id);


-- Completed on 2018-03-06 14:13:53

--
-- PostgreSQL database dump complete
--

