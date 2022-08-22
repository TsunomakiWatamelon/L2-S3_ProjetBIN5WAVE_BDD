--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.19
-- Dumped by pg_dump version 9.6.17

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: album; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.album (
    id_album integer NOT NULL,
    titre character varying(50),
    date_parution date,
    img bytea,
    descript text,
    auteur integer
);


ALTER TABLE public.album OWNER TO "iman.mellouk";

--
-- Name: album_id_album_seq; Type: SEQUENCE; Schema: public; Owner: iman.mellouk
--

CREATE SEQUENCE public.album_id_album_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.album_id_album_seq OWNER TO "iman.mellouk";

--
-- Name: album_id_album_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iman.mellouk
--

ALTER SEQUENCE public.album_id_album_seq OWNED BY public.album.id_album;


--
-- Name: appartient; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.appartient (
    id_artiste integer NOT NULL,
    id_groupe integer NOT NULL,
    arrivee date NOT NULL,
    depart date,
    CONSTRAINT chronologie_appartient CHECK (((depart IS NULL) OR (depart >= arrivee)))
);


ALTER TABLE public.appartient OWNER TO "iman.mellouk";

--
-- Name: artiste; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.artiste (
    id_artiste integer NOT NULL,
    nom character varying(50),
    prenom character varying(50),
    nationalite character(3),
    date_naiss date,
    date_mort date
);


ALTER TABLE public.artiste OWNER TO "iman.mellouk";

--
-- Name: artiste_id_artiste_seq; Type: SEQUENCE; Schema: public; Owner: iman.mellouk
--

CREATE SEQUENCE public.artiste_id_artiste_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.artiste_id_artiste_seq OWNER TO "iman.mellouk";

--
-- Name: artiste_id_artiste_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iman.mellouk
--

ALTER SEQUENCE public.artiste_id_artiste_seq OWNED BY public.artiste.id_artiste;


--
-- Name: dans_album; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.dans_album (
    id_morceau integer NOT NULL,
    id_album integer NOT NULL,
    numero integer
);


ALTER TABLE public.dans_album OWNER TO "iman.mellouk";

--
-- Name: dans_playlist; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.dans_playlist (
    id_morceau integer NOT NULL,
    id_playlist integer NOT NULL,
    numero integer
);


ALTER TABLE public.dans_playlist OWNER TO "iman.mellouk";

--
-- Name: ecoute; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.ecoute (
    id_morceau integer NOT NULL,
    id_user integer NOT NULL,
    date_ecoute timestamp without time zone NOT NULL
);


ALTER TABLE public.ecoute OWNER TO "iman.mellouk";

--
-- Name: groupe; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.groupe (
    id_groupe integer NOT NULL,
    nom character varying(50),
    date_creation date,
    nationalite character(3),
    genre character varying(30)
);


ALTER TABLE public.groupe OWNER TO "iman.mellouk";

--
-- Name: groupe_id_groupe_seq; Type: SEQUENCE; Schema: public; Owner: iman.mellouk
--

CREATE SEQUENCE public.groupe_id_groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groupe_id_groupe_seq OWNER TO "iman.mellouk";

--
-- Name: groupe_id_groupe_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iman.mellouk
--

ALTER SEQUENCE public.groupe_id_groupe_seq OWNED BY public.groupe.id_groupe;


--
-- Name: morceau; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.morceau (
    id_morceau integer NOT NULL,
    titre character varying(50),
    donnee bytea,
    paroles text,
    genre character varying(30),
    id_groupe integer
);


ALTER TABLE public.morceau OWNER TO "iman.mellouk";

--
-- Name: morceau_id_morceau_seq; Type: SEQUENCE; Schema: public; Owner: iman.mellouk
--

CREATE SEQUENCE public.morceau_id_morceau_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.morceau_id_morceau_seq OWNER TO "iman.mellouk";

--
-- Name: morceau_id_morceau_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iman.mellouk
--

ALTER SEQUENCE public.morceau_id_morceau_seq OWNED BY public.morceau.id_morceau;


--
-- Name: participe; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.participe (
    id_artiste integer NOT NULL,
    id_morceau integer NOT NULL
);


ALTER TABLE public.participe OWNER TO "iman.mellouk";

--
-- Name: playlist; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.playlist (
    id_playlist integer NOT NULL,
    titre character varying(30),
    visible boolean NOT NULL,
    descript text,
    id_user integer NOT NULL
);


ALTER TABLE public.playlist OWNER TO "iman.mellouk";

