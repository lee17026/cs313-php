-- operators table
CREATE TABLE public.operator (
  id              SERIAL        NOT NULL    PRIMARY KEY,
  username        VARCHAR(64)   NOT NULL    UNIQUE,
  password        VARCHAR(64)   NOT NULL,
  first_name      VARCHAR(64)   NOT NULL,
  last_name       VARCHAR(64)   NOT NULL,
  role            VARCHAR(64)   NOT NULL,
  creation_date   DATE          NOT NULL    DEFAULT CURRENT_DATE
);

-- insert the DBA operator row
INSERT INTO public.operator (
    username,
    password,
    first_name,
    last_name,
    role)
VALUES (
        'Admin',
        'admin',
        'Fred',
        'Bread',
        'DBA');

-- create the sugar silo table
CREATE TABLE public.sugar_silo (
  id                SERIAL        NOT NULL    PRIMARY KEY,
  silo_number       CHAR(2)       NOT NULL    UNIQUE,
  amount            INT           NOT NULL,
  CONSTRAINT amount_min CHECK (amount >= 0),
  CONSTRAINT amount_max CHECK (amount <= 100000),
  created_by        INT           NOT NULL    REFERENCES  public.operator (id),
  creation_date     DATE          NOT NULL    DEFAULT CURRENT_DATE,
  last_updated_by   INT           NOT NULL    REFERENCES  public.operator (id),
  last_update_date  DATE          NOT NULL    DEFAULT CURRENT_DATE
);

-- insert the only two rows into sugar_silo
INSERT INTO public.sugar_silo (
    silo_number,
    amount,
    created_by,
    last_updated_by)
VALUES (
        '11',
        0,
        1,
        1),
       (
        '12',
        0,
        1,
        1);

-- create the sugar shipment table
CREATE TABLE public.sugar_shipment (
  id                SERIAL        NOT NULL    PRIMARY KEY,
  batch_code        CHAR(6)       NOT NULL    UNIQUE,
  amount            INT           NOT NULL,
  CONSTRAINT amount_min CHECK (amount >= 0),
  CONSTRAINT amount_max CHECK (amount <= 50000),
  location          INT           NOT NULL    REFERENCES  public.sugar_silo (id),
  created_by        INT           NOT NULL    REFERENCES  public.operator (id),
  creation_date     DATE          NOT NULL    DEFAULT CURRENT_DATE,
  last_updated_by   INT           NOT NULL    REFERENCES  public.operator (id),
  last_update_date  DATE          NOT NULL    DEFAULT CURRENT_DATE
);

-- create the recipe table
CREATE TABLE public.recipe (
  id                SERIAL        NOT NULL    PRIMARY KEY,
  recipe_code       CHAR(6)       NOT NULL    UNIQUE,
  recipe_name       VARCHAR(64)   NOT NULL,
  sugar_amount      INT           NOT NULL,
  CONSTRAINT sugar_amount_min CHECK (sugar_amount >= 0),
  CONSTRAINT sugar_amount_max CHECK (sugar_amount <= 6000),
  created_by        INT           NOT NULL    REFERENCES  public.operator (id),
  creation_date     DATE          NOT NULL    DEFAULT CURRENT_DATE,
  last_updated_by   INT           NOT NULL    REFERENCES  public.operator (id),
  last_update_date  DATE          NOT NULL    DEFAULT CURRENT_DATE
);

-- insert a test recipe
INSERT INTO public.recipe (
    recipe_code,
    recipe_name,
    sugar_amount,
    created_by,
    last_updated_by)
VALUES (
        '720001',
        'Hoisin',
        5468,
        1,
        1);

-- create the batch table, which is the main powerhouse
CREATE TABLE public.batch (
  id                SERIAL        NOT NULL    PRIMARY KEY,
  recipe            INT           NOT NULL    REFERENCES  public.recipe (id),
  sugar_batch       INT           NOT NULL    REFERENCES  public.sugar_shipment (id),
  created_by        INT           NOT NULL    REFERENCES  public.operator (id),
  creation_date     DATE          NOT NULL    DEFAULT CURRENT_DATE,
  last_updated_by   INT           NOT NULL    REFERENCES  public.operator (id),
  last_update_date  DATE          NOT NULL    DEFAULT CURRENT_DATE
);