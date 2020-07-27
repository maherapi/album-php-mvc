BEGIN TRANSACTION;
DROP TABLE IF EXISTS "maher_users";
CREATE TABLE IF NOT EXISTS "maher_users" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	VARCHAR NOT NULL,
	"username"	VARCHAR NOT NULL UNIQUE,
	"email"	VARCHAR NOT NULL UNIQUE,
	"password"	VARCHAR NOT NULL,
	"created_at"	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	"user_category"	INTEGER,
	FOREIGN KEY("user_category") REFERENCES "maher_user_category"("id")
);
DROP TABLE IF EXISTS "maher_user_category";
CREATE TABLE IF NOT EXISTS "maher_user_category" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"category"	TEXT NOT NULL UNIQUE,
	"parent_id"	INTEGER,
	FOREIGN KEY("parent_id") REFERENCES "maher_user_category"("id")
);
DROP TABLE IF EXISTS "maher_albums";
CREATE TABLE IF NOT EXISTS "maher_albums" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"title"	VARCHAR NOT NULL,
	"description"	VARCHAR NOT NULL,
	"cover_image"	INTEGER NOT NULL,
	"created_at"	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	"user_id"	INTEGER
);
DROP TABLE IF EXISTS "maher_images";
CREATE TABLE IF NOT EXISTS "maher_images" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"image_url"	VARCHAR NOT NULL UNIQUE,
	"title"	VARCHAR NOT NULL,
	"album_id"	INTEGER NOT NULL,
	"created_at"	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO "maher_user_category" ("id","category","parent_id") VALUES 
 (1,'student',NULL),
 (2,'employee',NULL),
 (3,'full-time',2),
 (4,'part-time',2),
 (5,'high-schooler',1),
 (6,'undergraduate',1),
 (7,'software developer',3),
 (8,'web develper',7);
COMMIT;