--
-- Name: playlist_id_playlist_seq; Type: SEQUENCE; Schema: public; Owner: iman.mellouk
--

CREATE SEQUENCE public.playlist_id_playlist_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.playlist_id_playlist_seq OWNER TO "iman.mellouk";

--
-- Name: playlist_id_playlist_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iman.mellouk
--

ALTER SEQUENCE public.playlist_id_playlist_seq OWNED BY public.playlist.id_playlist;


--
-- Name: suis_groupe; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.suis_groupe (
    id_groupe integer NOT NULL,
    id_user integer NOT NULL,
    parametre character varying(2) NOT NULL,
    CONSTRAINT suis_groupe_parametre CHECK ((((parametre)::text = 'A'::text) OR ((parametre)::text = 'M'::text) OR ((parametre)::text = 'AM'::text)))
);


ALTER TABLE public.suis_groupe OWNER TO "iman.mellouk";

--
-- Name: suis_user; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.suis_user (
    id_user integer NOT NULL,
    id_user2 integer NOT NULL
);


ALTER TABLE public.suis_user OWNER TO "iman.mellouk";

--
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: iman.mellouk
--

CREATE TABLE public.utilisateur (
    id_user integer NOT NULL,
    pseudo character varying(20) NOT NULL,
    date_inscription date NOT NULL,
    email character varying(50) NOT NULL,
    mdp character varying(30) NOT NULL,
    CONSTRAINT email_format CHECK (((email)::text ~~ '%@%'::text)),
    CONSTRAINT user_mdp_length CHECK ((length((mdp)::text) >= 6))
);


ALTER TABLE public.utilisateur OWNER TO "iman.mellouk";

--
-- Name: utilisateur_id_user_seq; Type: SEQUENCE; Schema: public; Owner: iman.mellouk
--

CREATE SEQUENCE public.utilisateur_id_user_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utilisateur_id_user_seq OWNER TO "iman.mellouk";

--
-- Name: utilisateur_id_user_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iman.mellouk
--

ALTER SEQUENCE public.utilisateur_id_user_seq OWNED BY public.utilisateur.id_user;


--
-- Name: album id_album; Type: DEFAULT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.album ALTER COLUMN id_album SET DEFAULT nextval('public.album_id_album_seq'::regclass);


--
-- Name: artiste id_artiste; Type: DEFAULT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.artiste ALTER COLUMN id_artiste SET DEFAULT nextval('public.artiste_id_artiste_seq'::regclass);


--
-- Name: groupe id_groupe; Type: DEFAULT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.groupe ALTER COLUMN id_groupe SET DEFAULT nextval('public.groupe_id_groupe_seq'::regclass);


--
-- Name: morceau id_morceau; Type: DEFAULT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.morceau ALTER COLUMN id_morceau SET DEFAULT nextval('public.morceau_id_morceau_seq'::regclass);


--
-- Name: playlist id_playlist; Type: DEFAULT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.playlist ALTER COLUMN id_playlist SET DEFAULT nextval('public.playlist_id_playlist_seq'::regclass);


--
-- Name: utilisateur id_user; Type: DEFAULT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.utilisateur ALTER COLUMN id_user SET DEFAULT nextval('public.utilisateur_id_user_seq'::regclass);


--
-- Data for Name: album; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.album VALUES (1, 'PEKORANDOMBRAIN', '2021-01-13', NULL, NULL, 1);
INSERT INTO public.album VALUES (2, 'Shoot For The Stars Aim For The Moon ', '2020-07-03', NULL, NULL, 4);
INSERT INTO public.album VALUES (3, 'OCEAN', '2019-05-03', NULL, 'Ocean est le second album de l artiste colombienne Karol G', 6);
INSERT INTO public.album VALUES (4, 'KG0516', '2001-03-27', NULL, '3 ème album de Karol G', 6);
INSERT INTO public.album VALUES (5, 'Sortie de l`ombre', '1995-01-01', NULL, 'Album qui finalement ne sortira pas pour cause de divergence entre les auteurs', 9);


--
-- Name: album_id_album_seq; Type: SEQUENCE SET; Schema: public; Owner: iman.mellouk
--

SELECT pg_catalog.setval('public.album_id_album_seq', 5, true);


