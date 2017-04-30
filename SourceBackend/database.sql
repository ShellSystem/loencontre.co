USE goodfirm_entregas;

CREATE TABLE IF NOT EXISTS posts(
	id 				INT NOT NULL AUTO_INCREMENT,
	name			VARCHAR(255) NOT NULL,
	image			VARCHAR(255) NOT NULL,
	contact			VARCHAR(255) NOT NULL,
	date			Date	 NOT NULL,
	PRIMARY KEY(id)
);