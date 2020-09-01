BEGIN TRANSACTION;
DROP TABLE IF EXISTS "maher_notifications";
CREATE TABLE IF NOT EXISTS "maher_notifications" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"title"	TEXT NOT NULL,
	"description"	TEXT NOT NULL,
	"target_user"	INTEGER NOT NULL,
	"read_status"	INTEGER NOT NULL DEFAULT 0,
	FOREIGN KEY("target_user") REFERENCES "maher_users"("id")
);
DROP TABLE IF EXISTS "maher_users";
CREATE TABLE IF NOT EXISTS "maher_users" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	VARCHAR NOT NULL,
	"username"	VARCHAR NOT NULL UNIQUE,
	"email"	VARCHAR NOT NULL UNIQUE,
	"password"	VARCHAR NOT NULL,
	"created_at"	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	"user_category"	INTEGER,
	"is_admin"	INTEGER NOT NULL DEFAULT 0,
	"is_activated"	INTEGER NOT NULL DEFAULT 0,
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
INSERT INTO "maher_users" ("id","name","username","email","password","created_at","user_category","is_admin","is_activated") VALUES (2,'Maher','maher','maher@maher.com','$2y$10$j6TyP2wEjtbHxhdQrdPXlu7gL59E9Ty0PNEk.k3zAtFM2AyEsOXfO','2020-06-30 09:15:25',1,1,1);
COMMIT;