--
-- Data for Name: appartient; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.appartient VALUES (1, 1, '2019-07-17', NULL);
INSERT INTO public.appartient VALUES (2, 2, '2020-10-01', NULL);
INSERT INTO public.appartient VALUES (4, 3, '1999-07-20', NULL);
INSERT INTO public.appartient VALUES (5, 4, '1991-12-22', NULL);
INSERT INTO public.appartient VALUES (6, 5, '2007-01-01', NULL);
INSERT INTO public.appartient VALUES (7, 9, '1994-01-01', '2003-08-18');
INSERT INTO public.appartient VALUES (8, 9, '1994-01-01', '2003-08-18');
INSERT INTO public.appartient VALUES (7, 7, '1994-01-01', NULL);
INSERT INTO public.appartient VALUES (8, 8, '1994-01-01', NULL);
INSERT INTO public.appartient VALUES (9, 10, '1994-01-01', NULL);


--
-- Data for Name: artiste; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.artiste VALUES (1, 'Usada', 'Pekora', 'JPN', '2019-07-17', NULL);
INSERT INTO public.artiste VALUES (2, 'menace', 'Santana', 'FRA', NULL, NULL);
INSERT INTO public.artiste VALUES (3, 'Woodley', 'Tyron', 'USA', '1982-04-17', NULL);
INSERT INTO public.artiste VALUES (4, 'Jackson', 'Bashar Barakah', 'USA', '1999-07-20', '2020-02-10');
INSERT INTO public.artiste VALUES (5, 'Kirk', 'Jonathan Lyndale', 'USA', '1991-12-22', NULL);
INSERT INTO public.artiste VALUES (6, 'Giraldo Navarro', 'Carolina', 'COL', '1994-02-14', NULL);
INSERT INTO public.artiste VALUES (7, 'Yaffa', 'Elie', 'FR ', '1974-12-09', NULL);
INSERT INTO public.artiste VALUES (8, 'Sekoumi', 'Yassine', 'FR ', '1975-05-05', NULL);
INSERT INTO public.artiste VALUES (9, 'Touré', 'Mamadou', 'FR ', '1977-07-18', NULL);


--
-- Name: artiste_id_artiste_seq; Type: SEQUENCE SET; Schema: public; Owner: iman.mellouk
--

SELECT pg_catalog.setval('public.artiste_id_artiste_seq', 9, true);


--
-- Data for Name: dans_album; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.dans_album VALUES (1, 1, 1);
INSERT INTO public.dans_album VALUES (3, 2, 6);
INSERT INTO public.dans_album VALUES (4, 2, 3);
INSERT INTO public.dans_album VALUES (5, 3, NULL);
INSERT INTO public.dans_album VALUES (6, 3, NULL);
INSERT INTO public.dans_album VALUES (7, 3, NULL);
INSERT INTO public.dans_album VALUES (8, 4, NULL);
INSERT INTO public.dans_album VALUES (9, 4, NULL);


--
-- Data for Name: dans_playlist; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.dans_playlist VALUES (2, 2, 2);
INSERT INTO public.dans_playlist VALUES (10, 4, 1);
INSERT INTO public.dans_playlist VALUES (6, 4, 2);
INSERT INTO public.dans_playlist VALUES (2, 3, 10);
INSERT INTO public.dans_playlist VALUES (5, 3, 3);
INSERT INTO public.dans_playlist VALUES (2, 30, 8);
INSERT INTO public.dans_playlist VALUES (12, 32, 1);
INSERT INTO public.dans_playlist VALUES (12, 3, 7);
INSERT INTO public.dans_playlist VALUES (1, 34, 1);
INSERT INTO public.dans_playlist VALUES (12, 34, 3);
INSERT INTO public.dans_playlist VALUES (3, 34, 7);
INSERT INTO public.dans_playlist VALUES (5, 34, 4);
INSERT INTO public.dans_playlist VALUES (8, 32, 10);
INSERT INTO public.dans_playlist VALUES (2, 25, 10);
INSERT INTO public.dans_playlist VALUES (1, 3, 5);
INSERT INTO public.dans_playlist VALUES (12, 35, 2);


