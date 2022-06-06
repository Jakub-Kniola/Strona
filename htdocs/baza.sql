CREATE TABLE users (
	user_id INT(11) AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	email VARCHAR(64) UNIQUE NOT NULL,
	phone VARCHAR(16),
	birthday VARCHAR(16),
	password VARCHAR(256) NOT NULL,
	PRIMARY KEY (user_id)
);

CREATE TABLE products (
	product_id INT(11) AUTO_INCREMENT,
	title VARCHAR(64) NOT NULL,
	subtitle VARCHAR(64) NOT NULL,
	category VARCHAR(64) NOT NULL,
	publisher VARCHAR(64) NOT NULL,
	released VARCHAR(4) NOT NULL,
	price DECIMAL(5,2) NOT NULL DEFAULT 0.0,
	discount DECIMAL(5, 2) NOT NULL DEFAULT 0.0,
	icon VARCHAR(128) NOT NULL,
	description TEXT NOT NULL,
	pictures TEXT NOT NULL,

	minimum_central_processing_unit VARCHAR(128) NOT NULL,
	minimum_graphics_processing_unit VARCHAR(128) NOT NULL,
	minimum_main_memory VARCHAR(128) NOT NULL,
	minimum_disc_space VARCHAR(128) NOT NULL,
	minimum_platforms VARCHAR(128) NOT NULL,

	recommended_central_processing_unit VARCHAR(128) NOT NULL,
	recommended_graphics_processing_unit VARCHAR(128) NOT NULL,
	recommended_main_memory VARCHAR(128) NOT NULL,
	recommended_disc_space VARCHAR(128) NOT NULL,
	recommended_platforms VARCHAR(128) NOT NULL,

	PRIMARY KEY (product_id)
);


CREATE TABLE paynament (
	id,
	token,
	state
)

CREATE TABLE purchase (
	purchase_id INT(11) AUTO_INCREMENT,
	user_id INT(11) NOT NULL,
	product_id INT(11) NOT NULL,
	token VARCHAR(32) NOT NULL,
	price DECIMAL(5,2) NOT NULL,
	completed BOOLEAN DEFAULT 0,
	date TIMESTAMP,
	key VARCHAR(255),
	PRIMARY KEY (purchase_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);



CREATE TABLE cart (
	user_id INT(11),
	product_id INT(11),
	PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);