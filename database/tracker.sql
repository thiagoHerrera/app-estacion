CREATE TABLE tracker (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    latitud VARCHAR(50),
    longitud VARCHAR(50),
    pais VARCHAR(100),
    navegador TEXT,
    sistema VARCHAR(255),
    add_date DATETIME DEFAULT CURRENT_TIMESTAMP
);