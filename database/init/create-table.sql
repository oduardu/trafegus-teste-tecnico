CREATE TABLE drivers (
     cpf CHAR(11) NOT NULL UNIQUE,
     rg VARCHAR(20) NOT NULL UNIQUE,
     nome VARCHAR(200) NOT NULL,
     telefone VARCHAR(20),
     PRIMARY KEY (cpf)
);

CREATE TABLE vehicles (
      placa VARCHAR(7) NOT NULL UNIQUE,
      renavam VARCHAR(30) UNIQUE,
      modelo VARCHAR(20) NOT NULL,
      marca VARCHAR(20) NOT NULL,
      ano INTEGER NOT NULL,
      cor VARCHAR(20) NOT NULL,
      PRIMARY KEY (placa)
);

CREATE TABLE driver_vehicle (
    driver_cpf CHAR(11) NOT NULL,
    vehicle_placa VARCHAR(30) NOT NULL,
    PRIMARY KEY (driver_cpf, vehicle_placa),
    FOREIGN KEY (driver_cpf) REFERENCES drivers(cpf),
    FOREIGN KEY (vehicle_placa) REFERENCES vehicles(placa)
);