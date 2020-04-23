CREATE DATABASE tasks
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE tasks;

CREATE TABLE statuses (
  id INT PRIMARY KEY AUTO_INCREMENT,
  status_name VARCHAR(128) UNIQUE NOT NULL,
  status_number INT NOT NULL
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Task statuses';

CREATE TABLE actions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  action_name VARCHAR(128) UNIQUE NOT NULL
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Task action';

CREATE TABLE roles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  role_name VARCHAR(128) UNIQUE NOT NULL
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='User roles';

CREATE TABLE categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  category_name VARCHAR(255) NOT NULL,
  icon VARCHAR(128)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Specializations';

CREATE TABLE cities (
  id INT PRIMARY KEY AUTO_INCREMENT,
  city VARCHAR(128) NOT NULL,
  latitude DECIMAL(9, 6),
  longitude DECIMAL(9, 6)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Locations';

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_name VARCHAR(128) NOT NULL,
  email VARCHAR(128) NOT NULL UNIQUE,
  password VARCHAR(64) NOT NULL,
  phone VARCHAR(25),
  skype VARCHAR(25),
  telegram VARCHAR(25),
  address VARCHAR(255),
  city_id INT,
  role_id INT,
  rating INT NOT NULL DEFAULT 0,
  date_of_birth TIMESTAMP NOT NULL,
  about TEXT,
  avatar VARCHAR(128),
  count_fails INT,
  count_viewers INT,
  last_active_time TIMESTAMP,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (role_id) REFERENCES roles(id),
  FOREIGN KEY (city_id) REFERENCES cities(id),

  INDEX email_password (email, password)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Users';

CREATE TABLE user_category (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  category_id INT NOT NULL,

  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='User specializations';

CREATE TABLE portfolio (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  file VARCHAR(128) NOT NULL,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='User portfolio';

CREATE TABLE favorites (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  favorite_user_id INT NOT NULL,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id ) REFERENCES users(id),
  FOREIGN KEY (favorite_user_id) REFERENCES users(id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Users in favorites';

CREATE TABLE tasks (
  id INT PRIMARY KEY AUTO_INCREMENT,
  task_name VARCHAR(128) NOT NULL,
  description TEXT NOT NULL,
  category_id INT NOT NULL,
  owner_id INT NOT NULL,
  executor_id INT,
  city_id INT,
  address VARCHAR(255),
  latitude DECIMAL(9, 6),
  longitude DECIMAL(9, 6),
  status_id INT DEFAULT 0,
  budget INT,
  view_count INT DEFAULT 0,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status_date TIMESTAMP NOT NULL,
  expiration_date TIMESTAMP,

  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (owner_id) REFERENCES users(id),
  FOREIGN KEY (executor_id) REFERENCES users(id),
  FOREIGN KEY (city_id) REFERENCES cities(id),
  FOREIGN KEY (status_id) REFERENCES statuses(id),

  INDEX task_category (task_name, category_id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Tasks';

CREATE FULLTEXT INDEX task_search ON tasks(task_name, description);

CREATE TABLE task_file (
  id INT PRIMARY KEY AUTO_INCREMENT,
  task_id INT NOT NULL,
  file VARCHAR(128) NOT NULL,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (task_id) REFERENCES tasks(id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Files for the task';

CREATE TABLE respond (
  id INT PRIMARY KEY AUTO_INCREMENT,
  task_id INT NOT NULL,
  sender_id INT NOT NULL,
  description TEXT,
  price INT,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (task_id) REFERENCES tasks(id),
  FOREIGN KEY (sender_id) REFERENCES users(id),

  INDEX task_sender (task_id, sender_id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Response to the task';

CREATE TABLE chat (
  id INT PRIMARY KEY AUTO_INCREMENT,
  task_id INT NOT NULL,
  sender_id INT NOT NULL,
  recipient_id INT NOT NULL,
  description TEXT,
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (task_id) REFERENCES tasks(id),
  FOREIGN KEY (sender_id) REFERENCES users(id),
  FOREIGN KEY (recipient_id) REFERENCES users(id),

  INDEX chat_sender (task_id, sender_id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Internal chat between owner and executor';

CREATE TABLE reviews (
  id INT PRIMARY KEY AUTO_INCREMENT,
  task_id INT NOT NULL,
  executor_id INT NOT NULL,
  description TEXT,
  rating TINYINT(1),
  creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (task_id) REFERENCES tasks(id),
  FOREIGN KEY (executor_id) REFERENCES users(id),

  INDEX review_executor (task_id, executor_id)
)ENGINE=InnoDB CHARACTER SET=UTF8 COMMENT='Feedback about executor';