--
-- Data for Name: ecoute; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.ecoute VALUES (1, 1, '2021-11-17 20:59:00');
INSERT INTO public.ecoute VALUES (2, 1, '2021-11-17 20:59:00');
INSERT INTO public.ecoute VALUES (1, 1, '2021-11-17 21:06:00');
INSERT INTO public.ecoute VALUES (1, 1, '2021-11-17 21:10:00');
INSERT INTO public.ecoute VALUES (1, 1, '2021-11-17 21:16:00');
INSERT INTO public.ecoute VALUES (1, 1, '2021-11-17 21:25:00');
INSERT INTO public.ecoute VALUES (5, 7, '2021-11-18 12:46:00');
INSERT INTO public.ecoute VALUES (5, 3, '2021-11-18 12:46:00');
INSERT INTO public.ecoute VALUES (3, 7, '2021-11-18 16:25:00');
INSERT INTO public.ecoute VALUES (1, 1, '2021-12-17 09:55:04.960653');
INSERT INTO public.ecoute VALUES (1, 1, '2021-12-17 09:55:26.753586');
INSERT INTO public.ecoute VALUES (1, 1, '2021-12-17 09:57:47.105598');
INSERT INTO public.ecoute VALUES (1, 1, '2021-12-17 10:00:07.624162');
INSERT INTO public.ecoute VALUES (1, 1, '2021-12-17 10:02:07.87884');
INSERT INTO public.ecoute VALUES (1, 44, '2021-12-18 16:04:21.278376');
INSERT INTO public.ecoute VALUES (1, 44, '2021-12-18 16:04:32.24904');
INSERT INTO public.ecoute VALUES (1, 44, '2021-12-18 16:34:09.491089');
INSERT INTO public.ecoute VALUES (5, 44, '2021-12-18 16:34:20.373085');
INSERT INTO public.ecoute VALUES (5, 44, '2021-12-18 16:34:26.683776');
INSERT INTO public.ecoute VALUES (2, 44, '2021-12-18 16:35:39.191012');
INSERT INTO public.ecoute VALUES (5, 44, '2021-12-18 16:48:32.485289');
INSERT INTO public.ecoute VALUES (3, 44, '2021-12-18 16:51:30.956227');
INSERT INTO public.ecoute VALUES (1, 1, '2021-12-18 17:09:08.54175');
INSERT INTO public.ecoute VALUES (3, 1, '2021-12-18 17:44:54.389113');
INSERT INTO public.ecoute VALUES (3, 1, '2021-12-18 20:10:58.263484');
INSERT INTO public.ecoute VALUES (2, 44, '2021-12-18 21:23:23.856667');
INSERT INTO public.ecoute VALUES (1, 44, '2021-12-18 21:25:46.509701');
INSERT INTO public.ecoute VALUES (5, 44, '2021-12-18 21:26:38.17835');
INSERT INTO public.ecoute VALUES (3, 44, '2021-12-18 21:26:48.621682');
INSERT INTO public.ecoute VALUES (5, 44, '2021-12-18 21:27:12.434567');
INSERT INTO public.ecoute VALUES (2, 44, '2021-12-18 21:28:40.409801');
INSERT INTO public.ecoute VALUES (1, 1, '2021-12-19 13:34:33.885071');
INSERT INTO public.ecoute VALUES (2, 44, '2021-12-19 17:44:54.860817');
INSERT INTO public.ecoute VALUES (1, 53, '2021-12-19 20:15:36.221982');
INSERT INTO public.ecoute VALUES (1, 53, '2021-12-19 20:19:08.504675');
INSERT INTO public.ecoute VALUES (12, 53, '2021-12-19 20:21:46.458637');
INSERT INTO public.ecoute VALUES (1, 53, '2021-12-19 20:32:40.562558');
INSERT INTO public.ecoute VALUES (1, 47, '2021-12-19 21:06:08.824996');
INSERT INTO public.ecoute VALUES (2, 1, '2021-12-19 21:06:14.283127');
INSERT INTO public.ecoute VALUES (2, 1, '2021-12-19 21:06:55.016828');
INSERT INTO public.ecoute VALUES (2, 1, '2021-12-19 21:06:58.316758');
INSERT INTO public.ecoute VALUES (2, 1, '2021-12-19 21:07:13.483464');
INSERT INTO public.ecoute VALUES (1, 47, '2021-12-19 21:07:30.499871');
INSERT INTO public.ecoute VALUES (2, 1, '2021-12-19 21:07:39.531096');
INSERT INTO public.ecoute VALUES (1, 47, '2021-12-19 21:07:48.734455');
INSERT INTO public.ecoute VALUES (1, 47, '2021-12-19 21:10:51.992284');
INSERT INTO public.ecoute VALUES (1, 47, '2021-12-19 21:11:55.069093');
INSERT INTO public.ecoute VALUES (12, 47, '2021-12-19 21:16:37.149807');
INSERT INTO public.ecoute VALUES (4, 53, '2021-12-19 21:38:27.11807');
INSERT INTO public.ecoute VALUES (12, 53, '2021-12-19 21:42:11.496059');


