CREATE DATABASE tasks
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE tasks;

CREATE TABLE statuses (
  id_status MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  status_name VARCHAR(128) UNIQUE NOT NULL
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Task statuses';

CREATE TABLE actions (
  id_status MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  action_name VARCHAR(128) UNIQUE NOT NULL
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Task action';

CREATE TABLE roles (
  id_role MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(128) UNIQUE NOT NULL
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='User roles';

CREATE TABLE categories (
  id_category MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(255) NOT NULL
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Specializations';

CREATE TABLE locations (
  id_location MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  city VARCHAR(128) NOT NULL,
  region VARCHAR(128),
  street VARCHAR(128)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Locations';

CREATE TABLE users (
  id_user MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_name VARCHAR(128) NOT NULL,
  email VARCHAR(128) NOT NULL UNIQUE,
  password VARCHAR(64) NOT NULL,
  telephone VARCHAR(11),
  skype VARCHAR(25),
  messenger VARCHAR(25),
  id_location MEDIUMINT,
  id_role MEDIUMINT,
  rating INT NOT NULL DEFAULT 0,
  date_of_birth TIMESTAMP NOT NULL,
  biography VARCHAR(255),
  avatar TEXT,
  last_active_time TIMESTAMP,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (id_role) REFERENCES roles(id_role),
  FOREIGN KEY (id_location) REFERENCES locations(id_location),

  INDEX email_password (email, password)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Users';

CREATE TABLE user_category (
  id_user_category MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_user MEDIUMINT NOT NULL,
  id_category MEDIUMINT NOT NULL,

  FOREIGN KEY (id_user) REFERENCES users(id_user),
  FOREIGN KEY (id_category) REFERENCES categories(id_category)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='User specializations';

CREATE TABLE portfolio (
  id_portfolio MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_user MEDIUMINT NOT NULL,
  file TEXT NOT NULL,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (id_user) REFERENCES users(id_user)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='User portfolio';

CREATE TABLE favorites (
  id_favorites MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_owner MEDIUMINT NOT NULL,
  id_executor MEDIUMINT NOT NULL,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (id_owner) REFERENCES users(id_user),
  FOREIGN KEY (id_executor) REFERENCES users(id_user)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Users in favorites';

CREATE TABLE tasks (
  id_task MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  task_name VARCHAR(128) NOT NULL,
  description TEXT NOT NULL,
  id_category MEDIUMINT NOT NULL,
  id_owner MEDIUMINT NOT NULL,
  id_executor MEDIUMINT NOT NULL,
  id_location MEDIUMINT,
  location_comment VARCHAR(128),
  id_status MEDIUMINT NOT NULL,
  price INT NOT NULL DEFAULT 0,
  view_count INT NOT NULL DEFAULT 0,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status_date TIMESTAMP NOT NULL,
  expiration_date TIMESTAMP NOT NULL,

  FOREIGN KEY (id_category) REFERENCES categories(id_category),
  FOREIGN KEY (id_owner) REFERENCES users(id_user),
  FOREIGN KEY (id_executor) REFERENCES users(id_user),
  FOREIGN KEY (id_location) REFERENCES locations(id_location),
  FOREIGN KEY (id_status) REFERENCES statuses(id_status),

  INDEX task_category (task_name, id_category)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Tasks';

CREATE FULLTEXT INDEX task_search ON tasks(task_name, description);

CREATE TABLE file_task (
  id_file_task MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_task MEDIUMINT NOT NULL,
  file TEXT NOT NULL,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (id_task) REFERENCES tasks(id_task)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Files for the task';

CREATE TABLE respond (
  id_respond MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_task MEDIUMINT NOT NULL,
  id_sender MEDIUMINT NOT NULL,
  text VARCHAR(255),
  respond_price INT,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  executor TINYINT(1) NOT NULL DEFAULT 0,

  FOREIGN KEY (id_task) REFERENCES tasks(id_task),
  FOREIGN KEY (id_sender) REFERENCES users(id_user),

  INDEX task_sender (id_task, id_sender)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Response to the task';

CREATE TABLE chat (
  id_chat MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_task MEDIUMINT NOT NULL,
  id_sender MEDIUMINT NOT NULL,
  id_recipient MEDIUMINT NOT NULL,
  text VARCHAR(255),
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (id_task) REFERENCES tasks(id_task),
  FOREIGN KEY (id_sender) REFERENCES users(id_user),
  FOREIGN KEY (id_recipient) REFERENCES users(id_user),

  INDEX chat_sender (id_task, id_sender)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Internal chat between owner and executor';

CREATE TABLE reviews (
  id_review MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_task MEDIUMINT NOT NULL,
  id_executor MEDIUMINT NOT NULL,
  text VARCHAR(255),
  rating TINYINT(1),
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (id_task) REFERENCES tasks(id_task),
  FOREIGN KEY (id_executor) REFERENCES users(id_user),

  INDEX review_executor (id_task, id_executor)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Feedback about executor';
