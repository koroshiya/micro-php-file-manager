CREATE DATABASE IF NOT EXISTS Mover CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE Mover;

CREATE TABLE IF NOT EXISTS User(
	userName varchar(30) not null unique, 
	userPassword char(40) not null,
	PRIMARY KEY (userName)
);

DELIMITER // 
DROP FUNCTION IF EXISTS insert_user //
CREATE FUNCTION insert_user(userName varchar(30), userPassword varchar(20)) RETURNS boolean
BEGIN 
DECLARE sha1Password char(40);
SET sha1Password = (SHA1(CONCAT(userName, userPassword, 'myEpicSaltthatisn142')));
INSERT INTO User(userName, userPassword) VALUES(userName, sha1Password);
RETURN true;
END // 
DELIMITER ;

DELIMITER // 
DROP FUNCTION IF EXISTS user_get_password_valid_by_name //
CREATE FUNCTION user_get_password_valid_by_name(userName varchar(30), password varchar(20)) RETURNS boolean
BEGIN 
DECLARE sha1Password char(40);
DECLARE userExists boolean;
DECLARE oldPass char(40);
SET userExists = EXISTS(SELECT 1 FROM User WHERE User.userName = userName);
IF NOT userExists THEN
RETURN false;
END IF;
select u.userPassword INTO oldPass FROM User AS u WHERE u.userName = userName;
SET sha1Password = (SHA1(CONCAT(userName, password, 'myEpicSaltthatisn142')));
RETURN STRCMP(oldPass, sha1Password) = 0;
END // 
DELIMITER ;