--
-- Data for Name: groupe; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.groupe VALUES (1, 'Usada Pekora', '2019-07-17', 'JPN', 'Pop');
INSERT INTO public.groupe VALUES (2, 'menace Santana', '2020-10-01', 'FRA', 'Drill');
INSERT INTO public.groupe VALUES (3, 'Tyron Woodley', '1982-04-17', 'USA', NULL);
INSERT INTO public.groupe VALUES (4, 'Pop Smoke', '1999-07-20', 'USA', 'Rap');
INSERT INTO public.groupe VALUES (5, 'DaBaby', '1991-12-22', 'USA', 'Rap');
INSERT INTO public.groupe VALUES (6, 'Karol G', '2007-01-01', 'COL', 'Reggeaton, Latin trap');
INSERT INTO public.groupe VALUES (7, 'Booba', '1994-01-01', 'FR ', 'Hip-Hop FR, gangsta rap');
INSERT INTO public.groupe VALUES (8, 'Ali', '1994-01-01', 'FR ', 'Hip-Hop, rap FR');
INSERT INTO public.groupe VALUES (9, 'Lunatic', '1994-01-01', 'FR ', 'Hip-Hop FR');
INSERT INTO public.groupe VALUES (10, 'Sir doum`s', '1997-01-01', 'FR ', 'Hip-Hop FR');


--
-- Name: groupe_id_groupe_seq; Type: SEQUENCE SET; Schema: public; Owner: iman.mellouk
--

SELECT pg_catalog.setval('public.groupe_id_groupe_seq', 10, true);


