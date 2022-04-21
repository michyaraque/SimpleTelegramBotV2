CREATE TABLE IF NOT EXISTS referral(
  id varchar(20) NULL,
  users_invited INT(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS task_entries(
  task_id INT NOT NULL,
  user_id BIGINT SIGNED NOT NULL,
  timestamp INT(15) NOT NULL,
  points_claimed BIT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tasks(
  id INT NOT NULL AUTO_INCREMENT,
  task_description VARCHAR(255) NOT NULL,
  task_type VARCHAR(20) NOT NULL,
  task_status BIT NOT NULL,
  task_points INT NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id BIGINT SIGNED NOT NULL,
  username varchar(30) NOT NULL,
  real_name varchar(60) NOT NULL,
  register_date INT(15) NOT NULL,
  rol_id INT(2) NOT NULL DEFAULT 0,
  term_conditions varchar(10) DEFAULT NULL,
  language varchar(4) NOT NULL DEFAULT 'es',
  banned INT(1) NOT NULL DEFAULT 0,
  referral_id varchar(20) DEFAULT NULL,
  referred_by varchar(20) DEFAULT NULL,
  task_points INT NOT NULL DEFAULT 0,
  PRIMARY KEY(id),
  UNIQUE KEY(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS conversation (
  user_id BIGINT SIGNED NOT NULL,
  step varchar(50) DEFAULT NULL,
  temp_data text DEFAULT NULL,
  FOREIGN KEY(user_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS roles (
  id INT(2) NOT NULL,
  name varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO roles VALUES (0, 'None'),(1, 'Editor'),(2, 'Moderator'),(999, 'Admin');

DELIMITER //
CREATE TRIGGER oncreate_user AFTER INSERT ON users
FOR EACH ROW BEGIN
  INSERT INTO conversation (user_id) VALUES (new.user_id);
  INSERT INTO entries (user_id) VALUES (new.user_id);
  INSERT INTO referral (id) VALUES (new.referral_id);
END
//

DELIMITER //
CREATE TRIGGER ondelete_user BEFORE DELETE ON users
FOR EACH ROW BEGIN
	DELETE FROM conversation WHERE user_id = OLD.user_id;
	DELETE FROM entries WHERE user_id = OLD.user_id;
  DELETE FROM referral WHERE id = OLD.referral_id;
END
//