-- データベースとテーブルを作成するSQL文
/*
    コマンドラインで実行する例: 
    mysql -u root -p 
    ↓ 
    (パスワード入力)
    ↓
    source schema.sql;
*/

-- データベースを作成（すでに存在する場合は作成しない）
-- IF NOT EXISTS: データベースが存在しない場合のみ作成し、既に存在する場合はエラーを出さずにスキップ
CREATE DATABASE IF NOT EXISTS sampledb;

-- 使用するデータベースを指定
USE sampledb;

-- usersテーブルを作成（すでに存在する場合は作成しない）
-- IF NOT EXISTS: テーブルが存在しない場合のみ作成し、既に存在する場合はエラーを出さずにスキップ
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name  VARCHAR(50)  NOT NULL,
  email VARCHAR(100) NOT NULL
);