--
-- Data for Name: morceau; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.morceau VALUES (1, 'PEKORANDOMBRAIN', NULL, NULL, 'Pop', 1);
INSERT INTO public.morceau VALUES (2, 'Michael Myers', NULL, NULL, 'Drill', 2);
INSERT INTO public.morceau VALUES (3, 'Yea Yea', NULL, NULL, 'Rap', 4);
INSERT INTO public.morceau VALUES (4, 'For the Night', NULL, NULL, 'Rap', 4);
INSERT INTO public.morceau VALUES (5, 'Ocean', NULL, 'Si algún día te vas de casa (de casa)

Yo te llevo a la NASA

Yeh, pido un cohete y voy directo por ti

Y si no estoy y algo te pasa

Recuerda que todo en la vida cambia

Y no importa lo que pase, te prometo no faltarte

Me siento grande por ti

Y aunque lo intentara, no podría sin ti

Toda mi felicidad es gracias a ti

Y si yo me muero, volvería por ti

Me siento grande por ti

Y aunque lo intentara, no podría sin ti

Toda mi felicidad es gracias a ti

Y si yo me muero, volvería por ti, por ti

Se quedan cortas las palabras realmente

Y a Dios le doy gracias porque estás aquí presente

Quiero que sepas que te amo eternamente

Y que cuando dije sí, lo dije para siempre

A tu lado todo no es perfecto, pero sí mejor

Y cada detalle tuyo e mejor que el anterior

Aquella canción

Y cuando decoras con rosas mi habitación

Vamos a enseñarle al mundo lo que es amor

Tú y yo podemos juntos, eh

Porque amo toda las locuras de tu mente

Y así me encanta presumirte ante la gente

Me siento grande por ti

Y aunque lo intentara, no podría sin ti

Toda mi felicidad es gracias a ti

Y si yo me muero, volvería por ti

Me siento grande por ti

Y aunque lo intentara, no podría sin ti

Toda mi felicidad es gracias a ti

Y si yo me muero, volvería por ti (por ti)', 'reggeaton', 6);
INSERT INTO public.morceau VALUES (6, 'Pinneaple', NULL, NULL, 'reggeaton', 6);
INSERT INTO public.morceau VALUES (7, 'Bebecita', NULL, NULL, 'reggeaton', 6);
INSERT INTO public.morceau VALUES (8, 'DÉJALOS QUE MIREN', NULL, NULL, 'Latin Trap', 6);
INSERT INTO public.morceau VALUES (9, 'Gato Malo', NULL, NULL, 'Latin Trap', 6);
INSERT INTO public.morceau VALUES (10, 'L`effort de paix', NULL, NULL, 'Hip-Hop', 9);
INSERT INTO public.morceau VALUES (11, 'La lettre', NULL, NULL, 'Hip-Hop', 9);
INSERT INTO public.morceau VALUES (12, '92i veyron', NULL, NULL, 'Hip-Hop', 7);
INSERT INTO public.morceau VALUES (13, 'Que la paix soit sur vous', NULL, NULL, 'Hip-Hop', 8);


--
-- Name: morceau_id_morceau_seq; Type: SEQUENCE SET; Schema: public; Owner: iman.mellouk
--

SELECT pg_catalog.setval('public.morceau_id_morceau_seq', 13, true);


--
-- Data for Name: participe; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.participe VALUES (1, 1);
INSERT INTO public.participe VALUES (2, 2);
INSERT INTO public.participe VALUES (4, 3);
INSERT INTO public.participe VALUES (4, 4);
INSERT INTO public.participe VALUES (5, 4);
INSERT INTO public.participe VALUES (6, 5);
INSERT INTO public.participe VALUES (6, 6);
INSERT INTO public.participe VALUES (6, 7);
INSERT INTO public.participe VALUES (6, 8);
INSERT INTO public.participe VALUES (6, 9);
INSERT INTO public.participe VALUES (7, 10);
INSERT INTO public.participe VALUES (8, 10);
INSERT INTO public.participe VALUES (9, 10);
INSERT INTO public.participe VALUES (7, 11);
INSERT INTO public.participe VALUES (8, 11);
INSERT INTO public.participe VALUES (7, 12);
INSERT INTO public.participe VALUES (8, 13);


--
-- Data for Name: playlist; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.playlist VALUES (2, 'thewrld', true, 'In my hands', 5);
INSERT INTO public.playlist VALUES (4, 'Mes music', false, NULL, 7);
INSERT INTO public.playlist VALUES (5, 'My', true, 'play relaxante', 3);
INSERT INTO public.playlist VALUES (3, 'Latina', true, 'sons latino', 1);
INSERT INTO public.playlist VALUES (25, 'Pekora Watame', false, NULL, 1);
INSERT INTO public.playlist VALUES (26, 'test', false, NULL, 1);
INSERT INTO public.playlist VALUES (29, 'preeze porleone', false, 'enlevez lui le mot "comme" et il est nul', 1);
INSERT INTO public.playlist VALUES (30, 'max chamion', false, '2021', 44);
INSERT INTO public.playlist VALUES (34, 'soumsoum', true, NULL, 47);
INSERT INTO public.playlist VALUES (35, 'vhkbjlk', true, NULL, 1);
INSERT INTO public.playlist VALUES (1, 'Lmao', false, 'Study like Pekora waking up from her deep slumber', 1);
INSERT INTO public.playlist VALUES (32, 'elite', true, 'pascal', 53);


--
-- Name: playlist_id_playlist_seq; Type: SEQUENCE SET; Schema: public; Owner: iman.mellouk
--

SELECT pg_catalog.setval('public.playlist_id_playlist_seq', 36, true);


--
-- Data for Name: suis_groupe; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.suis_groupe VALUES (1, 1, 'AM');
INSERT INTO public.suis_groupe VALUES (2, 3, 'A');
INSERT INTO public.suis_groupe VALUES (1, 3, 'A');
INSERT INTO public.suis_groupe VALUES (6, 12, 'M');
INSERT INTO public.suis_groupe VALUES (2, 44, 'M');
INSERT INTO public.suis_groupe VALUES (7, 53, 'AM');
INSERT INTO public.suis_groupe VALUES (1, 53, 'A');
INSERT INTO public.suis_groupe VALUES (6, 53, 'M');


--
-- Data for Name: suis_user; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.suis_user VALUES (11, 1);
INSERT INTO public.suis_user VALUES (1, 44);
INSERT INTO public.suis_user VALUES (1, 8);
INSERT INTO public.suis_user VALUES (1, 7);
INSERT INTO public.suis_user VALUES (1, 10);
INSERT INTO public.suis_user VALUES (1, 4);
INSERT INTO public.suis_user VALUES (1, 2);
INSERT INTO public.suis_user VALUES (1, 6);
INSERT INTO public.suis_user VALUES (44, 11);
INSERT INTO public.suis_user VALUES (44, 1);
INSERT INTO public.suis_user VALUES (12, 53);
INSERT INTO public.suis_user VALUES (53, 12);
INSERT INTO public.suis_user VALUES (1, 11);
INSERT INTO public.suis_user VALUES (53, 53);


--
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: iman.mellouk
--

INSERT INTO public.utilisateur VALUES (1, 'Nousagi1', '2021-11-17', 'nousagi1@pekora.com', 'AZERTYUIOP');
INSERT INTO public.utilisateur VALUES (2, 'BIGKUSATIME', '2021-11-17', 'bigkusa@centralesupelec.fr', 'QWERTYUIOP');
INSERT INTO public.utilisateur VALUES (3, 'Balenciaga', '2021-11-17', 'info@fr.balenciaga.com', 'jksdfjnjl0');
INSERT INTO public.utilisateur VALUES (4, 'SeongJinWoo', '2021-11-17', 'sololeveling@naver.com', '123456');
INSERT INTO public.utilisateur VALUES (5, 'BlackrockFRA', '2021-11-17', 'france@blackrock.com', 'abcdefgh');
INSERT INTO public.utilisateur VALUES (6, 'ADMIN', '2021-11-16', 'admin@pekora.com', 'motdepasse');
INSERT INTO public.utilisateur VALUES (7, 'ledozo', '2021-11-17', 'ledozo@protonmail.com', 'kichta');
INSERT INTO public.utilisateur VALUES (8, 'JoeBailleden', '2021-11-18', 'president@whitehouse.gov', 'iwanttosleep');
INSERT INTO public.utilisateur VALUES (9, 'bibiCAC40', '2021-11-17', 'sp500@mit.edu', 'dowjones');
INSERT INTO public.utilisateur VALUES (10, 'SamsungOfficial', '2021-11-19', 'thewave@samsung.com', 'appleisthebest');
INSERT INTO public.utilisateur VALUES (11, 'InugamiKorone', '2021-11-17', 'korone@hololive.jp', 'nosleep');
INSERT INTO public.utilisateur VALUES (12, 'AnneHidalgo', '2021-11-17', 'maire@mairie-paris.fr', 'jaimelessaccages');
INSERT INTO public.utilisateur VALUES (13, 'MaxVerstappen1', '2021-11-17', 'max@verstappen1.nl', 'champion2021');
INSERT INTO public.utilisateur VALUES (14, 'Miichet', '2021-11-17', 'louis.vanderlinde@edu.univ-eiffel.fr', 'uparisestcreteil');
INSERT INTO public.utilisateur VALUES (44, 'ziziak', '2021-12-16', 'ziziak@gmail.com', 'aqwzsxedc');
INSERT INTO public.utilisateur VALUES (45, 'azerty', '2021-12-17', 'azert@gmail.com', 'azerty');
INSERT INTO public.utilisateur VALUES (47, 'ssaidi04', '2021-12-19', 'ssaidi04@etud.fr', 'SOUSOU');
INSERT INTO public.utilisateur VALUES (53, 'pascal', '2021-12-19', 'patrick@pascal', 'pascalpatrick');


--
-- Name: utilisateur_id_user_seq; Type: SEQUENCE SET; Schema: public; Owner: iman.mellouk
--

SELECT pg_catalog.setval('public.utilisateur_id_user_seq', 58, true);


--
-- Name: album album_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.album
    ADD CONSTRAINT album_pk PRIMARY KEY (id_album);


--
-- Name: appartient appartient_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.appartient
    ADD CONSTRAINT appartient_pk PRIMARY KEY (id_artiste, id_groupe, arrivee);


--
-- Name: artiste artiste_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.artiste
    ADD CONSTRAINT artiste_pk PRIMARY KEY (id_artiste);


--
-- Name: dans_album dans_album_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.dans_album
    ADD CONSTRAINT dans_album_pk PRIMARY KEY (id_morceau, id_album);


--
-- Name: dans_playlist dans_playlist_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.dans_playlist
    ADD CONSTRAINT dans_playlist_pk PRIMARY KEY (id_morceau, id_playlist);


--
-- Name: ecoute ecoute_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.ecoute
    ADD CONSTRAINT ecoute_pk PRIMARY KEY (id_morceau, id_user, date_ecoute);


--
-- Name: utilisateur email_unique; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT email_unique UNIQUE (email);


--
-- Name: groupe groupe_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.groupe
    ADD CONSTRAINT groupe_pk PRIMARY KEY (id_groupe);


--
-- Name: morceau morceau_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.morceau
    ADD CONSTRAINT morceau_pk PRIMARY KEY (id_morceau);


--
-- Name: participe participe_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.participe
    ADD CONSTRAINT participe_pk PRIMARY KEY (id_artiste, id_morceau);


--
-- Name: playlist playlist_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.playlist
    ADD CONSTRAINT playlist_pk PRIMARY KEY (id_playlist);


--
-- Name: utilisateur pseudo_unique; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT pseudo_unique UNIQUE (pseudo);


--
-- Name: suis_groupe suis_groupe_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.suis_groupe
    ADD CONSTRAINT suis_groupe_pk PRIMARY KEY (id_groupe, id_user);


--
-- Name: suis_user suis_user_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.suis_user
    ADD CONSTRAINT suis_user_pk PRIMARY KEY (id_user, id_user2);


--
-- Name: utilisateur user_pk; Type: CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT user_pk PRIMARY KEY (id_user);


--
-- Name: appartient appartient_artiste_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.appartient
    ADD CONSTRAINT appartient_artiste_fk FOREIGN KEY (id_artiste) REFERENCES public.artiste(id_artiste) ON DELETE CASCADE;


--
-- Name: appartient appartient_groupe_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.appartient
    ADD CONSTRAINT appartient_groupe_fk FOREIGN KEY (id_groupe) REFERENCES public.groupe(id_groupe) ON DELETE CASCADE;


--
-- Name: album auteur_album_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.album
    ADD CONSTRAINT auteur_album_fk FOREIGN KEY (auteur) REFERENCES public.groupe(id_groupe) ON DELETE SET NULL;


--
-- Name: playlist cree_playlist_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.playlist
    ADD CONSTRAINT cree_playlist_fk FOREIGN KEY (id_user) REFERENCES public.utilisateur(id_user) ON DELETE CASCADE;


--
-- Name: dans_album dans_album_album_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.dans_album
    ADD CONSTRAINT dans_album_album_fk FOREIGN KEY (id_album) REFERENCES public.album(id_album) ON DELETE CASCADE;


--
-- Name: dans_album dans_album_morceau_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.dans_album
    ADD CONSTRAINT dans_album_morceau_fk FOREIGN KEY (id_morceau) REFERENCES public.morceau(id_morceau) ON DELETE CASCADE;


--
-- Name: ecoute ecoute_morceau_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.ecoute
    ADD CONSTRAINT ecoute_morceau_fk FOREIGN KEY (id_morceau) REFERENCES public.morceau(id_morceau) ON DELETE CASCADE;


--
-- Name: ecoute ecoute_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.ecoute
    ADD CONSTRAINT ecoute_user_fk FOREIGN KEY (id_user) REFERENCES public.utilisateur(id_user) ON DELETE CASCADE;


--
-- Name: morceau morceau_groupe_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.morceau
    ADD CONSTRAINT morceau_groupe_fk FOREIGN KEY (id_groupe) REFERENCES public.groupe(id_groupe) ON DELETE SET NULL;


--
-- Name: participe participe_artiste_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.participe
    ADD CONSTRAINT participe_artiste_fk FOREIGN KEY (id_artiste) REFERENCES public.artiste(id_artiste) ON DELETE CASCADE;


--
-- Name: participe participe_morceau_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.participe
    ADD CONSTRAINT participe_morceau_fk FOREIGN KEY (id_morceau) REFERENCES public.morceau(id_morceau) ON DELETE CASCADE;


--
-- Name: dans_playlist playlist_morceau_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.dans_playlist
    ADD CONSTRAINT playlist_morceau_fk FOREIGN KEY (id_morceau) REFERENCES public.morceau(id_morceau) ON DELETE CASCADE;


--
-- Name: dans_playlist playlist_playlist_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.dans_playlist
    ADD CONSTRAINT playlist_playlist_fk FOREIGN KEY (id_playlist) REFERENCES public.playlist(id_playlist) ON DELETE CASCADE;


--
-- Name: suis_groupe suis_groupe_groupe_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.suis_groupe
    ADD CONSTRAINT suis_groupe_groupe_fk FOREIGN KEY (id_groupe) REFERENCES public.groupe(id_groupe) ON DELETE CASCADE;


--
-- Name: suis_groupe suis_groupe_user_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.suis_groupe
    ADD CONSTRAINT suis_groupe_user_fk FOREIGN KEY (id_user) REFERENCES public.utilisateur(id_user) ON DELETE CASCADE;


--
-- Name: suis_user suis_user_1_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.suis_user
    ADD CONSTRAINT suis_user_1_fk FOREIGN KEY (id_user) REFERENCES public.utilisateur(id_user) ON DELETE CASCADE;


--
-- Name: suis_user suis_user_2_fk; Type: FK CONSTRAINT; Schema: public; Owner: iman.mellouk
--

ALTER TABLE ONLY public.suis_user
    ADD CONSTRAINT suis_user_2_fk FOREIGN KEY (id_user2) REFERENCES public.utilisateur(id_user) ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

