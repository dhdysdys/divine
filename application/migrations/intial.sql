USE divine

CREATE TABLE dataUser ( 
    kodeAdmin INT NOT NULL IDENTITY PRIMARY KEY, 
    namaUser VARCHAR(255) NOT NULL , 
    email VARCHAR(255) NULL , 
    password TEXT NOT NULL,
    role INT NOT NULL,
    registerDate DATETIME DEFAULT CURRENT_TIMESTAMP,
);

INSERT INTO dataUser (namaUser, email, password, role) VALUES ('admin', 'admin@gmail.com', 'admin', 0);

CREATE TABLE dataAlat ( 
    kodeAlat INT NOT NULL IDENTITY PRIMARY KEY , 
    namaAlat VARCHAR(255) NOT NULL , 
    tanggalAlatMasuk DATE NOT NULL,
    statusAlat INT NOT NULL , 
    hargaAlat INT NOT NULL,
    hargaRetail INT DEFAULT 0,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
);

CREATE TABLE dataAlatBaru ( 
    kodeAlat INT NOT NULL IDENTITY PRIMARY KEY , 
    namaAlat VARCHAR(255) NOT NULL, 
    hargaAlat INT NOT NULL,
    status INT NOT NULL , 
    alasan TEXT NOT NULL,
    alasanReject TEXT DEFAULT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
);