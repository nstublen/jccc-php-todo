CREATE DATABASE IF NOT EXISTS todo;

USE todo;

CREATE TABLE IF NOT EXISTS items(
  item_id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  completed BOOLEAN NOT NULL DEFAULT FALSE,
  description VARCHAR(512) NOT NULL,
  due_date DATETIME DEFAULT NULL,
  FULLTEXT(description),
  INDEX(created_date),
  INDEX(completed),
  INDEX(due_date)
);

# Create "todo_web_user".  If it already exists, it is dropped
# and re-created.
GRANT USAGE ON *.* TO 'todo_web_user'@'localhost';
DROP USER 'todo_web_user'@'localhost';
CREATE USER 'todo_web_user'@'localhost' IDENTIFIED BY 'password';

# Revoke any privileges given to the new user.
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'todo_web_user'@'localhost';

# Grant limited privileges and only on the items table.
GRANT SELECT, INSERT, UPDATE, DELETE ON todo.items TO 'todo_web_user'@'localhost';
